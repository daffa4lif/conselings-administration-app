<?php

namespace App\Services\Impl;

use App\Models\Absent;
use App\Services\AbsentService;
use App\Services\FileService;
use App\Services\SpreadsheetService;
use Illuminate\Support\Facades\DB;

class AbsentServiceImpl implements AbsentService
{
    private $fileService;
    private $spService;

    public function __construct(FileService $fileService, SpreadsheetService $spreadsheetService)
    {
        $this->fileService = $fileService;
        $this->spService   = $spreadsheetService;
    }

    public function createNewAbsentsBySpreadsheetTemp(int $folderTemp, string $date): array
    {
        if (\DateTime::createFromFormat('Y-m-d H:i:s', $date) === false) {
            throw new \Exception("date variabel is not a date");
        }

        // define range file cols
        $columnRange = [
            'first' => 'A',
            'last' => 'H'
        ];

        $pathTemp = $this->fileService->getTempPathFile($folderTemp);

        $worksheet = $this->spService->read($pathTemp)->getActiveSheet();

        // validate file, data header
        $this->spService->validateColumnNames($worksheet, $columnRange['first'], $columnRange['last'], [
            'NO',
            'NIS', // 2
            'NAMA',
            'TIPE', // 4
            'KETERANGAN'
        ]);

        // export data worksheet
        $worksheetDatas = $this->spService->exportsDataCellInto2DArray($worksheet, $columnRange['first'], $columnRange['last']);
        array_shift($worksheetDatas); // delete header cols

        // cleaning null baris
        $datas = array_filter($worksheetDatas, function ($subArray) {
            return array_filter($subArray) !== []; // Cek apakah ada nilai non-null di sub-array
        });

        try {
            $userId  = auth()->user()->id;
            $reports = [];

            DB::beginTransaction();

            foreach ($datas as $data) {

                // jika terdapat data yang kosong pada 1 baris tersebut
                if (in_array(null, $data)) {
                    $reports['error']['emptys'][] = $data;
                    continue;
                }

                $student = \App\Models\Master\Student::where('nis', $data['2'])->first();
                // jika tidak ada data siswa
                if (!$student) {
                    $reports['error']['unknown'][] = $data;
                    continue;
                }

                // cek jika tidak ada buat
                $absent = Absent::firstOrCreate([
                    'student_id' => $student->id,
                    'type' => \Illuminate\Support\Str::upper(trim($data['4'])),
                    'violation_date' => date('Y-m-d', strtotime($date))
                ], [
                    'student_id' => $student->id,
                    'type' => \Illuminate\Support\Str::upper(trim($data['4'])),
                    'violation_date' => date('Y-m-d', strtotime($date)),
                    'user_id' => $userId
                ]);

                // jika data absent ada
                if (!$absent->wasRecentlyCreated) {
                    $reports['error']['duplicate'][] = $data;
                }

                $reports['create'][] = $data;
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }

        return $reports;
    }
}