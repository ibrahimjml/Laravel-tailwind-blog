<?php

namespace App\Enums;

enum NotificationType:string
{
    case LIKE = 'like';
    case POSTCREATED = 'Postcreated';
    case COMMENTS = 'comments';
    case REPORT = 'postreport';
    case FOLLOW = 'follow';
    case VIEWEDPROFILE = 'viewedprofile';
    case NEWUSER = 'newuser';

    public static function postRelated(): array
    {
        return [
            self::LIKE,
            self::POSTCREATED,
            self::COMMENTS,
            self::REPORT,
        ];
    }

     public static function userRelated(): array
    {
        return [
            self::FOLLOW,
            self::VIEWEDPROFILE,
            self::NEWUSER,
        ];
    }
}
