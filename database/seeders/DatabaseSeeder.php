<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    $this->call(AdminSeeder::class);

    $userRole =  \App\Models\Role::where('name', 'User')->first();

      \App\Models\User::factory(20)->create()->each(function ($user) use ($userRole) {
        $user->roles()->attach($userRole);
    });
    $users = \App\Models\User::all();

    \App\Models\Post::factory(10)->make()->each(function ($post) use ($users) {
    $post->user_id = $users->random()->id; 
    $post->save();
   });
        // \App\Models\Comment::factory(20)->create();
    }
}
