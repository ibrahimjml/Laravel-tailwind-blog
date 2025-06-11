<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
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
               Gate::before(function ($user, $ability) {
        return $user->hasPermission($ability) ? true : null;
    });
        try{
           Permission::get()->map(function($permission){
             Gate::define($permission->name,function($user) use($permission){
               return $user->hasPermission($permission);
             });
           });
        }catch(\Exception $e){
           report($e);
        }

        Blade::directive('role', function ($role) {
       return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) : ?>";
       });

       Blade::directive("endrole", function () {
       return "<?php endif; ?>";
       });
    }
}
