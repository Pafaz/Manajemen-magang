<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Google_Client;

class GoogleAuthController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        $request->validate([
            'credential' => 'required|string',
        ]);

        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($request->credential);

        if (!$payload) {
            return response()->json(['message' => 'Token Google tidak valid'], 401);
        }

        $email = $payload['email'];
        $name = $payload['name'] ?? 'Pengguna Google';
        $googleId = $payload['sub'];

        if (!str_ends_with($email, '@gmail.com')) {
            return response()->json(['message' => 'Email tidak diizinkan. Harus menggunakan @gmail.com'], 403);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            // Register user baru
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(16)), // Dummy password
                'email_verified_at' => now(),
                'id_google' => $googleId, // Optional field, tambahkan ke migration jika perlu
            ]);

            $user->assignRole('peserta');
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Login Google berhasil',
            'user' => $user,
        ]);
    }
}
