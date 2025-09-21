<?php

namespace App\Enums;

enum ReportStatus: string
{
     case Pending = 'pending';
    case Reviewed = 'reviewed';
    case Rejected = 'rejected';

    public function label(): string
    {
      return match ($this) {
      self::Pending  =>  'Pending',
      self::Reviewed => 'Reviewed',
      self::Rejected => 'Rejected'

      };
    }


}

