<?php

namespace App\Actions;

use App\Models\Activation;
use App\Models\User;

class CreateUserActivationAction
{
     public function create(User $user, bool $completed = false): Activation
    {
        return Activation::create([
            'user_id' => $user->id,
            'completed' => $completed,
            'completed_at' => $completed ? now() : null,
        ]);
    }
}
