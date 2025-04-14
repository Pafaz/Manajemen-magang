<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\User;
use App\Interfaces\UserInterface;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    private UserInterface $UserInterface;

    public function __construct(UserInterface $UserInterface)
    {
        $this->UserInterface = $UserInterface;
    }


    public function register_peserta(array $data)
    {
        $user = $this->UserInterface->create($data);

        $user->assignRole('peserta');

        $token = $user->createToken('auth_token')->plainTextToken;

        $responseData = [
            'user' => new UserResource($user),
            'token' => $token,
            'role' => $user->getRoleNames()
        ];

        return Api::response($responseData, 'User  registered successfully', Response::HTTP_CREATED);
    }

    public function register_perusahaan(array $data)
    {
        $user = $this->UserInterface->create($data);

        $user->assignRole('perusahaan');

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
            'School deleted successfully',
            Response::HTTP_OK
        );
    }

    public function resetPassword(array $data)
    {
        $user = $this->UserInterface->find($data['email']);

    }

    public function updatePassword(array $data)
    {
        $user = $this->UserInterface->find($data['email']);
        if (!$user) {
            return Api::response(null, 'User not found', Response::HTTP_NOT_FOUND);
        }    
        $user->password = Hash::make($data['password']);
        $user->save();
    }

}
