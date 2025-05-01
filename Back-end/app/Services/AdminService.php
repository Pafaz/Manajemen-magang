<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Str;
use App\Services\FotoService;
use App\Interfaces\UserInterface;
use App\Interfaces\AdminInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AdminResource;
use Symfony\Component\HttpFoundation\Response;

class AdminService
{
    private UserInterface $userInterface;
    private AdminInterface $adminInterface;
    private FotoService $foto;

    public function __construct(AdminInterface $adminInterface, FotoService $foto, UserInterface $userInterface)
    {
        $this->adminInterface = $adminInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
    }

    public function getAllAdmin()
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->adminInterface->getAll($id_cabang);

        return Api::response(
            AdminResource::collection($data),
            'Admin Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function findAdmin(string $id)
    {
        $data = $this->adminInterface->find($id);

        return Api::response(
            AdminResource::make($data),
            'Admin Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function createAdmin(array $data)
    {
        DB::beginTransaction();
        try {
            $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
            $user = $this->userInterface->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
                'password' => bcrypt($data['password']),
            ]);

            $user->assignRole('admin');

            $id_user = $user->id;

            $admin = $this->adminInterface->create([
                'id' => Str::uuid(),
                'id_cabang' => $id_cabang,
                'id_user' => $id_user,
            ]);

            $files = [
                'profile' => 'profile',
                'cover' => 'cover'
            ];
            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    $this->foto->createFoto($data[$key], $admin->id, $tipe);
                }
            }

            DB::commit();
            return Api::response(
                AdminResource::make($admin),
                'Admin Created Successfully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollback();
            return Api::response(
                null,
                'Failed to create admin: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updateAdmin(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $admin = $this->adminInterface->find($id);

            $id_user = $admin->user->id;

            if (!$admin) {
                return Api::response(
                    null,
                    'Admin not found',
                    Response::HTTP_NOT_FOUND
                );
            }

            // Update the admin data
            $updatedAdmin = $this->adminInterface->update($id, $data);

            $this->userInterface->update($id_user, $data);

            if (!empty($data['profile']) && !empty($data['header'])) {
                $this->foto->deleteFoto($admin->id);

                $files = [
                    'profile' => 'profile',
                    'cover' => 'cover'
                ];

                foreach ($files as $key => $tipe) {
                    if (!empty($data[$key])) {
                        $this->foto->createFoto($data[$key], $admin->id, $tipe);
                    }
                }
            }

            DB::commit();

            return Api::response(
                AdminResource::make($updatedAdmin),
                'Admin Updated Successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollback();
            return Api::response(
                null,
                'Failed to update admin: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteAdmin(string $id)
    {
        $id_user = $this->adminInterface->find($id)->id_user;

        $this->adminInterface->delete($id);

        $this->userInterface->delete($id_user);

        return Api::response(
            null,
            'Admin Deleted Successfully',
            Response::HTTP_OK
        );
    }
}