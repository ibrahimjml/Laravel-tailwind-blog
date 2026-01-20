<?php

namespace App\Enums;

enum NotificationType:string
{
    case LIKE = 'like';
    case POSTCREATED = 'Postcreated';
    case COMMENTS = 'comments';
    case REPORT = 'postreport';
    case FOLLOW = 'follow';
    case FOLLOWACCEPT = 'followaccept';
    case VIEWEDPROFILE = 'viewedprofile';
    case NEWUSER = 'newuser';

    public function label()
    {
      return match ($this) {
        self::LIKE          => 'Likes',
        self::POSTCREATED   => 'Post Created',
        self::COMMENTS      => 'Comments',
        self::REPORT        => 'Reports',
        self::FOLLOW        => 'Follows',
        self::FOLLOWACCEPT  => 'Follow Accept',
        self::VIEWEDPROFILE => 'Viewed Profiles',
        self::NEWUSER       => 'New Registered Users',
      };
    }
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
