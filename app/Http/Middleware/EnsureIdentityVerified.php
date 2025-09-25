<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIdentityVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {    
         $user = $request->user();

      if (!$user) {
           return $next($request); 
         }

         $verification = $user->identityVerification()
            ->where('expires_at', '>', now())
            ->first();

        if ($verification && !$request->routeIs('verify.code.show', 'verify.code')) {
            return redirect()->route('verify.code.show');
        }
        return $next($request);
    }
}
