<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserInterface
{
   public function getBySearch( $dto, int $limit): Collection 
    {
        return User::query()
            ->activated()
            ->where('is_blocked',false)
            ->search($dto->search)
            ->limit($limit)
            ->get();
            
    }
}