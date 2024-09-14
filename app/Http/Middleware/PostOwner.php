<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      $post = Post::where('slug', $request->route('slug'))->firstOrFail();
 
      if (auth()->user()->id !== $post->user_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
        return $next($request);
    }
}
