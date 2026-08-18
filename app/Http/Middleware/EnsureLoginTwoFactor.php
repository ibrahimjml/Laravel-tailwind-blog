<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLoginTwoFactor
{
    /**
     * Login 2fa challenge
     * Abort if not session found
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         abort_if(!$request->session()->has('2fa:user:id'),404);
        
         return $next($request);
    }
}
