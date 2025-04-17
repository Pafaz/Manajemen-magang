<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\SocialiteCallbackRequest;
use App\Services\UserService;

class GoogleAuthController extends Controller

{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function redirectToAuth(): JsonResponse
    {
        return response()->json(['url' => Socialite::with('google')->stateless()->redirect()->getTargetUrl(),]);
    }

    public function callbackPeserta(SocialiteCallbackRequest $request)
    {
        return $this->userService->handleGoogleCallback($request->validated(), 'peserta');
    }

    public function callbackPerusahaan(SocialiteCallbackRequest $request)
    {
        return $this->userService->handleGoogleCallback($request->validated(),'perusahaan');
    }
}
