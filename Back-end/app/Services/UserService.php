<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    private UserInterface $UserInterface;

    public function __construct(UserInterface $UserInterface)
    {
        $this->UserInterface = $UserInterface;
    }


    public function register(array $data)
    {
        $role = session('role');

        if (empty($role) || !in_array($role, ['peserta', 'perusahaan'])) {
            return Api::response(null, 'Invalid Role', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->UserInterface->create(array_merge($data, ['role' => $role]));

        $token = $user->createToken('auth_token')->plainTextToken;

        $responseData = [
            'user' => new UserResource($user),
            'token' => $token,
        ];

        return Api::response($responseData, 'User  registered successfully', Response::HTTP_CREATED);
    }

    public function Login(array $data)
    {
        $user = $this->UserInterface->find($data['email']);

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

    public function deleteUser(int $id)
    {
        $this->UserInterface->delete($id);
        return Api::response(
            null,
            'School deleted successfully',
            Response::HTTP_OK
        );
    }

}
