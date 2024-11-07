<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Str;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        $verificationCode = random_int(100000, 999999); // Generate random 6-digit code

        return $this->userRepository->create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']),
            'verification_code' => $verificationCode,
        ]);
    }

    public function verifyUserCode($user, $code)
    {
        if ($user && $user->verification_code === $code) {
            $this->userRepository->verifyUser($user);
            return true;
        }
        return false;
    }

    public function findByPhoneNumber(string $phoneNumber)
    {
        return $this->userRepository->findByPhoneNumber($phoneNumber);
    }
}
