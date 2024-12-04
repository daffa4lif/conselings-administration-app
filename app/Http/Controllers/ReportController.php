<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    private $spService;
    private $fileService;

    public function __construct(\App\Services\FileService $fileService, \App\Services\SpreadsheetService $spreadsheetService)
    {
        $this->spService   = $spreadsheetService;
        $this->fileService = $fileService;
    }

    public function indexAbsents()
    {
        $absents = \App\Models\Absent::selectRaw('YEAR(violation_date) as year, MONTH(violation_date) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->get();

        $datas = [];
        foreach ($absents as $rekap) {
            $year  = $rekap['year'];
            $month = $rekap['month'];
            $total = $rekap['total'];

            // Inisialisasi array untuk setiap tahun jika belum ada
            if (!isset($datas[$year])) {
                $datas[$year] = array_fill(0, 12, null);
            }

            // Isi array bulan sesuai dengan datanya
            $datas[$year][$month - 1] = $total;
        }

        $results = [];
        foreach ($datas as $year => $totals) {
            $results[] = [
                'name' => (string) $year,
                'data' => $totals
            ];
        }

        return view("pages.report.absent", compact("results"));
    }

    public function printAbsents(Request $request)
    {
        $absents = \App\Models\Absent::with('student');

        if ($request->has('type') && in_array($request->input('type'), ['IZIN', 'ALPHA', 'SAKIT'])) {
            $absents = $absents->where('type', $request->input('type'));
        }

        $absents = $request->has('year') ? $absents->whereYear('violation_date', $request->input('year')) : $absents->whereYear('violation_date', now()->format('Y'));

        $spreadsheet = $this->spService->create();
        $worksheet   = $spreadsheet->getActiveSheet();

        try {
            $worksheet = $this->spService->setCellsValues($worksheet, [
                'No',
                'Tanggal Kejadian',
                'Tanggal Buat',
                'NIM',
                'Nama',
                'Tipe',
                'Keterangan'
            ]);

            $absents = $absents->get()->map(function ($absent, $key) {
                return [
                    $key + 1,
                    $absent->violation_date,
                    $absent->created_at,
                    $absent->student->nis,
                    $absent->student->name,
                    $absent->type,
                    $absent->description
                ];
            });


            // isi cell
            foreach ($absents as $key => $value) {
                $worksheet = $this->spService->setCellsValues($worksheet, $value, $key + 2);
            }

            $path = $this->spService->spreadsheetExportToXlsx($spreadsheet, 'rekap-absent-siswa-' . $request->input('year') ?? now()->format('Y'));

            $this->fileService->downloadExportFile($path);

        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function indexCases(Request $request)
    {
        $cases = \App\Models\StudenCase::selectRaw('YEAR(created_at) as year, type, COUNT(*) as total')
            ->groupBy('year', 'type')
            ->orderBy('year', 'desc')
            ->get();

        $years = $cases->groupBy('year');
        $datas = [];
        foreach ($years as $year) {
            foreach ($year as $item) {
                $datas[$item->type][] = $item->total;
            }
        }

        $results = [];
        foreach ($datas as $key => $value) {
            $results[] = [
                'name' => $key,
                'data' => $datas[$key]
            ];
        }

        $rekaps = [];
        foreach ($results as $items) {
            $rekaps[$items['name']] = array_sum($items['data']);
        }

        $categories = $years->keys()->toArray();

        return view("pages.report.case", compact("categories", "results", "rekaps"));
    }

    public function printCasesStudent(Request $request)
    {
        $cases = \App\Models\StudenCase::with('student');

        if ($request->has('type') && in_array($request->input('type'), ['RINGAN', 'SEDANG', 'BESAR'])) {
            $cases = $cases->where('type', $request->input('type'));
        }

        $cases = $request->has('year') ? $cases->whereYear('created_at', $request->input('year')) : $cases->whereYear('created_at', now()->format('Y'));

        $spreadsheet = $this->spService->create();
        $worksheet   = $spreadsheet->getActiveSheet();

        try {
            $worksheet = $this->spService->setCellsValues($worksheet, [
                'No',
                'Tanggal Buat',
                'NIM',
                'Nama',
                'Kasus',
                'Tipe',
                'Point',
                'Solusi'
            ]);

            $cases = $cases->get()->map(function ($case, $key) {
                return [
                    $key + 1,
                    $case->created_at,
                    $case->student->nis,
                    $case->student->name,
                    $case->case,
                    $case->type,
                    $case->point,
                    $case->solution,
                ];
            });

            // isi cell
            foreach ($cases as $key => $value) {
                $worksheet = $this->spService->setCellsValues($worksheet, $value, $key + 2);
            }

            $path = $this->spService->spreadsheetExportToXlsx($spreadsheet, 'rekap-kasus-siswa-' . $request->input('year') ?? now()->format('Y'));

            $this->fileService->downloadExportFile($path);

        } catch (\Throwable $th) {
            dd($th);
            return self::redirectResponseServerError();
        }
    }

    public function indexHomeVisits()
    {
        return view("pages.report.home-visit");
    }

    public function printHomeVisits(Request $request)
    {
        $visits = \App\Models\HomeVisit::with('student');

        if ($request->has('status') && in_array($request->input('status'), ['FINISH', 'PROCESS'])) {
            $visits = $visits->where('status', $request->input('status'));
        }

        $visits = $request->has('year') ? $visits->whereYear('created_at', $request->input('year')) : $visits->whereYear('created_at', now()->format('Y'));

        $spreadsheet = $this->spService->create();
        $worksheet   = $spreadsheet->getActiveSheet();

        try {
            $worksheet = $this->spService->setCellsValues($worksheet, [
                'No',
                'Tanggal Buat',
                'NIM',
                'Nama',
                'Nama Wali',
                'Kasus',
                'Solusi',
                'Status',
            ]);

            $visits = $visits->get()->map(function ($visit, $key) {
                return [
                    $key + 1,
                    $visit->created_at,
                    $visit->student->nis,
                    $visit->student->name,
                    $visit->parent_name,
                    $visit->case,
                    $visit->solution,
                    $visit->status
                ];
            });

            // isi cell
            foreach ($visits as $key => $value) {
                $worksheet = $this->spService->setCellsValues($worksheet, $value, $key + 2);
            }

            $path = $this->spService->spreadsheetExportToXlsx($spreadsheet, 'rekap-kunjungan-rumah-' . $request->input('year') ?? now()->format('Y'));

            $this->fileService->downloadExportFile($path);

        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function indexConselings()
    {
        $conselings = \App\Models\Conseling\Conseling::select(
            'category',
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(id) as total')
        )
            ->whereYear('created_at', 2024)
            ->groupBy('category', 'month')
            ->orderBy('month', 'asc')
            ->get();

        $datas = [];
        foreach ($conselings as $data) {
            $category = $data->category;
            $month    = $data->month;
            $total    = $data->total;

            // Inisialisasi array untuk setiap kategori jika belum ada
            if (!isset($datas[$category])) {
                $datas[$category] = array_fill(0, 12, null); // 12 bulan, mulai dari 0
            }

            // Masukkan data ke dalam array bulan
            $datas[$category][$month - 1] = $total;
        }

        $results = [];
        foreach ($datas as $category => $totals) {
            $results[] = [
                'name' => $category,
                'data' => $totals
            ];
        }

        return view("pages.report.conseling", compact("results"));
    }

    public function printConselings(Request $request)
    {
        $conselings = \App\Models\Conseling\Conseling::with('student');

        if ($request->has('status') && in_array($request->input('status'), ['FINISH', 'PROCESS'])) {
            $conselings = $conselings->where('status', $request->input('status'));
        }

        $conselings = $request->has('year') ? $conselings->whereYear('created_at', $request->input('year')) : $conselings->whereYear('created_at', now()->format('Y'));

        $spreadsheet = $this->spService->create();
        $worksheet   = $spreadsheet->getActiveSheet();

        try {
            $worksheet = $this->spService->setCellsValues($worksheet, [
                'No',
                'Tanggal Buat',
                'NIM',
                'Nama',
                'Kasus',
                'Solusi',
                'Status',
            ]);

            $conselings = $conselings->get()->map(function ($conseling, $key) {
                return [
                    $key + 1,
                    $conseling->created_at,
                    $conseling->student->nis,
                    $conseling->student->name,
                    $conseling->case,
                    $conseling->solution,
                    $conseling->status,
                ];
            });

            // isi cell
            foreach ($conselings as $key => $value) {
                $worksheet = $this->spService->setCellsValues($worksheet, $value, $key + 2);
            }

            $path = $this->spService->spreadsheetExportToXlsx($spreadsheet, 'rekap-konseling-individu-' . $request->input('year') ?? now()->format('Y'));

            $this->fileService->downloadExportFile($path);

        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }

    public function indexConselingsGroup()
    {
        $conselings = \App\Models\Conseling\ConselingGroup::select(
            'category',
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(id) as total')
        )
            ->whereYear('created_at', 2024)
            ->groupBy('category', 'month')
            ->orderBy('month', 'asc')
            ->get();

        $datas = [];
        foreach ($conselings as $data) {
            $category = $data->category;
            $month    = $data->month;
            $total    = $data->total;

            // Inisialisasi array untuk setiap kategori jika belum ada
            if (!isset($datas[$category])) {
                $datas[$category] = array_fill(0, 12, null); // 12 bulan, mulai dari 0
            }

            // Masukkan data ke dalam array bulan
            $datas[$category][$month - 1] = $total;
        }

        $results = [];
        foreach ($datas as $category => $totals) {
            $results[] = [
                'name' => $category,
                'data' => $totals
            ];
        }

        return view("pages.report.conseling-group", compact("results"));
    }

    public function printConselingsGroup(Request $request)
    {
        $conselingsGroup = \App\Models\Conseling\ConselingGroup::with('students');

        if ($request->has('status') && in_array($request->input('status'), ['FINISH', 'PROCESS'])) {
            $conselingsGroup = $conselingsGroup->where('status', $request->input('status'));
        }

        $conselingsGroup = $request->has('year') ? $conselingsGroup->whereYear('created_at', $request->input('year')) : $conselingsGroup->whereYear('created_at', now()->format('Y'));

        $spreadsheet = $this->spService->create();
        $worksheet   = $spreadsheet->getActiveSheet();

        try {
            $worksheet = $this->spService->setCellsValues($worksheet, [
                'No',
                'Tanggal Buat',
                'Siswa Grup',
                'Kasus',
                'Solusi',
                'Status',
            ]);

            $conselingsGroup = $conselingsGroup->get()->map(function ($item, $key) {

                $student = $item->students->map(function ($student) {
                    return "$student->nis $student->name";
                })->toArray();

                return [
                    $key + 1,
                    $item->created_at,
                    $student > 0 ? implode(", ", $student) : null,
                    $item->case,
                    $item->solution,
                    $item->status
                ];
            });

            // isi cell
            foreach ($conselingsGroup as $key => $value) {
                $worksheet = $this->spService->setCellsValues($worksheet, $value, $key + 2);
            }

            $path = $this->spService->spreadsheetExportToXlsx($spreadsheet, 'rekap-konseling-kelompok-' . $request->input('year') ?? now()->format('Y'));

            $this->fileService->downloadExportFile($path);

        } catch (\Throwable $th) {
            return self::redirectResponseServerError();
        }
    }
}
