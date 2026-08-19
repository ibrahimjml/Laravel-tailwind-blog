<?php

namespace App\Http\Middleware;


use App\Services\User\TrustedDeviceService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorHasTrustedDevice
{
  /**
   * Global Middleware For Two Factor Trusted Device.
   * Users with trusted device check will bybass two factor within expiry for 30 days with rotation coockie every 24h.
   * Non trusted will logged out with redirect to login again after 24h.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  protected const VALIDITY_SECONDS = 86400; // 24h
  public function __construct(protected TrustedDeviceService $trustedDevices){}
  public function handle(Request $request, Closure $next): Response
    {
        if (
            ! auth()->check() ||
            ! auth()->user()?->has_two_factor_enabled ||
            $request->routeIs(['2fa.*', 'logout'])
        ) {
            return $next($request);
        }
 
        $passedAt = $request->session()->get('2fa:passed_at');
 
        if ($passedAt && (now()->timestamp - $passedAt) < self::VALIDITY_SECONDS) {

            return $next($request);
        }

        $user = auth()->user();
 
        if ($this->trustedDevices->isTrusted($request, $user)) {

            $request->session()->put([
                '2fa:passed' => true,
                '2fa:passed_at' => now()->timestamp,
            ]);
 
            return $next($request);
        }
 
        $this->invalidateSessions($request);

        return redirect()->route('login');
    }
    protected function invalidateSessions($request){

      Auth::logoutCurrentDevice();

      $request->session()->invalidate();
      $request->session()->regenerateToken();
    }
}