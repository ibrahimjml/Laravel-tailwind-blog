<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Event;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRole =  \App\Models\Role::where('name', \App\Enums\UserRole::USER->value)->first();

      $users = \App\Models\User::factory(20)->create()->each(function ($user) use ($userRole) {
        $user->roles()->attach($userRole);
         });

        $categories = \App\Models\Category::factory(20)->create();
        $tags = \App\Models\Hashtag::factory(20)->create();
       
        $posts = \App\Models\Post::factory(50)->create([
            'user_id' => $users->random()->id,
        ]);

        $posts->each(function ($post) use ($users,$categories, $tags) {
            
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
            $post->hashtags()->attach(
                $tags->random(rand(2, 5))->pluck('id')->toArray()
            );
    
        // top comment
        $comments = \App\Models\Comment::factory(10)->create([
             'post_id' => $post->id,
             'user_id' => $users->random()->id,
             'parent_id' => null,
           ]);

         // replies
         $comments->each(function ($parent) use ($post, $users) {
             
             $children = \App\Models\Comment::factory(2)->create([
                 'post_id' => $post->id,
                 'user_id' => $users->random()->id,
                 'parent_id' => $parent->id,
             ]);
         
             // nested replies
             $children->each(function ($child) use ($post, $users) {
                 \App\Models\Comment::factory(2)->create([
                     'post_id' => $post->id,
                     'user_id' => $users->random()->id,
                     'parent_id' => $child->id,
                 ]);
             });
         });
      });

  }
}
