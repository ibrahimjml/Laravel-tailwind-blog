<?php

namespace App\Builders;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Fluent;

class CategoryBuilder extends Builder
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
            default => $this->latest(),
        };

        return $this;
    }
      public function featured(bool $featured = true): self
    {
        return $this->when($featured, fn($q) => $q->where('is_featured', 1));
    }
    public function filterCategory(Fluent $filter): self
    {
        return $this
            ->when($filter->search, fn(CategoryBuilder $q, $search) 
                 => $q->search($search))
            ->when($filter->featured, fn(CategoryBuilder $q, $featured) 
                 => $q->featured($featured))
            ->when($filter->sort, fn(CategoryBuilder $q, $sort) 
                 => $q->sortBy($sort));
            
    }
}
