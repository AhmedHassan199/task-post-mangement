<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function findByPhoneNumber(string $phoneNumber)
    {
        return User::where('phone_number', $phoneNumber)->first();
    }

    public function verifyUser(User $user)
    {
        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();
    }
}
