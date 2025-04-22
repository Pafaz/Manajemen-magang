<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Http\Response;
use App\Interfaces\AdminInterface;
use App\Http\Resources\UserResource;

class AdminService
{
    private AdminInterface $adminInterface;
    private FotoService $foto;

    public function __construct(AdminInterface $adminInterface, FotoService $foto)
    {
        $this->adminInterface = $adminInterface;
        $this->foto = $foto;
    }

    public function getAllAdmin()
    {
        $data = $this->adminInterface->getAll();

        // dd($data);

        return Api::response(
            UserResource::collection($data),
            'Admin Fetched Successfully', 
            Response::HTTP_OK
        );
    }

    public function findAdmin(int $id)
    {
        return $this->adminInterface->find($id);
    }

    public function createAdmin(array $data)
    {
        $existingAdmin = $this->adminInterface->getByCabang($data['id_cabang']);
        if ($existingAdmin) {
            return Api::response(
                null,
                'Only one admin is allowed per cabang.',
                Response::HTTP_BAD_REQUEST
            );
        }
    
        $admin = $this->adminInterface->create($data);
    
        $admin->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    
        $admin->user->assignRole('admin');
    
        $files = [
            'foto' => 'profile',
        ];
        foreach ($files as $key => $tipe) {
            if (!empty($data[$key])) {
                $this->foto->createFoto($data[$key], $admin->id, $tipe);
            }
        }
    
        return Api::response(
            UserResource::make($admin),
            'Admin Created Successfully',
            Response::HTTP_CREATED
        );
    }
    

    public function updateAdmin(int $id, array $data)
    {
        $admin = $this->adminInterface->update($id, $data);
        return Api::response( 
            UserResource::make($admin),
            'Admin Updated Successfully',
            Response::HTTP_OK
        );
    }

    public function deleteAdmin(int $id)
    {
        $this->adminInterface->delete($id);
        return Api::response(
            null,
            'Admin Deleted Successfully',
            Response::HTTP_OK
        );
    }
}