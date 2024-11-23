<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view("pages.report.absent");
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
                    $absent->violation_date,
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
        return view("pages.report.conseling");
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
        return view("pages.report.conseling-group");
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
