<?php

namespace App\Services;

use App\Events\NewRegistered;
use App\Factories\UserFactory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
class RegisterUserService
{
    protected $factory;
    public function __construct(UserFactory $factory){
        $this->factory = $factory;
    }
    public function register(array $data) : User
    {
       $user = $this->factory->create($data);
       $user->save();

    $role = Role::firstOrCreate(['name' => 'User']);
    $user->roles()->syncWithoutDetaching([$role->id]);

    event(new Registered($user));
    // notify admin with new user
    event(new NewRegistered($user));
    auth()->login($user);
    return $user;
    }
}
