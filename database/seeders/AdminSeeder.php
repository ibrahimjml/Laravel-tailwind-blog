<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $permissions = [
            'Access',
            'role.create',
            'role.view',
            'role.update',
            'role.delete',
            'permission.create',
            'permission.view',
            'permission.update',
            'permission.delete',
            'user.view',
            'user.delete',
            'user.block',
            'user.role',
            'post.view',
            'post.update',
            'post.feature',
            'user.update',
            'user.edit',
            'post.delete',
            'tag.create',
            'tag.view',
            'tag.update',
            'tag.delete',
            'comment.edit',
            'comment.delete',
        ];


foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        Role::firstOrCreate(['name' => 'Moderator']);
        Role::firstOrCreate(['name' => 'User']);
        $adminrole = Role::firstOrCreate(['name' => 'Admin']);
        $permissions = Permission::pluck('id');
        $adminrole->permissions()->sync($permissions);

      $admin =  User::create([
          'name' => 'admin',
          'username' => 'admin123',
          'email' => env('ADMIN_EMAIL'),
          'password' => Hash::make(env('ADMIN_PASS')),
          'is_admin' => 1,
          'avatar' => 'default.jpg',
          'created_at' => Carbon::now(),
        ]);
      $admin->roles()->syncWithoutDetaching([$adminrole->id]);
    }
}
