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
    case MENTION = 'mention';
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
        self::MENTION       => 'Mentions',
        self::NEWUSER       => 'New Registered Users',
      };
    }
    public function description()
    {
      return match ($this) {
        self::LIKE          => 'get notified when someone likes on post.',
        self::POSTCREATED   => 'get notified when someone posted new.',
        self::COMMENTS      => 'get notified when someone commented or replied on post.',
        self::REPORT        => 'get notified when report has been made in post, profile or comment.',
        self::FOLLOW        => 'get notified when someone requested to follow.',
        self::FOLLOWACCEPT  => 'get notified when someone accept follows requests.',
        self::VIEWEDPROFILE => 'get notified when someone viewed user profile.',
        self::MENTION       => 'get notified when a someone mentioned any user.',
        self::NEWUSER       => 'get notified when a new user join platform.',
      };
    }
    public static function postRelated(): array
    {
        return [
            self::LIKE,
            self::POSTCREATED,
            self::COMMENTS,
            self::MENTION,
            self::REPORT,
        ];
    }

     public static function userRelated(): array
    {
        return [
            self::FOLLOW,
            self::FOLLOWACCEPT,
            self::VIEWEDPROFILE,
            self::NEWUSER,
        ];
    }
}
