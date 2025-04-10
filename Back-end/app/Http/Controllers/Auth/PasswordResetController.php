<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        return response()->json(['status' => 'Reset link sent!', 'token' => $token], 200);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();
    
        if (!$record || $record->token !== $request->token) {
            return response()->json(['error' => 'Invalid token or email.'], 400);
        }
    
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
    
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    
            return response()->json(['status' => 'Password has been reset!'], 200);
        }
    
        return response()->json(['error' => 'User  not found.'], 404);
    }
}