<?php

namespace App\Services\Impl;

use App\Models\Master\Student;
use App\Services\FileService;
use App\Services\SpreadsheetService;
use App\Services\StudentService;
use Illuminate\Support\Facades\DB;

class StudentServiceImpl implements StudentService
{
    private $fileService;
    private $spService;

    public function __construct(FileService $fileService, SpreadsheetService $spreadsheetService)
    {
        $this->fileService = $fileService;
        $this->spService   = $spreadsheetService;
    }

    public function createNewStudentsBySpreadsheetTemp(int $folderTemp): array
    {
        // define range file cols
        $columnRange = [
            'first' => 'A',
            'last' => 'E'
        ];

        $pathTemp = $this->fileService->getTempPathFile($folderTemp);

        $worksheet = $this->spService->read($pathTemp)->getActiveSheet();

        // validate file, data header
        $this->spService->validateColumnNames($worksheet, $columnRange['first'], $columnRange['last'], [
            'NO',
            'NIS',
            'NAMA',
            'KELAMIN',
            'ALAMAT'
        ]);

        // export data worksheet
        $worksheetDatas = $this->spService->exportsDataCellInto2DArray($worksheet, $columnRange['first'], $columnRange['last']);
        array_shift($worksheetDatas); // delete header cols

        // cleaning null baris
        $datas = array_filter($worksheetDatas, function ($subArray) {
            return array_filter($subArray) !== []; // Cek apakah ada nilai non-null di sub-array
        });

        try {
            DB::beginTransaction();

            $reports = [];
            foreach ($datas as $key => $siswaDatas) {
                if (in_array(trim($siswaDatas['4']), ['PRIA', 'WANITA']) && !in_array(null, $siswaDatas) && is_numeric(trim($siswaDatas['2']))) {
                    $siswa = Student::firstOrCreate(['nis' => trim($siswaDatas['2'])], [
                        'nis' => trim($siswaDatas['2']),
                        'name' => trim($siswaDatas['3']),
                        'gender' => trim($siswaDatas['4']),
                        'address' => trim($siswaDatas['5']) ?? null
                    ]);

                    if ($siswa->wasRecentlyCreated) {
                        $reports['create'][] = $siswaDatas;
                    } else {
                        $reports['error']['duplicate'][] = $siswaDatas;
                    }
                } else {
                    $reports['error']['syntax'][] = $siswaDatas;
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        // delete temp file and data
        $this->fileService->deleteTempData($folderTemp);

        return $reports;
    }

    public function registerStudentsClassroom(int $folderTemp, \App\Models\Master\Classroom $classroom, int $year): array
    {
        // define range file cols
        $columnRange = [
            'first' => 'A',
            'last' => 'D'
        ];

        $pathTemp = $this->fileService->getTempPathFile($folderTemp);

        $worksheet = $this->spService->read($pathTemp)->getActiveSheet();

        // validate file, data header
        $this->spService->validateColumnNames($worksheet, $columnRange['first'], $columnRange['last'], [
            'NO', // 1
            'NIS', // 2
            'NAMA', // 3
            'KELAMIN' // 4
        ]);

        // export data worksheet
        $worksheetDatas = $this->spService->exportsDataCellInto2DArray($worksheet, $columnRange['first'], $columnRange['last']);
        array_shift($worksheetDatas); // delete header cols

        // cleaning null baris
        $datas = array_filter($worksheetDatas, function ($subArray) {
            return array_filter($subArray) !== []; // Cek apakah ada nilai non-null di sub-array
        });

        try {
            DB::beginTransaction();

            $reports = [];
            foreach ($datas as $data) {
                $student = Student::with("classroom")->where('nis', (int) $data['2'])->first();

                // jika data siswa tidak ditemukan pada database
                if (!$student) {
                    $reports['error']['unknown'][] = $data;
                    continue;
                }

                // jika data siswa double dalam database
                if ($student->classroom()->where(['classroom_id' => $classroom->id, 'year' => $year])->exists()) {
                    $reports['error']['duplicate'][] = $data;
                    continue;
                }

                // jika ada data yang tahun ajarannya sama
                if ($student->classroom()->where('year', $year)->exists()) {
                    $reports['error']['same'][] = $data;
                    continue;
                }

                // buat data baru
                $student->classroom()->create([
                    'classroom_id' => $classroom->id,
                    'year' => $year
                ]);

                $reports['create'][] = $data;
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        // delete temp file and data
        $this->fileService->deleteTempData($folderTemp);

        return $reports;
    }
}