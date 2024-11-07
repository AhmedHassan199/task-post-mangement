<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Helpers\ApiResponseHelper;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register($request->validated());

        Log::info("Verification code for user {$user->id}: {$user->verification_code}");

        return ApiResponseHelper::success([
            'user' => $user,
            'access_token' => $user->createToken('post_tag')->plainTextToken,
        ]);
    }

    /**
     * Log in a user.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userService->findByPhoneNumber($request->phone_number);

        if (!$user || !Hash::check($request->password, $user->password) || !$user->is_verified) {
            return ApiResponseHelper::error('Invalid credentials or account not verified.', 401);
        }

        return ApiResponseHelper::success([
            'user' => $user,
            'access_token' => $user->createToken('post_tag')->plainTextToken,
        ]);
    }

    /**
     * Verify the user's verification code.
     *
     * @param VerifyCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCode(VerifyCodeRequest $request)
    {
        $user = $this->userService->findByPhoneNumber($request->phone_number);

        // Verify the code
        if ($this->userService->verifyUserCode($user, $request->code)) {
            return ApiResponseHelper::success([], 'Account verified successfully.');
        }

        return ApiResponseHelper::error('Invalid verification code.', 400);
    }
}
