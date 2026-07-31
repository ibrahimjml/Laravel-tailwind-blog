<?php

namespace App\Enums;

enum SearchType: string
{
    case ALL = 'all';
    case POSTS = 'posts';
    case USERS = 'users';
    case TAGS = 'tags';
    case CATEGORIES = 'categories';
    case NEWS = 'news';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::ALL   => 'All',
            self::POSTS => 'Posts',
            self::USERS => 'Authors',
            self::TAGS  => 'Tags',
            self::CATEGORIES => 'Categories',
            self::NEWS => 'News',
        };
    }
}