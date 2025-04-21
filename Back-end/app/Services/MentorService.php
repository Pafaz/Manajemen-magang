<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Str;
use App\Services\FotoService;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MentorInterface;
use App\Http\Resources\MentorResource;
use Symfony\Component\HttpFoundation\Response;

class MentorService
{
    private UserInterface $userInterface;
    private MentorInterface $MentorInterface;
    private FotoService $foto;

    public function __construct(MentorInterface $MentorInterface, FotoService $foto, UserInterface $userInterface)
    {
        $this->MentorInterface = $MentorInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
    }

    public function getAllMentor()
    {
        $data = $this->MentorInterface->getAll();
        
        return Api::response(
            MentorResource::collection($data),
            'Mentor Berhasil Ditemukan', 
            Response::HTTP_OK
        );
    }

    public function findMentor(string $id)
    {
        $data = $this->MentorInterface->find($id);

        return Api::response(
            MentorResource::make($data),
            'Mentor Berhasil Ditemukan',
            Response::HTTP_OK
        );
    }

    public function createMentor(array $data)
    {
        DB::beginTransaction();
    
        try {
            $user = $this->userInterface->create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'telepon' => $data['telepon'],
                'password' => bcrypt($data['password']),
            ]);
    
            $user->assignRole('Mentor');
    
            $Mentor = $this->MentorInterface->create([
                'id_divisi' => $data['id_divisi'],
                'id_user' => $user->id,
            ]);
    
            // Ensure Mentor is created
            if (!$Mentor) {
                DB::rollBack();
                return Api::response(
                    null,
                    'Failed to create Mentor.',
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }

            if (!empty($data['foto'])) {
                $this->foto->createFoto($data['foto'], $Mentor->id, 'profile');
            }
    
            DB::commit();
            return Api::response(
                MentorResource::make($Mentor),
                'Berhasil Membuat Mentor',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return Api::response(
                null,
                'Failed to create Mentor: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }       
    }
    
    

    public function updateMentor(string $id, array $data)
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
                'Berhasil Mengubah Mentor',
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
    

    public function deleteMentor(string $id)
    {
        $id_user = $this->MentorInterface->find($id)->id_user;

        $this->MentorInterface->delete($id);
        
        $this->userInterface->delete($id_user);

        return Api::response(
            null,
            'Berhasil Menghapus Mentor',
            Response::HTTP_OK
        );
    }
    
}