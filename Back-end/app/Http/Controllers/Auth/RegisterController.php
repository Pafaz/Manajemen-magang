<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    private UserService $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function registerPeserta(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ], [], [
            'email.unique' => 'Email sudah terdaftar. Silahkan gunakan email lain.'
        ]);

        return $this->UserService->register_peserta($request->all());
    }

    public function registerPerusahaan(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ], [], [
            'email.unique' => 'Email sudah terdaftar. Silahkan gunakan email lain.'
        ]);

        return $this->UserService->register_perusahaan($request->all());
    }
}
