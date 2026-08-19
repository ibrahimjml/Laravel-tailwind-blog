<?php

namespace App\Support;

final class UserAgentSupport
{
    /**
     * @return array{string, string} [$browser, $platform]
     */
    public static function parse(?string $userAgent): array
    {
        $agent = strtolower($userAgent ?? '');

        $browser = match (true) {
            str_contains($agent, 'edg/') => 'Edge',
            str_contains($agent, 'opr/'), str_contains($agent, 'opera') => 'Opera',
            str_contains($agent, 'firefox/') => 'Firefox',
            str_contains($agent, 'chrome/'), str_contains($agent, 'crios/') => 'Chrome',
            str_contains($agent, 'safari/') && !str_contains($agent, 'chrome/') => 'Safari',
            str_contains($agent, 'msie'), str_contains($agent, 'trident/') => 'Internet Explorer',
            default => 'Unknown Browser',
        };

        $platform = match (true) {
            str_contains($agent, 'windows') => 'Windows',
            str_contains($agent, 'iphone') => 'iPhone',
            str_contains($agent, 'ipad') => 'iPad',
            str_contains($agent, 'android') => 'Android',
            str_contains($agent, 'mac os') => 'macOS',
            str_contains($agent, 'linux') => 'Linux',
            default => 'Unknown',
        };

        return [$browser, $platform];
    }

    public static function describe(?string $userAgent): string
    {
        [$browser, $platform] = self::parse($userAgent);

        return "{$browser} on {$platform}";
    }
}

