<?php

namespace App\Enums;

enum ReportReason: string
{
    case Spam = 'Spam';
    case Abusive = "it's abusive";
    case Harasment = 'Harasment';
    case RulesViolation = 'RulesViolation';
    case InappropriateUploads = 'Inappropriate uploads';
    case NotInterested = 'not interested';
    case NotInBlog = 'should not be in blogpost';
    case Other = 'other';

    public function label(): string
    {
      return match ($this) {
      self::Spam => 'Spam or copyright issue',
      self::Abusive => "Abusive or harmful behavior",
      self::Harasment => 'Harassment or hate speech',
      self::RulesViolation => 'Broke Community Rules',
      self::InappropriateUploads => 'Inappropriate uploads images/categories/tags',
      self::NotInterested => 'Iam not interested',
      self::NotInBlog => 'This should not be in blogpost',
      self::Other => 'Other',

      };
    }
    public static function postReasons()
    {
      return [
         self::Spam,
         self::Abusive,
         self::Harasment,
         self::RulesViolation,
         self::Other,
      ];
    }
    public static function profileReasons()
    {
           return [
               self::Spam,
               self::Abusive,
               self::Harasment,
               self::InappropriateUploads,
               self::Other,
           ];
    }
    public static function commentReasons()
    {
           return [
               self::Spam,
               self::Abusive,
               self::NotInterested,
               self::NotInBlog,
               self::Other,
           ];
    }
}
