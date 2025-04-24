<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\PerusahaanDetailResource;
use App\Services\FotoService;
use Illuminate\Support\Facades\Log;
use App\Interfaces\PerusahaanInterface;
use Illuminate\Database\QueryException;
use App\Http\Resources\PerusahaanResource;
use App\Interfaces\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;


class PerusahaanService
{
    private PerusahaanInterface $PerusahaanInterface;
    private FotoService $foto;
    private UserInterface $userInterface;

    public function __construct(PerusahaanInterface $PerusahaanInterface, FotoService $foto, UserInterface $userInterface)
    {
        $this->PerusahaanInterface = $PerusahaanInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
    }

    public function getAllPerusahaan()
    {
        $data = $this->PerusahaanInterface->getAll();
        return Api::response(
            PerusahaanResource::collection($data),
            'Perusahaan Fetched Successfully',
        );
    }

    public function getPerusahaan($id)
    {
        $data = $this->PerusahaanInterface->find($id);
        return Api::response(
            PerusahaanDetailResource::make($data),
            'Perusahaan Fetched Successfully',
        );
    }

    public function getPerusahaanByAuth()
    {
        $data = $this->PerusahaanInterface->findByUser(auth('sanctum')->user()->id);
        return Api::response(
            PerusahaanDetailResource::make($data),
            'Perusahaan Fetched Successfully',
        );
    }

    public function LengkapiProfilPerusahaan(array $data)
    {
        try {
            $user = auth('sanctum')->user();

            if ($user->perusahaan) {
                return Api::response(null, 'Perusahaan already registered', Response::HTTP_BAD_REQUEST);
            }

            // Gunakan transaction untuk memastikan integritas data
            DB::beginTransaction();

            $this->userInterface->update($user->id, [
                'name' => $data['nama'],
                'telepon' => $data['telepon'],
            ]);

            $perusahaan = $this->PerusahaanInterface->create($data);

            $files = [
                'logo' => 'profile',
                'npwp' => 'npwp',
                'surat_legalitas' => 'surat_legalitas',
            ];

            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    $this->foto->createFoto($data[$key], $perusahaan->id, $tipe);
                }
            }

            DB::commit();

            return Api::response(
                PerusahaanResource::make($perusahaan),
                'Complete Company Profile Successfully',
                Response::HTTP_CREATED
            );
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('DB Error creating Perusahaan: ' . $e->getMessage());
            return Api::response(
                null,
                'Registrasi Perusahaan gagal: ' . $e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Unexpected error: ' . $e->getMessage());
            return Api::response(
                null,
                'Terjadi kesalahan saat melengkapi profil perusahaan.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updateProfilePerusahaan(array $data, $id)
    {
        $user = auth('sanctum')->user();

        $userData = array_filter([
            'name' => $data['nama'] ?? null,
            'telepon' => $data['telepon'] ?? null,
            'email' => $data['email'] ?? null,
        ]);

        if (!empty($userData)) {
            $this->userInterface->update($user->id, $userData);
        }

        $Perusahaan = $this->PerusahaanInterface->update($id, array_filter($data));
        return Api::response(
            PerusahaanResource::make($Perusahaan),
            'Perusahaan Updated Successfully',
            Response::HTTP_OK
        );
    }


    public function deletePerusahaan($id)
    {
        $this->PerusahaanInterface->delete($id);

        $id_user = $this->PerusahaanInterface->find($id)->id_user;
        
        $this->userInterface->delete($id_user);

        return Api::response(
            null,
            'Perusahaan Deleted Successfully',
            Response::HTTP_OK
        );
    }
}
