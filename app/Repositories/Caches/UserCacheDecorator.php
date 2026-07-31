<?php

namespace App\Repositories\Caches;


use App\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UserCacheDecorator implements UserInterface
{
    public function __construct(private UserInterface $repo){}
    public function getBySearch($dto, int $limit): Collection
    {
        $key = sprintf('users:search:%s:%d', md5(strtolower(trim($dto->search))), $limit);
        return Cache::tags(['users_results'])->remember($key, now()->addMinutes(10),fn () => $this->repo->getBySearch($dto, $limit));
    }
}