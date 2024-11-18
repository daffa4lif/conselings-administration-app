<?php

namespace App\Services\Impl;

use App\Exceptions\SpreadsheetException;
use App\Services\SpreadsheetService;
use Illuminate\Support\Facades\Storage;

class SpreadsheetServiceImpl implements SpreadsheetService
{
    // tipe format spreadsheet
    const ALLOWEDFORMAT = [
        \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLS,
        \PhpOffice\PhpSpreadsheet\IOFactory::READER_XLSX,
        \PhpOffice\PhpSpreadsheet\IOFactory::READER_CSV,
    ];

    public function read(string $pathFile, string $storageDriver = 'local'): \PhpOffice\PhpSpreadsheet\Spreadsheet
    {
        if (!Storage::disk($storageDriver)->exists($pathFile)) {
            throw new \Exception('file not found');
        }

        $pathFile = Storage::disk($storageDriver)->path($pathFile);

        try {
            /**  Identify the type of $inputFileName  **/
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($pathFile, self::ALLOWEDFORMAT);

            /** Load $inputFileName to a Spreadsheet Object  **/
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

            /**  Advise the Reader that we only want to load cell data  **/
            $reader->setReadDataOnly(true);

            $reader->setLoadAllSheets();

            /**  Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = $reader->load($pathFile);

            return $spreadsheet;
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            throw $e;
        }
    }

    /**
     * Summary of validateAndMappingInputColumnIndex
     * 
     * validasi inputan yang datang, return sebuah error exception dan mapping menjadi sebuah array
     * @param string $firstColumnIndex
     * @param string $lastColumnIndex
     * @throws \Exception
     * @return array
     */
    private function validateAndMappingInputColumnIndex(string $firstColumnIndex, string $lastColumnIndex): array
    {
        if (is_numeric($firstColumnIndex) || is_numeric($lastColumnIndex)) {
            throw new \Exception("only support alphabet string");
        }

        if (strlen($firstColumnIndex) > 1 || strlen($lastColumnIndex) > 1) {
            throw new \Exception("hanya satu huruf alphabet yang diperbolehkan");
        }

        // translate
        $firstColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($firstColumnIndex);
        $lastColumnIndex  = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumnIndex);

        return [
            'first' => $firstColumnIndex,
            'last' => $lastColumnIndex
        ];
    }

    public function validateColumnNames(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeSpreadsheet, string $firstColumnIndex, string $lastColumnIndex, array $allowedNames): bool
    {
        if (is_numeric($firstColumnIndex) || is_numeric($lastColumnIndex)) {
            throw new \Exception("only support alphabet string");
        }

        if (strlen($firstColumnIndex) > 1 || strlen($lastColumnIndex) > 1) {
            throw new \Exception("hanya satu huruf alphabet yang diperbolehkan");
        }


        $firstColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($firstColumnIndex);
        $lastColumnIndex  = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($lastColumnIndex);

        $firstRow = 1;
        $lastRow  = 1;
        $datas    = [];

        // mapping header col
        for ($row = $firstRow; $row <= $lastRow; ++$row) {
            for ($col = $firstColumnIndex; $col <= $lastColumnIndex; ++$col) {
                $datas[$col - 1] = $activeSpreadsheet->getCell([$col, $row])->getValue();
            }
        }

        // jika panjang data yang ada di file head dan header allowed tidak sama
        if (count($datas) != count($allowedNames)) {
            throw new \Exception("panjang header col tidak sama");
        }

        // jika ada value yang tidak sesuai antara ke dua data
        foreach ($datas as $key => $item) {
            if ($allowedNames[$key] !== $datas[$key]) {
                throw new SpreadsheetException("header tidak sesuai dengan format");
            }
        }

        return true;
    }

    public function exportsDataCellInto2DArray(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeSpreadsheet, string $firstColumnIndex, string $lastColumnIndex): array
    {
        $highestRow = $activeSpreadsheet->getHighestRow();

        if ($highestRow < 1) {
            throw new SpreadsheetException("tidak dapat membaca data atau data kosong");
        }

        $columnIndex = $this->validateAndMappingInputColumnIndex($firstColumnIndex, $lastColumnIndex);

        // mapping header col
        $datas = [];
        for ($row = 1; $row <= $highestRow; ++$row) {
            for ($col = $columnIndex['first']; $col <= $columnIndex['last']; ++$col) {
                $datas[$row][$col] = $activeSpreadsheet->getCell([$col, $row])->getValue();
            }
        }

        return $datas;
    }
}