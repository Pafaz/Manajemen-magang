<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Str;
use App\Services\FotoService;
use App\Interfaces\UserInterface;
use App\Interfaces\AdminInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AdminRequest;
use App\Interfaces\CabangInterface;
use App\Http\Resources\UserResource;
use App\Http\Resources\AdminResource;
use App\Interfaces\PerusahaanInterface;
use Symfony\Component\HttpFoundation\Response;

class AdminService
{
    private UserInterface $userInterface;
    private AdminInterface $adminInterface;
    private FotoService $foto;
    private PerusahaanInterface $perusahaanInterface;
    private CabangInterface $cabangInterface;

    public function __construct(AdminInterface $adminInterface, FotoService $foto, PerusahaanInterface $perusahaanInterface, UserInterface $userInterface, CabangInterface $cabangInterface)
    {
        $this->adminInterface = $adminInterface;
        $this->foto = $foto;
        $this->perusahaanInterface = $perusahaanInterface;
        $this->userInterface = $userInterface;
        $this->cabangInterface = $cabangInterface;
    }

    public function getAllAdmin()
    {
        $data = $this->adminInterface->getAll();
        
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

    public function createAdminCabang(array $data)
    {
        try {
            // $perusahaan = $this->perusahaanInterface->findByUser(auth('sanctum')->user()->id);
            // $id_cabang = $this->cabangInterface->getIdCabangByPerusahaan($perusahaan->id)->id;
    
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
                'id_cabang' => $data['id_cabang'],
                'id_user' => $id_user,
            ], 'cabang');

            $files = [
                'foto' => 'profile',
            ];
            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    $this->foto->createFoto($data[$key], $admin->id, $tipe);
                }
            }
            return Api::response(
                AdminResource::make($admin),
                'Admin Created Successfully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return Api::response(
                null,
                'Failed to create admin: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }       
    }

    public function createAdminPerusahaan(array $data)
    {
        try {
            $perusahaan = $this->perusahaanInterface->findByUser(auth('sanctum')->user()->id);
            $id_perusahaan = $perusahaan->id;

            // dd($id_perusahaan);
            
            $user = $this->userInterface->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
                'password' => bcrypt($data['password']),
            ]);

            $user->assignRole('perusahaan');
    
            $id_user = $user->id;

            $admin = $this->adminInterface->create([
                'id' => Str::uuid(),
                'id_perusahaan' => $id_perusahaan,
                'id_user' => $id_user,
            ], 'perusahaan');

            $files = [
                'foto' => 'profile',
            ];
            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    $this->foto->createFoto($data[$key], $admin->id, $tipe);
                }
            }
            return Api::response(
                AdminResource::make($admin),
                'Admin Created Successfully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return Api::response(
                null,
                'Failed to create admin: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }       
    }

    public function updateAdmin(int $id, array $data)
    {
        try {
            $admin = $this->adminInterface->find($id);
    
            if (!$admin) {
                return Api::response(
                    null,
                    'Admin not found',
                    Response::HTTP_NOT_FOUND
                );
            }
    
            $updatedAdmin = $this->adminInterface->update($id, $data);
    
            if (!empty($data['foto'])) {
                $this->foto->deleteFoto($admin->id);
    
                $this->foto->createFoto($data['foto'], $updatedAdmin->id, 'profile');
            }
    
            return Api::response(
                AdminResource::make($updatedAdmin),
                'Admin Updated Successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
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