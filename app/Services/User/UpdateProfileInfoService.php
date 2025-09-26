<?php

namespace App\Services\User;

use App\DTOs\User\UpdateUserProfileDTO;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use App\Helpers\DeleteFile;
class UpdateProfileInfoService
{
    use ImageUploadTrait;
    public function update(User $user,UpdateUserProfileDTO $dto): ?User
    {
        $changed = false;
        $data = [
            'name'     => $dto->name,
            'phone'    => $dto->phone,
            'bio'      => $dto->bio,
            'aboutme'  => $dto->about,
            'github'   => $dto->github,
            'linkedin' => $dto->linkedin,
            'twitter'  => $dto->twitter,
        ];
        $user->fill($data);
         if ($user->isDirty()) {
            $changed = true;
        }
         /**
           * user avatar
           **/
        if($dto->avatar) {
            DeleteFile::cleanImage("avatars/{$user->avatar}",'default.jpg');
            $newAvatar = $this->uploadAvatarImage($dto->avatar, $user->name);
            $user->avatar = $newAvatar;
            $changed = true;
        }
        /**
          * user cover photo
          **/
        if ($dto->cover) {
            DeleteFile::cleanImage("covers/{$user->cover_photo}","sunset.jpg");
            $newCover = $this->uploadCoverImage($dto->cover, $user->name);
            $user->cover_photo = $newCover;
            $changed = true;
        }
         /**
          * user custom links
          **/
         if (!empty($dto->social_links)) {
        foreach ($dto->social_links as $link) {
          
            $platform = trim(strip_tags($link['platform'] ?? ''));
            $url = trim(strip_tags($link['url'] ?? ''));

            if ($platform && $url) { 
               $existing = $user->socialLinks()->where('platform', $platform)->first();
               if (!$existing || $existing->url !== $url) {
                $user->socialLinks()->updateOrCreate(
            ['platform' => $platform],
                ['url' => $url]
                );
                $changed = true;
              }
              }
           }
        }
        if ($changed) {
            $user->save();
            return $user;
        }

        return null; 
    }
    
}
