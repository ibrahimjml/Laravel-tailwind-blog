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
            auth()->check() && 
            auth()->user()->has_two_factor_enabled && 
          ! session()->get('2fa:passed', false) &&
          ! $request->routeIs(['2fa.*', 'logout'])
        ) {
            return redirect()->route('2fa.confirmation');
        }

        return $next($request);
    }
    }
