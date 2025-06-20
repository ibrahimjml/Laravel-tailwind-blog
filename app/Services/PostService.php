<?php

namespace App\Services;

use App\DTOs\CreatePostDTO;
use App\DTOs\UpdatePostDTO;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Traits\ImageUploadTrait;

class PostService
{
  use ImageUploadTrait;
    public function __construct(protected PostHashtagsService $tagservice){}

    public function create(CreatePostDTO $dto): Post
    {
        $imageslug = Str::slug($dto->title);
        $newimage = $this->uploadImage($dto->image, $imageslug);

        $post = Post::create([
            'title' => $dto->title,
            'description' => $dto->description,
            'image_path' => $newimage,
            'allow_comments' => $dto->allowComments,
            'user_id' => $dto->userId,
            'is_featured' => $dto->isFeatured
        ]);
        if($dto->hashtags){
          $this->tagservice->attachhashtags($post,$dto->hashtags);
        }
        return $post;
    }

    public function update(Post $post,UpdatePostDTO $dto): Post
    {
      $post->update([
        'title' => $dto->title,
        'description' => $dto->description,
        'allow_comments' => $dto->allowComments,
        'is_featured' => $dto->isFeatured
    ]);
        $this->tagservice->syncHashtags($post, $dto->hashtags);
       return $post;
    }
}
