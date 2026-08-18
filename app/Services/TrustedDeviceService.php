<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class TrustedDeviceService
{
  protected string $cookie = '2fa_trusted';
  protected int $days = 30;

  public function issue(User $user, Request $request): \Symfony\Component\HttpFoundation\Cookie
  {
    $selector = bin2hex(random_bytes(16));
    $validator = bin2hex(random_bytes(32));

    $device = $user->twoFactorTrustedDevices()->create([
      'token_hash' => hash('sha256', $selector . $validator),
      'device_name' => $this->getUserAgent($request),
      'user_agent' => substr((string) $request->userAgent(), 0, 255),
      'ip' => $request->ip(),
      'last_used_at' => now(),
      'expires_at' => now()->addDays($this->days),
    ]);

    session()->put(['2fa:current_device_id' => $device->id]);

    return cookie(
      $this->cookie,
      "{$selector}:{$validator}",
      60 * 24 * $this->days,
      null,
      null,
      true,
      true,
      false,
      'strict'
    );
  }

  public function isTrusted(Request $request, ?User $user): bool
  {
    if (!$user || !$raw = $request->cookie($this->cookie)) {
      return false;
    }

    [$selector, $validator] = array_pad(explode(':', $raw, 2), 2, null);
    if (!$selector || !$validator) {
      return false;
    }

    $hash = hash('sha256', $selector . $validator);

    $device = $user->twoFactorTrustedDevices()
      ->where('token_hash', $hash)
      ->where('expires_at', '>', now())
      ->first();

    if (!$device) {
      return false;
    }
    session()->put(['2fa:current_device_id' => $device->id]);

    if (!$device->last_used_at || $device->last_used_at->lt(now()->subDay())) {
      $this->rotate($device);
    } else {
      $device->update(['last_used_at' => now()]);
    }

    return true;
  }
  protected function rotate(Model $device): void
  {
    $selector = bin2hex(random_bytes(16));
    $validator = bin2hex(random_bytes(32));

    $device->update([
      'token_hash' => hash('sha256', $selector . $validator),
      'last_used_at' => now(),
    ]);

    $minutesRemaining = max(1, now()->diffInMinutes($device->expires_at));

    Cookie::queue(cookie(
      $this->cookie,
      "{$selector}:{$validator}",
      $minutesRemaining,
      null,
      null,
      true,
      true,
      false,
      'strict'
    ));
  }
  public function listFor(User $user): \Illuminate\Support\Collection
  {
    $currentDeviceId = session('2fa:current_device_id');

    return $user->twoFactorTrustedDevices()
                ->orderByDesc('last_used_at')
                ->get()
                ->map(function ($device) use ($currentDeviceId) {
                     $device->isCurrent = $currentDeviceId !== null && $device->id === $currentDeviceId;
 
                     return $device->makeHidden('token_hash');
                  })
                ->values();
  }
  public function forgetOne(User $user, int $deviceId, ?Request $request = null): void
  {
    $device = $user->twoFactorTrustedDevices()->where('id', $deviceId)->first();

    if (!$device) {
      return;
    }

    $currentHash = $this->currentCookieHash($request);

    if ($currentHash !== null && hash_equals($device->token_hash, $currentHash)) {
      Cookie::queue(Cookie::forget($this->cookie));
    }

    $device->delete();
  }

  protected function currentCookieHash(?Request $request): ?string
  {
    if (!$request || !$raw = $request->cookie($this->cookie)) {
      return null;
    }

    [$selector, $validator] = array_pad(explode(':', $raw, 2), 2, null);

    if (!$selector || !$validator) {
      return null;
    }

    return hash('sha256', $selector . $validator);
  }
  public function forget(User $user): void
  {
    $user->twoFactorTrustedDevices()->delete();
    Cookie::queue(Cookie::forget($this->cookie));
    session()->forget('2fa:current_device_id');
  }

  private function getUserAgent($request): string
  {
    $userAgent = (string) $request->userAgent();

    $browser = match (true) {
      str_contains($userAgent, 'Edg/') => 'Edge',
      str_contains($userAgent, 'OPR/') => 'Opera',
      str_contains($userAgent, 'Chrome/') => 'Chrome',
      str_contains($userAgent, 'Firefox/') => 'Firefox',
      str_contains($userAgent, 'Safari/')
      && !str_contains($userAgent, 'Chrome/') => 'Safari',
      str_contains($userAgent, 'MSIE'),
      str_contains($userAgent, 'Trident/') => 'Internet Explorer',
      default => 'Unknown Browser',

    };
    $platform = match (true) {
      str_contains($userAgent, 'Windows NT') => 'Windows',
      str_contains($userAgent, 'Macintosh') => 'macOS',
      str_contains($userAgent, 'iPhone') => 'iPhone',
      str_contains($userAgent, 'iPad') => 'iPad',
      str_contains($userAgent, 'Android') => 'Android',
      str_contains($userAgent, 'Linux') => 'Linux',
      default => 'Unknown',
    };
    return $deviceName = "{$browser} on {$platform}";
  }
}