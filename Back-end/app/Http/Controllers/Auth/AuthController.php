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

        try {
            return $this->UserService->Login($request->all());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function register_peserta(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'telepon' => 'required|string|unique:users|regex:/^[0-9]+$/',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ], [
            'telepon.unique' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.'
        ], ['email.unique' => 'Email sudah terdaftar. Silahkan gunakan email lain.']);

        try {
            return $this->UserService->register_peserta($request->all());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function register_perusahaan(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'telepon' => 'required|string|unique:users|regex:/^[0-9]+$/',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ], [
            'telepon.unique' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.'
        ], ['email.unique' => 'Email sudah terdaftar. Silahkan gunakan email lain.']);

        try {
            return $this->UserService->register_perusahaan($request->all());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ]);

        try {
            return $this->UserService->UpdatePassword($request->all());
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}