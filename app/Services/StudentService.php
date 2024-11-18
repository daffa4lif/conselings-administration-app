<?php

namespace App\Services;

interface StudentService
{
    /**
     * Summary of createNewStudentsBySpreadsheetTemp
     * 
     * mengolah data siswa dan menyimpannya ke database, dengan return sebuah `reports`.
     * 
     * `created`, berhasil disimpan, `error` gagal disimpan
     * @param int $folderTemp
     * @return array
     */
    function createNewStudentsBySpreadsheetTemp(int $folderTemp): array;

    /**
     * Summary of registerStudentsClassroom
     * 
     * mendaftarkan siswa yang sudah terdaftar berdasarkan tahun angkatan dan nama kelas terdata menggunakan spreadsheet. return berupa sebuah `reports`.
     * @param int $folderTemp
     * @param \App\Models\Master\Classroom $classroom
     * @param int $year
     * @return array
     */
    function registerStudentsClassroom(int $folderTemp, \App\Models\Master\Classroom $classroom, int $year): array;
}