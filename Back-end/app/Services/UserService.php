<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\User;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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


    public function register(array $data, $role)
    {
        $user = $this->UserInterface->create($data);

        $user->assignRole($role);

        $token = $user->createToken('auth_token')->plainTextToken;

        $responseData = [
            'user' => new UserResource($user),
            'token' => $token,
            'role' => $user->getRoleNames()
        ];

        return Api::response($responseData, 'User  registered successfully', Response::HTTP_CREATED);
    }

    public function Login(array $data)
    {      
        $user = $this->UserInterface->find($data['email']);

        if ($user) {
            # code...
        }
        if (!$user || !password_verify($data['password'], $user->password)) {
            return Api::response(
                null,
                'Invalid credentials',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $responseData = [
            'user' => new UserResource($user),
            'role' => $user->getRoleNames(),
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

    public function resetPassword(array $data)
    {
        $user = $this->UserInterface->find($data['email']);

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

    public function handleGoogleCallback(array $data, string $role)
    {
        try {
            $redirectUri = ($role == 'peserta') ? env('GOOGLE_REDIRECT_URI_PESERTA') : env('GOOGLE_REDIRECT_URI_PERUSAHAAN');

            $socialiteUser = Socialite::with('google')->stateless()->redirectUrl($redirectUri)->user($data['code']);

        } catch (ClientException $e) {
            Log::error("Google Auth Failed: " . $e->getMessage());
            return Api::response(null, 'Autentikasi Google gagal', 401);
        }

        $user = User::where('email', $socialiteUser->getEmail())->first();

        if ($user) {
            $user->update([
                'google_id' => $socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar()
            ]);
            $user->syncRoles([$role]);
        } else {
            // Buat user baru
            $user = User::create([
                'name' => $socialiteUser->getName(),
                'email' => $socialiteUser->getEmail(),
                'google_id' => $socialiteUser->getId(),
                'avatar' => $socialiteUser->getAvatar(),
                'email_verified_at' => now()
            ]);
            $user->assignRole($role);
        }

        $user->tokens()->delete();

        $token = $user->createToken('google-token')->plainTextToken;

        return Api::response([
            'user' => new UserResource($user),
            'token' => $token,
            'role' => $role
        ], 'Success');
    }
}
