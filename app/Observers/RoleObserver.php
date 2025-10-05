<?php

namespace App\Observers;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
          Cache::tags(['user_permissions','has_any_role'])->flush();
          
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
      Cache::tags(['user_permissions','has_any_role'])->flush();
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
      Cache::tags(['user_permissions','has_any_role'])->flush();
    }

    
}
