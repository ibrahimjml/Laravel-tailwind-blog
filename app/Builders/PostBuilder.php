<?php

namespace App\Builders;
use App\Models\Hashtag;
use Illuminate\Database\Eloquent\Builder;
class PostBuilder extends Builder
{
    public function search(?string $search): Builder
    {
      if (empty($search)) return $this;

      return $this->where(function ($query) use ($search) {
            $query->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhereHas('hashtags', function ($query) use ($search) {
                      $query->where('name', 'like', "%$search%");
                  });
        });
    }
    public function sortBy(string $sort): self
    {
       match ($sort) {
            'latest' => $this->latest(),
            'oldest' => $this->oldest(),
            'mostliked' => $this->orderByDesc('likes_count'),
            'mostviewed' => $this->orderByDesc('views'),
            'followings' => $this->filterByFollowings(),
            'featured' => $this->where('is_featured', true),
            'hashtagtrend' => $this->filterByTrendingHashtag(),
            default => $this->latest(),
        };

        return $this;
    }
    protected function filterByFollowings(): self
    {
        $followings = auth()->user()->followings->pluck('id');
        return $this->whereIn('user_id', $followings);
    }

    protected function filterByTrendingHashtag(): self
    {
        $trending = Hashtag::withCount('posts')
            ->having('posts_count', '>', 0)
            ->orderByDesc('posts_count')
            ->first();

        if ($trending) {
            return $this->whereHas('hashtags', fn ($query) =>
                $query->where('hashtags.id', $trending->id)
            );
        }

        return $this->whereRaw('0 = 1');
    }
}
