<?php

namespace App\Services\User;

use App\DTOs\User\UpdateAccountDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAccountService
{
    public function update(User $user,UpdateAccountDTO $dto):array
    {
        $data = [
            'username'  => $dto->username,
            'email'     => $dto->email,
        ];
        if (!empty($dto->password)) {
        $data['password'] = Hash::make($dto->password);
         }
        $user->fill($data);
        
         if (!$user->isDirty()) {
        return [
          'status' => false,
          'message' => 'Nothing Changed to Update',
        ];
         }
         
         if($user->isDirty('username') && $user->username_changed_at === null){
          $user->username_changed_at = now();
         }

        if($user->isDirty('email')){
          $user->email_verified_at = null;
        };

        $user->save();

        if($user->wasChanged('email')){
          $user->sendEmailVerificationNotification();
        };
        return [
          'status' => true,
          'message' => 'Account updated successfully.',
        ];
    }
}
