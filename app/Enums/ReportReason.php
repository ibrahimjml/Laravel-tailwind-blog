<?php

namespace App\Enums;

enum ReportReason: string
{
    case Spam = 'Spam';
    case Abusive = "it's abusive";
    case Harasment = 'Harasment';
    case RulesViolation = 'RulesViolation';
    case Other = 'Other';

    public function label(): string
    {
      return match ($this) {
      self::Spam => 'Spam',
      self::Abusive => "It's abusive",
      self::Harasment => 'Harasment',
      self::RulesViolation => 'Broke Community Rules',
      self::Other => 'Other',

      };
    }
}
