<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
trait ImageUploadTrait
{
    public function uploadImage(UploadedFile $imageFile, string $slug)
    {
        $newimage = uniqid() . '-' . $slug . '.' . $imageFile->extension();
          $image = Image::read($imageFile)
          ->resize(1300, 600)
          ->encode();
          Storage::disk('public')->put("uploads/{$newimage}", $image);
          return $newimage;
    }
}
