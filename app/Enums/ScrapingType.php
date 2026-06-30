<?php

namespace App\Enums;

enum ScrapingType:string
{
    case WEB = 'web';
    case RSS = 'rss';

    public function label(): string
    {
        return match ($this) {
            self::WEB => 'Web HTML',
            self::RSS => 'RSS Feed',
        };
    }
}
