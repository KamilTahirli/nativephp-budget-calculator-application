<?php

namespace App\Services\Common;

use App\Interfaces\PhotoUploadInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class PhotoUploadService implements PhotoUploadInterface
{
    public function store($file, $folder)
    {
        try {
            $photoName = md5(time() . rand(0, 1000)) . '.' . $file->extension();
            $file->storeAs($folder, $photoName);
            return $photoName;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
