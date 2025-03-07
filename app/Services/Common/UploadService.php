<?php

namespace App\Services\Common;

use App\Interfaces\PhotoUploadInterface;

readonly class UploadService
{
    /**
     * @param PhotoUploadInterface $photoUpload
     */
    public function __construct(private PhotoUploadInterface $photoUpload)
    {
    }

    /**
     * @param $photo
     * @param $path
     * @return mixed
     */
    public function uploadPhoto($photo, $path): mixed
    {
        return $this->photoUpload->store($photo, $path);
    }
}
