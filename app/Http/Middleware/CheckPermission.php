<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next, $permission = null): Response
  {
    if (!$permission) {
      $action = $request->route()->getAction();
      $permission = $action['permission'] ?? null;
    }

    if (!$permission) {
      return $next($request);
    }

    if (!auth()->check() || !auth()->user()->hasPermission($permission)) {
      abort(403, 'Not Authorized');
    }
    return $next($request);
  }
}
