<?php

namespace App\Interfaces;

interface PhotoUploadInterface
{

    public function store($file, $folder);
}
