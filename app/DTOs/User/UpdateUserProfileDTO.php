<?php

namespace App\DTOs\User;

use App\Http\Requests\App\UpdateUserProfileRequest as UserInfoRequest;
use Illuminate\Http\UploadedFile;

class UpdateUserProfileDTO
{
     public function __construct(
        public readonly ?string $name,
        public readonly ?string $phone,
        public readonly ?string $bio,
        public readonly ?string $about,
        public readonly ?string $github,
        public readonly ?string $linkedin,
        public readonly ?string $twitter,
        public readonly ?array $social_links = [],
        public readonly ?UploadedFile $avatar = null,
        public readonly ?UploadedFile $cover = null,
    ) {}

    public static function fromRequest(UserInfoRequest $request): self
    {
       $fields = $request->only([
        'name', 'phone', 'bio', 'about', 'github', 'linkedin', 'twitter',
        'social_links',
    ]);

    foreach ($fields as $key => $value) {
        if (!is_array($value) && is_string($value)) {
            $fields[$key] = trim(strip_tags($value));
        }
    }
        return new self(
             name: $fields['name'],
             phone: $fields['phone'],
             bio: $fields['bio'] ?? null,
             about: $fields['about'] ?? null,
             github: $fields['github'] ?? null,
             linkedin: $fields['linkedin'] ?? null,
             twitter: $fields['twitter'] ?? null,
             social_links: $fields['social_links'] ?? [],
             avatar: $request->file('avatar'),
             cover: $request->file('cover'),
        );
    }
}
