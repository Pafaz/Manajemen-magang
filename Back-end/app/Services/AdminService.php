<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Str;
use App\Services\FotoService;
use App\Interfaces\UserInterface;
use App\Interfaces\AdminInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AdminResource;
use Illuminate\Support\Facades\Cache;
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
        $id_cabang = auth()->user()->id_cabang_aktif;
        $caheKey = 'admin_cabang_'.$id_cabang;
        $data = Cache::remember($caheKey, now()->addDay(), function () use ($id_cabang) {
            return $this->adminInterface->getAll($id_cabang);
        });

        return Api::response(
            AdminResource::collection($data),
            'Admin Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function findAdmin(string $id)
    {
        $cacheKey = 'admin_'.$id;
        $data = Cache::remember($cacheKey, now()->addDay(), function () use ($id) {
            return $this->adminInterface->find($id);
        });

        return Api::response(
            AdminResource::make($data),
            'Admin Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function simpanAdmin(string $id = null, array $data)
    {
        DB::beginTransaction();
        try {
            $id_cabang = auth('sanctum')->user()->id_cabang_aktif;

            if ($id) {
                $admin = $this->adminInterface->find($id);
                if (!$admin) {
                    return Api::response(
                        null,
                        'Admin not found',
                        Response::HTTP_NOT_FOUND
                    );
                }

                $id_user = $admin->user->id;
                $updatedAdmin = $this->adminInterface->update($id, $data);
                $this->userInterface->update($id_user, $data);
                Cache::forget('admin_'. $id);
                Cache::forget('admin_cabang'. $id_cabang);
            } else {
                $user = $this->userInterface->create([
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'id_cabang_aktif' => $id_cabang,
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
                Cache::forget('admin_cabang'. $id_cabang);
            }

            $files = [
                'profile' => 'profile',
                'cover' => 'cover'
            ];

            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    $this->foto->updateFoto($data[$key], $admin->id, $tipe, 'admin');
                }
            }

            DB::commit();

            return Api::response(
                AdminResource::make($id ? $updatedAdmin : $admin),
                $id ? 'Admin Updated Successfully' : 'Admin Created Successfully',
                $id ? Response::HTTP_OK : Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollback();
            return Api::response(
                null,
                'Failed to save admin: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteAdmin(string $id)
    {
        $admin = $this->adminInterface->find($id);
        
        $this->adminInterface->delete($id);

        $this->userInterface->delete($admin->id_user);

        Cache::forget('admin_cabang_'. $admin->id_cabang);
        
        return Api::response(
            null,
            'Admin Deleted Successfully',
            Response::HTTP_OK
        );
    }
}
