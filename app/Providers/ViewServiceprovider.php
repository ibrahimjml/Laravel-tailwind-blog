<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceprovider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view::composer('partials.notifications-menu',function($view){
          if(!auth()->check()){
            return;
          }

        $notifications = auth()->user()->notifications()->get();
        $usernames = $notifications
        ->pluck('data')
        ->flatMap(fn($data) => collect($data)->filter(fn($val, $key) => str_contains($key, 'username')))
        ->unique()
        ->values();

    $users = User::whereIn('username', $usernames)->get()->keyBy('username');
    $view->with([
      'users'=>$users,
      'notifications'=>$notifications
       ]);
    });
  }
}
