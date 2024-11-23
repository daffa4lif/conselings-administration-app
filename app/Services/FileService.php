<?php

namespace App\Services;

interface FileService
{
    /**
     * Summary of getTempPathFile
     * 
     * get path storage local og temp file target
     * @param int $tempFolderNumber
     * @return string
     */
    function getTempPathFile(int $tempFolderNumber): string;

    /**
     * Summary of deleteTempData
     * 
     * delet file and data by folder temp name
     * @param int $tempFolderNumber
     * @return bool
     */
    function deleteTempData(int $tempFolderNumber): bool;

    function downloadExportFile(string $filePath): void;
}