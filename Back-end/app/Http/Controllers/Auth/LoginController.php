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

    public function getData(Request $request)
    {
        return response()->json(['user' => $request->user()],200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $this->UserService->Login($request->all());
    }

    public function logout(Request $request)
    {
        return $this->UserService->Logout($request->user());
    }
}
