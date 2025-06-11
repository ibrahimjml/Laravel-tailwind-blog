<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

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
    return $this->roles->pluck('name')->intersect($roles)->isNotEmpty();
  }
  public function userPermissions()
  {
    return $this->belongsToMany(Permission::class, 'permission_user');
  }
  public function hasPermission($permission)
  {
    $rolePermissions = $this->roles->flatMap->permissions->pluck('name');
    $userPermissions = $this->userPermissions->pluck('name');

    return $rolePermissions->merge($userPermissions)->contains($permission);
  }

  public function hasAnyPermission(array $permissions): bool
{
    $rolePermissions = $this->roles->flatMap->permissions->pluck('name');
    $userPermissions = $this->userPermissions->pluck('name');
    return $rolePermissions->merge($userPermissions)->intersect($permissions)->isNotEmpty();
}
public function getAllPermissions()
{
    $rolePermissions = $this->roles->flatMap->permissions->pluck('name');
    $userPermissions = $this->userPermissions->pluck('name');

    return $rolePermissions->merge($userPermissions)->unique();
}
}
