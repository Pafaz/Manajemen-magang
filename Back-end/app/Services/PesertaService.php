<?php

namespace App\Services;

use App\Helpers\Api;
use App\Http\Resources\JurnalResource;
use App\Services\FotoService;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MagangInterface;
use App\Interfaces\PesertaInterface;
use App\Http\Resources\PesertaResource;
use App\Http\Resources\PesertaDetailResource;
use App\Http\Resources\PesertaJurnalResource;
use App\Http\Resources\PesertaKehadiranResource;
use Symfony\Component\HttpFoundation\Response;

class PesertaService
{
    private PesertaInterface $pesertaInterface;
    private FotoService $foto;

    public function __construct(PesertaInterface $pesertaInterface, FotoService $foto)
    {
        $this->foto = $foto;
        $this->pesertaInterface = $pesertaInterface;
    }

    public function getPeserta($id = null, $isUpdate = false)
    {
        $data = $isUpdate
            ? $this->pesertaInterface->find($id)
            : $this->pesertaInterface->getAll();
            
        return Api::response(
            PesertaResource::collection($data),
            'Berhasil mengambil data peserta', 
        );
    }

    public function getPesertaByCabang(){
        $cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->pesertaInterface->getByCabang($cabang);
        // dd($data);
        return Api::response(
            PesertaResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getJurnalPesertaByCabang(){
        $cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->pesertaInterface->getJurnalPeserta($cabang);
        // dd($data);
        return Api::response(
            PesertaJurnalResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    public function getKehadiranPesertaByCabang()
    {
        $cabang = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->pesertaInterface->getKehadiranPeserta($cabang);
        // dd($data);
        return Api::response(
            PesertaKehadiranResource::collection($data),
            'Peserta Fetched Successfully',
            Response::HTTP_OK
        );
    }

    // public function getPesertaDivisi()
    // {
    //     $cabang = auth('sanctum')->user()->id_cabang_aktif;
    //     $data = $this->pesertaInterface->getByCabang($cabang);
    //     // dd($data);
    //     return Api::response(
    //         PesertaResource::collection($data),
    //         'Peserta Fetched Successfully',
    //         Response::HTTP_OK
    //     );
    // }

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

    public function isApplyLowongan()
    {
        $dataMagang = auth('sanctum')->user()->peserta->magang;

        if ($dataMagang == null) {
            return Api::response(
                'false',
                'Peserta belum Apply Lowongan'
            );
        } else {
            return Api::response(
                'true',
                'Peserta telah Apply Lowongan'
            );
        }
    }

    public function isMagang(){
        if (!auth('sanctum')->user()->id_cabang_aktif) {
            return Api::response(
                'false',
                'Peserta belum terdaftar magang',
            );
        }

        return Api::response(
            'true',
            'Peserta telah terdaftar magang',
        );
    }



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
                'tanggal_lahir', 'nomor_identitas', 'sekolah', 'jurusan'
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
