<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

trait HasPermissionsTrait
{
      public function roles()
  {
    return $this->belongsToMany(Role::class);
  }
  public function hasRole($role)
  {
    return $this->roles->contains('name', $role);
  }
  public function hasAnyRole(array $roles)
  {
          Cache::tags(['has_any_role',"user_role:{$this->id}"])->remember("user:{$this->id}:has_any_role",3600, function() use($roles){
          return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
        });
  }
  public function userPermissions()
  { 
    return $this->belongsToMany(Permission::class, 'permission_user');
  }
  public function hasPermission($permission)
  {
    return $this->getAllPermissions()->contains($permission);
  }

  public function hasAnyPermission(array $permissions): bool
{  
     return $this->getAllPermissions()->intersect($permissions)->isNotEmpty();
}
public function getAllPermissions()
{
    return Cache::tags(['user_permissions',"user:{$this->id}"])->remember("user:{$this->id}:permissions",3600,function () {

            $rolePermissions = $this->roles->flatMap->permissions->pluck('name');
            $userPermissions = $this->userPermissions->pluck('name');

            return $rolePermissions->merge($userPermissions)->unique();
        }
    );
}

}
