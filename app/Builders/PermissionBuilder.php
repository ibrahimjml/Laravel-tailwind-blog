<?php

namespace App\Builders;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Fluent;

class PermissionBuilder extends Builder
{
      public function search(?string $search)
{
  return $this->where(function ($query) use ($search) {
    $query->where('name','like','%'.$search.'%')
           ->orWhere('module','like','%'.$search.'%');
          
    });
}
    public function sortBy(string $sort): self
    {
       match ($sort) {
            'latest' => $this->latest(),
            'oldest' => $this->oldest(),
            'module' => $this->orderBy('name'),
            default => $this->latest(),
        };

        return $this;
    }
    public function filterByModule(string $module): self
{
    return $this->where('module', $module);
}
    public function filter(Fluent $filter): self
    {
        return $this
            ->when($filter->search, fn(PermissionBuilder $q, $search) 
                 => $q->search($search))
            ->when($filter->module, fn(PermissionBuilder $q, $module) 
                 => $q->filterByModule($module))
            ->when($filter->sort, fn(PermissionBuilder $q, $sort) 
                 => $q->sortBy($sort));
            
    }
}
