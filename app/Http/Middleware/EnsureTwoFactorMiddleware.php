<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {

    if (
      !auth()->check() ||
      !auth()->user()?->has_two_factor_enabled ||
      $request->routeIs(['2fa.*', 'logout'])
    ) {

      return $next($request);
    }

    if ($request->session()->get('2fa:passed', false)) {

      return $next($request);
    }

    // after login via remember me + 2fa passed/session invalidated, keep 2fa passed
    if (auth()->viaRemember() && auth()->user()->has_two_factor_enabled) {

      $request->session()->put('2fa:passed', true);

      return $next($request);
    }

    return redirect()->route('2fa.confirmation');
  }
}