<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => $this->image_url,

            'user' => [
                'name' => $this->user->name,
                'username' => $this->user->username,
                'avatar' => $this->user->avatar_url,
            ],

            'created_at' => $this->created_at?->diffForHumans(),
        ];
    }
}
