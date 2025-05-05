<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class PasswordResetController extends Controller
{
    public function sendOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $otp = rand(1000, 9999);

            $expiresAt = Carbon::now()->addMinutes(5);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $otp,
                'created_at' => Carbon::now(),
                'expires_at' => $expiresAt,
            ]);

            // Teks email yang berisi OTP
            $content = "Kode OTP kamu untuk reset password adalah: $otp. OTP ini akan kadaluarsa selama 5 menit.";
            Mail::raw($content, function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Password Reset OTP');
            });

            // Mengembalikan response sukses
            return response()->json(['message' => 'OTP telah terkirim di email kamu!'], 200);
        } catch (\Exception $e) {
            // Menangani error jika ada masalah
            return response()->json(['error' => 'Gagal mengirim OTP: ' . $e->getMessage()], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        // Validasi OTP
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        // Cek apakah OTP yang dimasukkan valid
        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->where('token', $request->otp)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

        if ($reset) {
            // OTP valid, kirim respons sukses
            return response()->json(['message' => 'OTP benar.Kamu dapat mengganti password sekarang'], 200);
        } else {
            // OTP tidak valid atau kedaluwarsa
            return response()->json(['error' => 'OTP salah atau telah kadaluarsa'], 400);
        }
    }

    public function updatePassword(Request $request)
    {
        // Validasi password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Update password pengguna
        $user = \App\Models\User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        // Hapus data OTP yang sudah digunakan
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Mengembalikan response sukses
        return response()->json(['message' => 'Password Berhasil di Update'], 200);
    }
}
