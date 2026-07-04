<?php

namespace App\Enums;

enum ImageTypes: string
{
    case WEBP = 'webp';
    case JPEG = 'jpeg';
    case PNG = 'png';

    public function label(): string
    {
        return match ($this) {
            self::WEBP => 'WEBP (Highly Recommended)',
            self::JPEG => 'JPEG (Standard)',
            self::PNG => 'PNG (Lossless)',
        };
    }
}
