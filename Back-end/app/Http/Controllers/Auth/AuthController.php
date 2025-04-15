<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Password as resetPassword;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    private UserService $UserService;
    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    } 
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        return $this->UserService->Login($request->all());
    }

    public function register_peserta(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ], [
        ], ['email.unique' => 'Email sudah terdaftar. Silahkan gunakan email lain.']);

        return $this->UserService->register_peserta($request->all());
    }

    public function register_perusahaan(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ], [
        ], ['email.unique' => 'Email sudah terdaftar. Silahkan gunakan email lain.']);

        return $this->UserService->register_perusahaan($request->all());
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ]);

        return $this->UserService->UpdatePassword($request->all());
    }

    public function logout(Request $request)
    {
        return $this->UserService->Logout($request->user());
    }
}