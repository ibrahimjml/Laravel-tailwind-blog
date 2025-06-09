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
    public function uploadAvatarImage(UploadedFile $imageFile, string $username)
    {
        $newavatar = uniqid() . '-avatar-'.$username . '.' . $imageFile->extension();
          $image = Image::read($imageFile)
          ->resize(150, 150)
          ->encode();
          Storage::disk('public')->put("avatars/{$newavatar}", $image);
          return $newavatar;
    }
    public function uploadCoverImage(UploadedFile $imageFile, string $username)
    {
        $newcover = uniqid() . '-cover-'.$username . '.' . $imageFile->extension();
          $image = Image::read($imageFile)
          ->resize(1500, 500)
          ->encode();
          Storage::disk('public')->put("covers/{$newcover}", $image);
          return $newcover;
    }
}
