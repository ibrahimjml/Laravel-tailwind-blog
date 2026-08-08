<?php

namespace App\Services\User;

use App\Actions\CreateUserActivationAction;
use App\Events\NewRegistered;
use App\Factories\UserFactory;
use App\Mail\WelcomeNewUser;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
class RegisterUserService
{
    protected $factory;
    public function __construct(
           UserFactory $factory, 
           protected CreateUserActivationAction $createUserActivationAction)
    {
        $this->factory = $factory;
    }
    public function register(array $data) : array
    {
       $user = $this->factory->create($data);
       $user->save();

       $role = Role::firstOrCreate(['name' => 'User']);
       $user->roles()->syncWithoutDetaching([$role->id]);
   
      $this->createUserActivationAction->create($user);
      
    Mail::to($user->email)->queue(new WelcomeNewUser($user));
    // notify admin with new user
    event(new NewRegistered($user));

    return [
      'user' => $user,
      'success' => 'your account registered, we will email you once activated.'
    ];
    }
}
