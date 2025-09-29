<?php

namespace App\Builders;

use App\Enums\TagStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Fluent;

class TagBuilder extends Builder
{
      public function search(?string $search)
{
  return $this->where(function ($query) use ($search) {
    $query->where('name','like','%'.$search.'%');
          
    });
}
    public function sortBy(string $sort): self
    {
       match ($sort) {
            'latest' => $this->latest(),
            'oldest' => $this->oldest(),
            'active' => $this->filterByStatus(TagStatus::ACTIVE),
            'disabled' => $this->filterByStatus(TagStatus::DISABLED),
            default => $this->latest(),
        };

        return $this;
    }
      public function filterByStatus(TagStatus $status): self
    {
        return $this->where('status', $status->value);
        
    }
      public function featured(bool $featured = true): self
    {
        return $this->when($featured, fn($q) => $q->where('is_featured', 1));
    }
    public function filterTag(Fluent $filter): self
    {
        return $this
            ->when($filter->search, fn(TagBuilder $q, $search) 
                 => $q->search($search))
            ->when($filter->featured, fn(TagBuilder $q, $featured) 
                 => $q->featured($featured))
            ->when($filter->sort, fn(TagBuilder $q, $sort) 
                 => $q->sortBy($sort));
            
    }
}
