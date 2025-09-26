<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class DeleteFile
{
    public static function cleanImage(string $path,string $default)
    {
       $filename = basename($path);
     if ($filename !== $default && Storage::disk('public')->exists($path)) {
        Storage::disk('public')->delete($path);
    }
    }
    public static function existImage(string $path): void
    {
       $filename = basename($path);

      if ($filename && Storage::disk('public')->exists($path)) {
           Storage::disk('public')->delete($path);
        }
    }

}
