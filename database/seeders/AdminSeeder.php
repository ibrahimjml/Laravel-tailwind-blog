<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $permissions = [
            // user & account management
            'Access',
            'user.view',
            'user.delete',
            'user.block',
            'user.role',
            'user.updateImage',
            'user.deleteSocial',
            'user.update',
            'user.edit',
            // roles management
            'role.create',
            'role.view',
            'role.update',
            'role.delete',
            // permissions management
            'permission.create',
            'permission.view',
            'permission.update',
            'permission.delete',
            // posts management
            'post.view',
            'post.update',
            'post.feature',
            'post.delete',
            // tags management
            'tag.create',
            'tag.view',
            'tag.update',
            'tag.delete',
            'tag.feature',
            // categories management
            'category.create',
            'category.view',
            'category.update',
            'category.delete',
            'category.feature',
            // comments post management
            'comment.edit',
            'comment.delete',
            // post reports management
            'postreport.view',
            'postreport.delete',
            'postreport.status'
        ];


      foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
       Permission::all()->each(function ($perm) {
               $perm->slug = Str::slug($perm->name);
               $perm->save();
        });

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
          'cover_photo' => 'sunset.jpg',
          'created_at' => Carbon::now(),
        ]);
      $admin->roles()->syncWithoutDetaching([$adminrole->id]);
    }
}
