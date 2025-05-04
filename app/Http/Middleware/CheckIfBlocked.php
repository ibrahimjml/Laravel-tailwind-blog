<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIfBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if(Auth::check() && Auth::user()->is_blocked){
        Auth::logout();
        toastr()->error('Your account has been blocked. Please contact support.',['timeOut'=>2000]);
        return redirect('/login');
      }
        return $next($request);
    }
        
    }

