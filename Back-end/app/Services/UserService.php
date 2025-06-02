<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    private UserInterface $UserInterface;

    public function __construct(UserInterface $UserInterface)
    {
        $this->UserInterface = $UserInterface;
    }

    public function getData($user)
    {
        $data = [
            'user' => new UserResource($user),
            'role' => $user->getRoleNames()->first(),
        ];
        return Api::response($data, 'success get data user', Response::HTTP_OK);
    }

    public function register(array $data)
    {
        return $this->UserInterface->create($data);
    }

    public function assignRole($request, $role)
    {
        $user = $this->UserInterface->findId($request->id_user);

        $user->assignRole($role);
        $token = $user->createToken('auth_token')->plainTextToken;

        $responseData = [
            'user'=> new UserResource($user),
            'token'=> $token,
            'role' => $role
        ];

        return Api::response($responseData, 'User  registered successfully', Response::HTTP_CREATED);
    }

    public function Login(array $data)
    {
        $user = $this->UserInterface->find($data['email']);

        if (!Hash::check($data['password'], $user->password)) {
            return Api::response(
                null,
                'Password Salah',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $remember = $data['remember_me'];
        $token = $remember
            ? $user->createToken('auth_token', ['remember'])->plainTextToken
            : $user->createToken('auth_token')->plainTextToken;

        $responseData = [
            'user' => new UserResource($user),
            'role' => $user->getRoleNames()[0],
            'token' => $token,
        ];

        return Api::response(
            $responseData,
            'User logged in successfully',
            Response::HTTP_OK
        );
    }

    public function logout($user){
        $user->currentAccessToken()->delete();
        return Api::response(
            null,
            'User logged out successfully',
            Response::HTTP_OK
        );
    }

    public function deleteUser(int $id)
    {
        $this->UserInterface->delete($id);
        return Api::response(
            null,
            'User deleted successfully',
            Response::HTTP_OK
        );
    }

    public function updatePassword(array $data)
    {
        // $userId = auth()->user();
        $userId = Auth::user()->id;

        $user = $this->UserInterface->findId($userId);

        if (!$user) {
            return Api::response(null, 'User not found', Response::HTTP_NOT_FOUND);
        }

        if (!Hash::check($data['old_password'], $user->password)) {
            return Api::response(null, 'Password lama tidak sesuai', Response::HTTP_UNAUTHORIZED);
        }

        $updateData = [
            'password' => Hash::make($data['new_password']),
        ];

        $this->UserInterface->update($userId, $updateData);

        return Api::response(null, 'Password berhasil diperbarui', Response::HTTP_OK);
    }

    public function handleGoogleCallback(array $data)
    {
        try {
            $redirectUri = env('GOOGLE_REDIRECT_URI');
            
            $socialiteUser = Socialite::with('google')->stateless()->redirectUrl($redirectUri)->user($data['code']);
        } catch (ClientException $e) {
            Log::error("Google Auth Failed: " . $e->getMessage());
            return Api::response(null, 'Autentikasi Google gagal', 401);
        }

        $user = $this->UserInterface->find($socialiteUser->getEmail());

        if ($user) {
            $user->update([
                'google_id' => $socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar()
            ]);

            if ($user->getRoleNames()->isNotEmpty()) {
                $user->tokens()->delete();
                $token = $user->createToken('google-token')->plainTextToken;
                Auth::login($user);

                return Api::response([
                    'user' => new UserResource($user),
                    'token' => $token
                ], 'Login berhasil');
            } else {
                return Api::response(
                    new UserResource($user), 
                    'Google register berhasil, namun role belum ditetapkan'
                );
            }

        } else {
            $user = User::create([
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'google_id' => $socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar(),
                'email_verified_at' => now()
            ]);

            return Api::response(
                new UserResource($user),
                'Google register berhasil, namun role belum ditetapkan'
            );
        }
    }

    public function sendOtp($request)
    {
        $email = $request->email;
        try {
            $otp = rand(1000, 9999);

            $expiresAt = Carbon::now()->addMinutes(5);

            DB::table('password_resets')->insert([
                'email' => $email,
                'otp' => $otp,
                'created_at' => Carbon::now(),
                'expires_at' => $expiresAt,
            ]);

            $content = "Kode OTP kamu untuk reset password adalah: $otp. OTP ini akan kadaluarsa selama 5 menit.";
            Mail::raw($content, function ($message) use ($email) {
                $message->to($email)
                        ->subject('Password Reset OTP');
            });

            return Api::response(
                null,
                'OTP telah terkirim di email kamu'
            );
        } catch (\Exception $e) {
            return Api::response(
                null,
                'Gagal Mengirim OTP: '.$e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function verifyOtp($request)
    {
        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

        if ($reset) {
            return Api::response(
                null,
                'OTP benar, kamu dapat mengganti password sekarang'
            );
        } else {
            return Api::response(
                null,
                'OTP salah atau telah kadaluarsa',
                Response::HTTP_OK
            );
        }
    }

    public function updatePasswordWithOtp($request)
    {
        $reset = DB::table('password_resets')
                    ->where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

        if (!$reset) {
            return Api::response(
                null,
                'OTP salah atau telah kadaluarsa',
                Response::HTTP_OK
            );
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();

            DB::table('password_resets')->where('email', $request->email)->delete();

            return Api::response(
                null,
                'Password Berhasil di Update'
            );
        } else {
            return Api::response(
                null,
                'Pengguna tidak ditemukan',
                Response::HTTP_NOT_FOUND
            );
        }
    }
}
