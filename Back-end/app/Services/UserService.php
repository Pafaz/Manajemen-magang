<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\User;
use App\Interfaces\UserInterface;
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
            'token' => $token,
        ];

        return Api::response(
            $responseData,
            'User logged in successfully',
            Response::HTTP_OK
        );
    }

    public function logout($request){
        $request->user()->currentAccessToken()->delete();
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
            $socialiteUser = Socialite::with('google')->stateless()->userFromCode($data['code']);
        } catch (ClientException $e) {
            return Api::response(
                null,
                'Invalid Google credentials.',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user = User::firstOrNew(['email' => $socialiteUser->getEmail()]);

        if (! $user->exists) {
            $user->fill([
                'name'              => $socialiteUser->getName(),
                'email_verified_at' => now(),
                'google_id'         => $socialiteUser->getId(),
                'avatar'            => $socialiteUser->getAvatar(),
            ])->save();
        }

        $user->assignRole($role);

        $token = $user->createToken('google-token')->plainTextToken;

        $responseData = [
            'user'  => new UserResource($user),
            'token' => $token,
            'role'  => $user->getRoleNames(),
        ];

        return Api::response(
            $responseData,
            'User authenticated via Google',
            Response::HTTP_OK
        );
    }


}
