<?php

namespace App\Services\Impl;

use App\Models\FileTemp;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;

class FileServiceImpl implements FileService
{
    private const TEMP_PATH = "temp/";

    public function getTempPathFile(int $tempFolderNumber): string
    {
        $temp = FileTemp::where('folder', $tempFolderNumber)->first();

        if (!$temp) {
            throw new \Exception("temp tidak ditemukan");
        }

        if (!Storage::disk("local")->exists(self::TEMP_PATH . $temp->folder)) {
            throw new \Exception("file target not exists");
        }

        return self::TEMP_PATH . "$temp->folder/$temp->file";
    }

    public function deleteTempData(int $tempFolderNumber): bool
    {
        $temp = FileTemp::where('folder', $tempFolderNumber)->first();
        if ($temp) {
            Storage::disk('local')->deleteDirectory(self::TEMP_PATH . $tempFolderNumber);
            $temp->delete();

            return true;
        }

        return false;
    }

    public function downloadExportFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \Exception("file not exists");
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        unlink($filePath);
    }
}