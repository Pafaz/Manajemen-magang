<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(
            [
                'token' => $user->createToken('Default Token')->plainTextToken,
                'user' => new UserResource($user),
            ],
            200
        );
    }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|string|email|unique:users',
    //         'telepon' => 'required|string|unique:users|regex:/^[0-9]+$/',
    //         'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
    //     ], [
    //         'telepon.unique' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.'
    //     ], ['email.unique' => 'Email sudah terdaftar. Silahkan gunakan email lain.']);


    //     if (User::where('telepon', $request->telepon)->exists()) {
    //         return response()->json(['error' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.'], 422);
    //     } else if(User::where('email', $request->email)->exists()) {
    //         return response()->json(['error' => 'email sudah terdaftar. Silakan gunakan nomor lain.'], 422);
    //     }
    
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'telepon' => $request->telepon,
    //         'password' => Hash::make($request->password),
    //     ]);
    
    //     $token = $user->createToken('Default Token')->plainTextToken;
    
    //     return response()->json(
    //         [
    //             'token' => $token,
    //             'user' => new UserResource($user),
    //         ],
    //         200
    //     );
    // }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'telepon' => 'required|string|unique:users|regex:/^[0-9]+$/',
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ]);

        // Check if the phone number or email already exists
        if (User ::where('telepon', $request->telepon)->exists()) {
            return response()->json(['error' => 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.'], 422);
        } else if (User ::where('email', $request->email)->exists()) {
            return response()->json(['error' => 'Email sudah terdaftar. Silakan gunakan email lain.'], 422);
        }

        // Create the user with the assigned role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password),
        ]);

        // Create a token for the user
        $token = $user->createToken('Default Token')->plainTextToken;

        // Return the response with the token and user data
        return response()->json(
            [
                'token' => $token,
                'user' => new UserResource($user),
            ],
            201 // Use 201 for created resource
        );
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}