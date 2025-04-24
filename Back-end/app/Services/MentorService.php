<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Str;
use App\Services\FotoService;
use App\Interfaces\UserInterface;
use App\Interfaces\MentorInterface;
use App\Interfaces\CabangInterface;
use App\Http\Resources\MentorResource;
use App\Interfaces\PerusahaanInterface;
use Symfony\Component\HttpFoundation\Response;

class MentorService
{
    private UserInterface $userInterface;
    private MentorInterface $MentorInterface;
    private FotoService $foto;
    private PerusahaanInterface $perusahaanInterface;
    private CabangInterface $cabangInterface;

    public function __construct(MentorInterface $MentorInterface, FotoService $foto, PerusahaanInterface $perusahaanInterface, UserInterface $userInterface, CabangInterface $cabangInterface)
    {
        $this->MentorInterface = $MentorInterface;
        $this->foto = $foto;
        $this->perusahaanInterface = $perusahaanInterface;
        $this->userInterface = $userInterface;
        $this->cabangInterface = $cabangInterface;
    }

    public function getAllMentor()
    {
        $data = $this->MentorInterface->getAll();
        
        return Api::response(
            MentorResource::collection($data),
            'Admin Fetched Successfully', 
            Response::HTTP_OK
        );
    }

    public function findMentor(int $id)
    {
        return $this->MentorInterface->find($id);
    }

    public function createMentor(array $data)
    {
        try {
            $perusahaan = $this->perusahaanInterface->findByUser(auth('sanctum')->user()->id);
            $id_cabang = $this->cabangInterface->getIdCabangByPerusahaan($perusahaan->id)->id;
            
            $user = $this->userInterface->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
                'password' => bcrypt($data['password']),
            ]);

            $user->assignRole('Mentor');
    
            $id_user = $user->id;

            $Mentor = $this->MentorInterface->create([
                'id' => Str::uuid(),
                'id_cabang' => $id_cabang,
                'id_user' => $id_user,
            ]);

            if (!empty($data['foto'])) {
                $this->foto->createFoto($data['foto'], $Mentor->id, 'profile');
            }
            return Api::response(
                MentorResource::make($Mentor),
                'Mentor Created Successfully',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return Api::response(
                null,
                'Failed to create Mentor: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }       
    }
    

    public function updateMentor(int $id, array $data)
    {
        try {
            $Mentor = $this->MentorInterface->find($id);
    
            if (!$Mentor) {
                return Api::response(
                    null,
                    'Mentor not found',
                    Response::HTTP_NOT_FOUND
                );
            }
    
            $updatedMentor = $this->MentorInterface->update($id, $data);
    
            if (!empty($data['foto'])) {
                $this->foto->deleteFoto($Mentor->id);
    
                $this->foto->createFoto($data['foto'], $updatedMentor->id, 'profile');
            }
    
            return Api::response(
                MentorResource::make($updatedMentor),
                'Mentor Updated Successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return Api::response(
                null,
                'Failed to update Mentor: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    

    public function deleteMentor(int $id)
    {
        try {
            $Mentor = $this->MentorInterface->find($id);
    
            if (!$Mentor) {
                return Api::response(
                    null,
                    'Mentor not found',
                    Response::HTTP_NOT_FOUND
                );
            }
    
            $id_user = $Mentor->id_user;
    
            $this->MentorInterface->delete($id);
            $this->userInterface->delete($id_user);
    
            return Api::response(
                null,
                'Mentor and associated user deleted successfully',
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return Api::response(
                null,
                'Failed to delete Mentor: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    
}