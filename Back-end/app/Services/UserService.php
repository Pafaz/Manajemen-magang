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
        $user = $this->UserInterface->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        $role = session('role');

        if (!in_array($role, ['peserta', 'perusahaan'])) {
            return Api::response(
                null,
                'Unauthorized Invalid Role',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $responseData = [
            'user' => new UserResource($user),
            'token' => $token,
        ];

        return Api::response($responseData, 'User registered successfully', Response::HTTP_CREATED);
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

        return Api::response(
            UserResource::make($user),
            'User logged in successfully',
            Response::HTTP_OK
        );
    }

    // public function updateSchool(int $id, array $data)
    // {
    //     $school = $this->UserInterface->update($id, $data);
    //     return Api::response(
    //         SchoolResource::make($school),
    //         'School updated successfully',
    //         Response::HTTP_OK
    //     );
    // }

    public function deleteUser(int $id)
    {
        $this->UserInterface->delete($id);
        return Api::response(
            null,
            'School deleted successfully',
            Response::HTTP_OK
        );
    }

    // public function getSchoolById(int $id)
    // {
    //     $school = $this->UserInterface->find($id);
    //     return Api::response(
    //         SchoolResource::make($school),
    //         'School fetched successfully',
    //         Response::HTTP_OK
    //     );
    // }
}
