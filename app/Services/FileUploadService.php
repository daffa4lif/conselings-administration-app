<?php

namespace App\Services;

interface FileUploadService
{
    /**
     * Summary of uploadTemp
     * 
     * upload file ke temporarry folder
     * @return string
     */
    function uploadTemp(\Illuminate\Http\Request $request): string|bool;

    /**
     * Summary of revertTemp
     * 
     * revert file yang telah diupload di temp
     * @return bool
     */
    function revertTemp(\Illuminate\Http\Request $request): bool;
}