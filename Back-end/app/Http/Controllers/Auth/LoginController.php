<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;

class LoginController extends Controller
{
    private UserService $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $this->UserService->Login($data);
    }

    public function logout(Request $request)
    {
        return $this->UserService->Logout($request->user());
    }
}
