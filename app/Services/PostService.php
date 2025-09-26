<?php

namespace App\Services;

use App\DTOs\CreatePostDTO;
use App\DTOs\UpdatePostDTO;
use App\Events\PostCreatedEvent;
use App\Helpers\DeleteFile;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostService
{
  use ImageUploadTrait;
    public function __construct(protected PostHashtagsService $tagservice){}

    public function create(CreatePostDTO $dto): ?Post
    {
          $imageslug = Str::slug($dto->title);
          $newimage = null;
          $post = null;

          try {

            $post = DB::transaction(function () use ($dto, $imageslug, &$newimage) {

            $newimage = $this->uploadImage($dto->image, $imageslug);

            $post = Post::create([
                'title'          => $dto->title,
                'description'    => $dto->description,
                'image_path'     => $newimage,
                'allow_comments' => $dto->allowComments,
                'user_id'        => $dto->userId,
                'is_featured'    => $dto->isFeatured,
            ]);

            if ($dto->hashtags) {
                $this->tagservice->attachhashtags($post, $dto->hashtags);
            }
            if ($dto->categories) {
                $post->categories()->sync($dto->categories);
            }

            return $post;
        });

        DB::afterCommit(function () use ($post) {
            try {
                event(new PostCreatedEvent($post));
            } catch (\Throwable $e) {
                Log::error('PostCreatedEvent failed for post ID ' . $post->id . ': ' . $e->getMessage());
            }
        });

        return $post;

    } catch (\Throwable $e) {
        DeleteFile::existImage('uploads/'.$newimage);
        Log::error('Error creating post: ' . $e->getMessage() . '. Deleted image: ' . ($newimage ?? 'none'));
        return null;
    }
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
        $post->categories()->sync($dto->categories);
       return $post;
    }
}
