<?php

namespace App\Providers;

use App\Helpers\MetaHelpers;
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
    {      /**
           * view post blade.
           */
            View::composer('post', function ($view) {
            $post = request()->route('post');
            if ($post && is_object($post)) {
                $meta = MetaHelpers::generateMetaForPosts($post);
                $view->with($meta);
            }
           });
           /**
           * view hashtag blade.
           */
              View::composer('hashtags.show', function ($view) {
              $hashtag = request()->route('hashtag');

        if ($hashtag && is_object($hashtag)) {
            $title = "Hashtag - {$hashtag->name} page";
            $description = "Welcome to {$hashtag->name} page";
            $meta = MetaHelpers::generateDefault($title, $description, [$hashtag->name]);

            $view->with($meta);
                 }
              });
          /**
           * view profile blade.
           */
            View::composer(['profileuser.profile','profileuser.activity','profileuser.aboutme'], function ($view) {
            $user = request()->route('user');
    
           if ($user && is_object($user)) {
                 switch (true) {
                       case request()->routeIs('profile'):
                        $title = "{$user->name}'s Profile | Blog-Post";
                       break;
                   case request()->routeIs('profile.activity'):
                       $title = "{$user->name}'s Activity | Blog-Post";
                       break;
                   case request()->routeIs('profile.aboutme'):
                     $title = "About {$user->name} | Blog-Post";
                      break;
                  }
        $desc = "{$user->name} profile page connect with him.";
        $meta = MetaHelpers::generateDefault($title, $desc,[],$user);
        $view->with($meta);
            }
         });
      /**
       * view notifications-menu partials.
       */
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
