<?php

namespace App\DTOs;

use App\Http\Requests\App\UpdatePostRequest as AppUpdateRequest;

class UpdatePostDTO
{
      public function __construct(
       public readonly string $title,
       public readonly string $description,
       public readonly ?bool $allowComments,
       public readonly ?string $hashtags,
       public readonly ?bool $isFeatured = false, 
    ){}

     public static function fromAppRequest(AppUpdateRequest $request): self
    {
        $title = htmlspecialchars(strip_tags($request->validated('title')));
        $allowComments = $request->boolean('enabled');
        $featured = $request->boolean('featured');

        return new self(
            title: $title,
            description: $request->validated('description'),
            allowComments: $allowComments,
            hashtags: $request->filled('hashtag') ? $request->validated('hashtag') : null,
            isFeatured: $featured
          );
    }
}
