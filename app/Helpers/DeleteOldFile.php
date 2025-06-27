<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class DeleteOldFile
{
    public static function Cleanimage(string $path,string $default)
    {
       $filename = basename($path);
    if ($filename !== $default && Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
    }
    }
}
