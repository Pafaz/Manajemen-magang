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
use Exception;

class MentorService
{
    private UserInterface $userInterface;
    private MentorInterface $mentorInterface;
    private FotoService $foto;

    public function __construct(MentorInterface $mentorInterface, FotoService $foto, UserInterface $userInterface)
    {
        $this->mentorInterface = $mentorInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
    }

    public function getAllMentor()
    {
        $id_cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->mentorInterface->getAll($id_cabang);

        return Api::response(
            MentorResource::collection($data),
            'Berhasil Mengambil semua data mentor',
            Response::HTTP_OK
        );
    }

    public function findMentor(string $id)
    {
        $data = $this->mentorInterface->find($id);

        return Api::response(
            MentorResource::make($data),
            'Mentor Berhasil Ditemukan',
            Response::HTTP_OK
        );
    }

        public function simpanMentor(string $id = null, array $data)
    {
        DB::beginTransaction();

        try {
            $id_cabang = auth('sanctum')->user()->id_cabang_aktif;

            if ($id) {
                $mentor = $this->mentorInterface->find($id);

                if (!$mentor) {
                    return Api::response(
                        null,
                        'Mentor not found',
                        Response::HTTP_NOT_FOUND
                    );
                }

                $id_user = $mentor->user->id;
                $this->userInterface->update($id_user, $data);
                $updatedMentor = $this->mentorInterface->update($id, $data);
            } else {
                $user = $this->userInterface->create([
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'telepon' => $data['telepon'],
                    'password' => bcrypt($data['password']),
                ]);

                $user->assignRole('Mentor');

                $mentor = $this->mentorInterface->create([
                    'id' => Str::uuid(),
                    'id_divisi' => $data['id_divisi'],
                    'id_user' => $user->id,
                    'id_cabang' => $id_cabang
                ]);
            }
            $files = [
                'profile' => 'profile',
                'cover' => 'cover'
            ];

            if ((!empty($data['profile']) || !empty($data['cover'])) && $id) {
                $this->foto->deleteFoto($mentor->id);
            }

            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    $this->foto->createFoto($data[$key], $mentor->id, $tipe, 'mentor');
                }
            }

            DB::commit();

            return Api::response(
                MentorResource::make($id ? $updatedMentor : $mentor),
                $id ? 'Berhasil Mengubah Mentor' : 'Berhasil Membuat Mentor',
                $id ? Response::HTTP_OK : Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            DB::rollBack();
            return Api::response(
                null,
                'Gagal Menyimpan Mentor: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


    public function deleteMentor(string $id)
    {
        $id_user = $this->mentorInterface->find($id)->id_user;

        $this->mentorInterface->delete($id);
        $this->userInterface->delete($id_user);

        return Api::response(
            null,
            'Berhasil Menghapus Mentor',
            Response::HTTP_OK
        );
    }
}
