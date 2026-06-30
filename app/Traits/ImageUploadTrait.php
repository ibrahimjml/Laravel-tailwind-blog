<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
trait ImageUploadTrait
{
  use OptimizeImagetrait;
  // user upload image
  public function uploadImage(UploadedFile $imageFile, string $slug)
  {

    $newimage = uniqid() . '-' . $slug . '.' . $this->resolveExtension($imageFile);
    $image = Image::read($imageFile)
      ->cover(1300, 600);
    $image = $this->optimizeImage($image, $imageFile);
    Storage::disk(media_driver())->put("uploads/{$newimage}", $image);
    return $newimage;
  }
  // user avatar image
  public function uploadAvatarImage(UploadedFile $imageFile, string $username)
  {
    $newavatar = uniqid() . '-avatar-' . $username . '.' . $this->resolveExtension($imageFile);
    $image = Image::read($imageFile)
      ->scale(150, 150);
    $image = $this->optimizeImage($image, $imageFile);
    Storage::disk(media_driver())->put("avatars/{$newavatar}", $image);
    return $newavatar;
  }
  // user cover image
  public function uploadCoverImage(UploadedFile $imageFile, string $username)
  {
    $newcover = uniqid() . '-cover-' . $username . '.' . $this->resolveExtension($imageFile);
    $image = Image::read($imageFile)
      ->cover(1500, 500);
    $image = $this->optimizeImage($image, $imageFile);
    Storage::disk(media_driver())->put("covers/{$newcover}", $image);
    return $newcover;
  }
  // slide image
  public function uploadImageSlide(UploadedFile $imageFile, string $username)
  {
    $newslide = uniqid() . '-slide-' . $username . '.' . $this->resolveExtension($imageFile);
    $slide = Image::read($imageFile)
      ->scaleDown(1500, 600);
    $slide = $this->optimizeImage($slide, $imageFile);
    Storage::disk(media_driver())->put("slides/{$newslide}", $slide);

    return $newslide;
  }
  // meta og graph image
  public function uploadMetaOgImage(UploadedFile $imageFile, string $appName)
  {
    $newMetaOgImage = 'meta-og-' . $appName . '.' . $this->resolveExtension($imageFile);
    $og_image = Image::read($imageFile)
      ->cover(1200, 630);
    $og_image = $this->optimizeImage($og_image, $imageFile);
    Storage::disk(media_driver())->put("img/{$newMetaOgImage}", $og_image);

    return $newMetaOgImage;
  }
  // favicon 
  public function uploadFavicon(UploadedFile $imageFile)
  {
    $newFavicon = 'favicon.' . $this->resolveExtension($imageFile);
    $favicon = Image::read($imageFile)
      ->scaleDown(64, 64);
    $favicon = $this->optimizeImage($favicon, $imageFile);
    Storage::disk(media_driver())->put("img/{$newFavicon}", $favicon);

    return $newFavicon;
  }
  // custom ad banner
  public function uploadCustomBanner(UploadedFile $imageFile, string $adName, int $width, int $height)
  {
    $bannerId = str_replace(' ', '-', $adName) . '.' .  $this->resolveExtension($imageFile);
    $banner = Image::read($imageFile)
      ->scaleDown($width, $height);
    $banner = $this->optimizeImage($banner, $imageFile);
    Storage::disk(media_driver())->put("ads/{$bannerId}", $banner);

    return $bannerId;
  }
}
