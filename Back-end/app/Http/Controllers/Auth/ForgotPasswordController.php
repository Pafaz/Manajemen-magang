<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Menangani permintaan untuk mengirimkan link reset password
    public function sendResetLinkEmail(Request $request)
    {
        // Validasi email
        $request->validate(['email' => 'required|email|exists:users,email']);

        Log::info("Sending password reset email to : " . $request->email);
        // Mengirimkan link reset password
        $response = Password::sendResetLink($request->only('email'));

        Log::info("Response from reset Link : " . $response);
        // Mengembalikan respon berdasarkan status
        if ($response == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'We have e-mailed your password reset link!'], 200);
        } else {
            return response()->json(['error' => 'We cannot find a user with that email address.'], 400);
        }

        // Log::info("Response from reset Link : " . $response);
    }

    public function reset(Request $request)
    {
        // Validasi data reset
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        // Melakukan reset password
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );

        // Mengembalikan respon berdasarkan status
        if ($response == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Your password has been reset!'], 200);
        } else {
            return response()->json(['error' => 'Invalid token or email address.'], 400);
        }
    }
}
