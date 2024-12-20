<?php

namespace App\Services\Impl;

use App\Models\FileTemp;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;

class FileUploadServiceImpl implements FileUploadService
{
    private const TEMP_PATH = "temp/";

    public function uploadTemp(\Illuminate\Http\Request $request): bool|string
    {
        // return false;
        // get request has files
        foreach ($request->allFiles() as $key => $itemFilesReq) {

            logDebug('request file masuk', [
                $key
            ]);

            // jika multy file
            if (is_array($itemFilesReq)) {

                // ambil tiap data array
                foreach ($itemFilesReq as $item) {
                    $folder = rand();
                    $file   = \Illuminate\Support\Str::random() . "-" . $item->getClientOriginalName();

                    Storage::disk("public")->putFileAs(self::TEMP_PATH . $folder, $item, $file);

                    FileTemp::create([
                        'folder' => $folder,
                        'file' => $file,
                        'user_id' => auth()->user()->id
                    ]);

                    return $folder;
                }
            }

            // jika single file
            if ($request->hasFile($key)) {
                $folder = rand();

                $file = \Illuminate\Support\Str::random() . "-" . $request->file($key)->getClientOriginalName();

                Storage::disk("local")->putFileAs(self::TEMP_PATH . $folder, $request->file($key), $file);

                FileTemp::create([
                    'folder' => $folder,
                    'file' => $file,
                    'user_id' => auth()->user()->id
                ]);

                return $folder;
            }
        }

        return false;
    }

    public function revertTemp(\Illuminate\Http\Request $request): bool
    {
        $temp = FileTemp::where('folder', $request->getContent())->first();
        Storage::disk('local')->deleteDirectory(self::TEMP_PATH . $request->getContent());
        $temp->delete();

        return true;
    }
}