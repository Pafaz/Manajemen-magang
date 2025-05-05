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

    public function redirectAuth($role): JsonResponse
    {
        // dd($role);
        if ($role === 'peserta') {
            $redirectUri = env('GOOGLE_REDIRECT_URI_PESERTA');
            $url = Socialite::with('google')->stateless()->redirectUrl($redirectUri)->redirect()->getTargetUrl();
        } else if($role === 'perusahaan') {
            $redirectUri = env('GOOGLE_REDIRECT_URI_PERUSAHAAN');
            $url = Socialite::with('google')->stateless()->redirectUrl($redirectUri)->redirect()->getTargetUrl();
        }

        return response()->json(['url' => $url]);
    }
    // public function redirectAuth($role): JsonResponse
    // {
    //     // dd($role);
    //     if ($role == 'peserta') {
    //         $redirectUri = env('GOOGLE_REDIRECT_URI_PESERTA');
    //         $url = Socialite::with('google')->stateless()->redirectUrl($redirectUri)->redirect()->getTargetUrl();
    //     } else if($role == 'perusahaan') {
    //         $redirectUri = env('GOOGLE_REDIRECT_URI_PERUSAHAAN');
    //         $url = Socialite::with('google')->stateless()->redirectUrl($redirectUri)->redirect()->getTargetUrl();
    //     }

    //     return response()->json(['url' => $url]);
    // }

    public function callbackPerusahaan(SocialiteCallbackRequest $request)
    {
        return $this->userService->handleGooglecallback($request->validated(),'perusahaan');
    }

    public function callbackPeserta(SocialiteCallbackRequest $request)
    {
        return $this->userService->handleGoogleCallback($request->validated(), 'peserta');
    }
}
