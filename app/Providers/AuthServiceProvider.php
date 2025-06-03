<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
      Post::class=>PostPolicy::class,
      User::class=>UserPolicy::class,
      Comment::class=>CommentPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
         Gate::before(function ($user, $ability) {
        return $user->hasPermission($ability) ? true : null;
    });
        Gate::define("makeAdminActions", function ($user) {
          return $user->hasAnyRole(['Admin', 'Moderator']) || $user->hasPermission('Access');
      });
  
    }
}
