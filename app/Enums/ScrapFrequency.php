<?php

namespace App\Enums;

use Illuminate\Support\Carbon;



enum ScrapFrequency: string
{
    case FIFTEEN_MINUTES = '15 min';
    case THIRTY_MINUTES = '30 min';
    case ONE_HOUR = '1 hr';
    case TWO_HOURS = '2 hrs';
    case SIX_HOURS = '6 hrs';
    case TWELVE_HOURS = '12 hrs';
    case TWINTY_FOUR_HOURS = '24 hrs';

    public function label()
    {
      return match($this) {
        self::FIFTEEN_MINUTES => 'Every 15 Minutes',
        self::THIRTY_MINUTES => 'Every 30 Minutes',
        self::ONE_HOUR => 'Every 1 Hour',
        self::TWO_HOURS => 'Every 2 Hours',
        self::SIX_HOURS => 'Every 6 Hours',
        self::TWELVE_HOURS => 'Every 12 Hours',
        self::TWINTY_FOUR_HOURS => 'Every 24 Hours',
      };
    }

    public function nextCrawlDateTime(): Carbon
    {
        return match($this) {
            self::FIFTEEN_MINUTES => now()->addMinutes(15),
            self::THIRTY_MINUTES => now()->addMinutes(30),
            self::ONE_HOUR => now()->addHour(),
            self::TWO_HOURS => now()->addHours(2),
            self::SIX_HOURS => now()->addHours(6),
            self::TWELVE_HOURS => now()->addHours(12),
            self::TWINTY_FOUR_HOURS => now()->addHours(24),
        };
    }
}
