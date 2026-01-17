<?php

namespace App\View\Components;

use App\Enums\FollowerStatus;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PrivateProfile extends Component
{
    public User $user;
    public ?FollowerStatus $status;
  public function __construct(User $user, ?int $status = null)
    {
        $this->user = $user;
        $this->status = $status !== null ? FollowerStatus::tryFrom($status) : null;
    }

    public function isPrivate(): bool
    {
        
        return $this->user->isNot(auth()->user()) &&
               !$this->user->profile->is_public &&
               $this->status !== FollowerStatus::ACCEPTED;
    }
    public function render(): View|Closure|string
    {
        return view('components.private-profile');
    }
}
