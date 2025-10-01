<?php

namespace App\DTOs\Admin;

use App\Enums\SlidesStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class SlideDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?string $link,
        public readonly SlidesStatus $status,
        public readonly ?UploadedFile $image = null,
    ){}
    public static function fromRequest(Request $request, int $userId)
    {
      return new self(
              title: $request->validated('title'),
              image: $request->file('image'),
              description: $request->validated('description'),
              link: $request->validated('link'),
              status: SlidesStatus::from($request->validated('status')),
      );
    }
}
