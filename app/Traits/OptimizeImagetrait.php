<?php

namespace App\Traits;

use App\Enums\ImageTypes;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;

trait OptimizeImagetrait
{
  protected function optimizeImage($image, UploadedFile $imageFile)
  {
    if (! Setting::get('enable_image_optimization', true)) {
      return match (strtolower($imageFile->extension())) {
            'jpg', 'jpeg' => $image->toJpeg(90),
            'png'         => $image->toPng(),
            'webp'        => $image->toWebp(90),
            default       => $image->toWebp(90),
        };
    }

    $quality = (int) Setting::get('image_compression_quality');
    $format = Setting::get('image_output_format');

    return match ($format) {
      ImageTypes::WEBP->value => $image->toWebp($quality),
      ImageTypes::JPEG->value => $image->toJpeg($quality),
      ImageTypes::PNG->value => $image->toPng(),

      default => $image->toWebp(90),
    };
  }
  protected function resolveExtension(UploadedFile $imageFile)
  {
    $dbImageEnabled = Setting::get('enable_image_optimization', true);
    $dbImageExtension = Setting::get('image_output_format', ImageTypes::WEBP->value);
    if ($dbImageEnabled && $dbImageExtension)
      return $dbImageExtension;

    $clientExtension = strtolower($imageFile->extension());
    return $clientExtension;
  }
}
