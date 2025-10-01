<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
trait ImageUploadTrait
{   
    // user upload image
    public function uploadImage(UploadedFile $imageFile, string $slug)
    {
      
        $newimage = uniqid() . '-' . $slug . '.' . $imageFile->extension();
          $image = Image::read($imageFile)
          ->resize(1300, 600)
          ->encode();
          Storage::disk('public')->put("uploads/{$newimage}", $image);
          return $newimage;
    }
    // user avatar image
    public function uploadAvatarImage(UploadedFile $imageFile, string $username)
    {
        $newavatar = uniqid() . '-avatar-'.$username . '.' . $imageFile->extension();
          $image = Image::read($imageFile)
          ->resize(150, 150)
          ->encode();
          Storage::disk('public')->put("avatars/{$newavatar}", $image);
          return $newavatar;
    }
    // user cover image
    public function uploadCoverImage(UploadedFile $imageFile, string $username)
    {
        $newcover = uniqid() . '-cover-'.$username . '.' . $imageFile->extension();
          $image = Image::read($imageFile)
          ->resize(1500, 500)
          ->encode();
          Storage::disk('public')->put("covers/{$newcover}", $image);
          return $newcover;
    }
    // slide image
    public function uploadImageSlide(UploadedFile $imageFile, string $username)
    {
         $newslide = uniqid() . '-slide-'.$username . '.' . $imageFile->extension();
         Image::read($imageFile)
              ->scaleDown(1500, 600) 
              ->toWebp(75)
              ->save(public_path('slides/'.$newslide));
          
          return $newslide;
    }
}
