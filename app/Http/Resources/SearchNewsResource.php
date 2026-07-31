<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchNewsResource extends JsonResource
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
            'description' => $this->description,
            'image' => $this->image_url,
            'source' => [
              'source_id' => $this->source->id,
              'name' => $this->source->name,
            ],
            'created_at' => $this->created_at?->diffForHumans(),
        ];
    }
}
