<?php

namespace App\Services;

interface SpreadsheetService
{

    /**
     * Summary of create
     * 
     * membuat object spreadsheet
     * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    function create(): \PhpOffice\PhpSpreadsheet\Spreadsheet;

    /**
     * Summary of read
     * 
     * membaca file excel yang ada menjadi spreadsheet object
     * @param string $pathFile
     * @param string $storageDriver
     * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    function read(string $pathFile, string $storageDriver = 'local'): \PhpOffice\PhpSpreadsheet\Spreadsheet;


    /**
     * Summary of setCellsValues
     * 
     * mengisi cell pada worksheet dengan value yang sudah ditentukan
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeSpreadsheet
     * @param \Illuminate\Support\Collection|array $collection
     * @param int $row
     * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    function setCellsValues(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $worksheet, \Illuminate\Support\Collection|array $collection, int $row = 1): \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


    /**
     * Summary of validateColumn
     * 
     * memvalidasi header cel yang ada, pastikan harus urut, dari kiri ke kanan
     * @param string $firstColumnIndex
     * @param string $lastColumnIndex
     * @param array $colHeaderAllowed
     * @return bool
     */
    function validateColumnNames(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeSpreadsheet, string $firstColumnIndex, string $lastColumnIndex, array $allowedNames): bool;


    /**
     * Summary of exportsDataCellInto2DArray
     * 
     * export data worksheet menjadi data 2D array
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeSpreadsheet
     * @param string $firstColumnIndex
     * @param string $lastColumnIndex
     * @return array
     */
    function exportsDataCellInto2DArray(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeSpreadsheet, string $firstColumnIndex, string $lastColumnIndex): array;

    /**
     * Summary of spreadsheetExportToXlsx
     * 
     * export spreadsheet yang telah terdata menjadi file,
     * return berupa path file
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @param string $nameFile
     * @return string
     */
    function spreadsheetExportToXlsx(\PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet, string $nameFile = null): string;
}