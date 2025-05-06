<?php

namespace App\Services;

use App\Helpers\Api;
use App\Services\FotoService;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MagangInterface;
use App\Interfaces\PesertaInterface;
use App\Http\Resources\PesertaResource;
use App\Http\Resources\PesertaDetailResource;
use Symfony\Component\HttpFoundation\Response;

class PesertaService
{
    private PesertaInterface $pesertaInterface;
    private MagangInterface $magangInterface;
    private FotoService $foto;

    public function __construct(PesertaInterface $pesertaInterface, FotoService $foto, MagangInterface $magangInterface)
    {
        $this->foto = $foto;
        $this->pesertaInterface = $pesertaInterface;
        $this->magangInterface = $magangInterface;
    }

    public function getPeserta($id = null, $isUpdate = false)
    {
        $idcabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $isUpdate
            ? $this->pesertaInterface->find($id)
            : $this->pesertaInterface->getAll();
            
        return Api::response(
            PesertaResource::collection($data),
            'Berhasil mengambil data peserta', 
        );
    }

    public function getPesertaByCabang($cabang){
        $data = $this->pesertaInterface->find($cabang);
        return Api::response(
            PesertaResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function isCompleteProfil()
    {
        if (!auth('sanctum')->user()->peserta) {
            return Api::response(
                'false',
                'Peserta belum melengkapi profil',
                Response::HTTP_OK
            );
        }

        return Api::response(
            'true',
            'Peserta telah melengkapi profil',
            Response::HTTP_OK
        );
    }

    // public function getPesertaByPerusahaan($perusahaan){
    //     $data = $this->pesertaInterface->getByPerusahaan($perusahaan);
    //     return Api::response(
    //         PesertaResource::collection($data),
    //         'Peserta Fetched Successfully',
    //         Response::HTTP_OK
    //     );
    // }

    public function simpanProfilPeserta(array $data, bool $isUpdate = false, $id = null)
    {
        DB::beginTransaction();
        try {
            $user = auth('sanctum')->user();

            if (!$isUpdate && $user->peserta) {
                throw new \Exception("Anda sudah melengkapi profil");
            }

            $dataPeserta = collect($data)->only([
                'nama', 'telepon', 'alamat', 'jenis_kelamin', 'tempat_lahir', 
                'tanggal_lahir', 'nomor_identitas', 'id_sekolah', 'jurusan', 'kelas'
            ])->toArray();

            if (!$isUpdate) {
                $dataPeserta['id_user'] = $user->id;
            }

            $peserta = $isUpdate
                ? $this->pesertaInterface->update($id, $dataPeserta)
                : $this->pesertaInterface->create($dataPeserta);

            $peserta->user->update([
                'nama' => $data['nama'],
                'telepon' => $data['telepon']
            ]);

            // Handle foto
            $files = [
                'profile' => 'profile',
                'cv' => 'cv',
            ];

            foreach ($files as $key => $tipe) {
                if (!empty($data[$key])) {
                    if ($isUpdate) {
                        $this->foto->updateFoto($data[$key], $peserta->id, $tipe, 'peserta');
                    } else {
                        $this->foto->createFoto($data[$key], $peserta->id, $tipe, 'peserta');
                    }
                }
            }

            DB::commit();

            $message = $isUpdate
                ? 'Peserta berhasil memperbarui profil'
                : 'Peserta berhasil melengkapi profil';

            $statusCode = $isUpdate
                ? Response::HTTP_OK
                : Response::HTTP_CREATED;

            return Api::response(
                PesertaResource::make($peserta),
                $message,
                $statusCode
            );

        } catch (\Throwable $th) {
            DB::rollBack();
            return Api::response(
                null,
                'Gagal menyimpan profil peserta: ' . $th->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


    public function deletePeserta( $id)
    {
        $this->pesertaInterface->delete($id);
        return Api::response(
            null,
            'Peserta Deleted Successfully',
            Response::HTTP_OK
        );
    }

}
