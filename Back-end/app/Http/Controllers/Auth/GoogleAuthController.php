<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\SocialiteCallbackRequest;

class GoogleAuthController extends Controller

{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function redirectAuth(): JsonResponse
    {
        $redirectUri = env('GOOGLE_REDIRECT_URI');

        $url = Socialite::with('google')
                        ->stateless()
                        ->scopes(['email', 'profile'])
                        ->redirectUrl($redirectUri)
                        ->redirect()
                        ->getTargetUrl();

        Log::info("Generated Google OAuth URL: " . $url);

        return response()->json(['url' => $url]);
    }


    public function callback(SocialiteCallbackRequest $request)
    {
        return $this->userService->handleGoogleCallback($request->validated());
    }
}
