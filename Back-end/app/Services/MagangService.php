<?php

namespace App\Services;

use App\Helpers\Api;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MagangInterface;
use App\Http\Resources\MagangResource;
use App\Http\Resources\PesertaResource;
use App\Models\Magang;
use Symfony\Component\HttpFoundation\Response;

class MagangService
{
    private MagangInterface $MagangInterface;
    private FotoService $foto;

    public function __construct(MagangInterface $MagangInterface, FotoService $foto)
    {
        $this->MagangInterface = $MagangInterface;
        $this->foto = $foto;
    }

    public function getAllPesertaMagang()
    {
        $data = $this->MagangInterface->getAll();
        return Api::response(
            MagangResource::collection($data),
            'Magang Fetched Successfully', 
        );
    }

    public function applyMagang(array $data)
    {
        $user = auth('sanctum')->user();
        if (!$user->peserta) {
            return Api::response(null, 'Silahkan lengkapi data diri terlebih dahulu', Response::HTTP_FORBIDDEN);
        }

        if ($this->MagangInterface->alreadyApply($user->peserta->id, $data['id_lowongan'])) {
            return Api::response(null, 'Anda sudah mengajukan magang di lowongan ini', Response::HTTP_FORBIDDEN);
        }
        // dd($peserta);
        $magang = $this->MagangInterface->create([
            'id_peserta' => $user->peserta->id,
            'id_lowongan' => $data['id_lowongan'],
            'mulai' => $data['mulai'],
            'selesai' => $data['selesai'],
            'status' => 'menunggu',
        ]);

        
        $files = [
            'surat_pernyataan_diri' => 'surat_pernyataan_diri',
            'surat_pernyataan_ortu' => 'surat_pernyataan_ortu',
        ];

        foreach ($files as $key => $type) {
            if (!empty($data[$key])) {
                $this->foto->createFoto($data[$key],  $magang->id.'_'.$key, $type, 'magang');
            }
        }
        return Api::response(
            MagangResource::make($magang),
            'Berhasil mengajukan magang',
            Response::HTTP_CREATED
        );
    }

    public function approvalMagang(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            // Ambil data magang yang ingin disetujui atau ditolak
            $magang = $this->MagangInterface->find($id);

            // Cek apakah status yang diberikan valid
            if (!in_array($data['status'], ['diterima', 'ditolak'])) {
                return Api::response(null, 'Status tidak valid', Response::HTTP_BAD_REQUEST);
            }

            // Cek jika status sudah sesuai dengan yang ingin diubah, hindari update yang tidak perlu
            if ($magang->status == $data['status']) {
                return Api::response(null, 'Status sudah sesuai', Response::HTTP_OK);
            }

            // Update status magang
            $magang->status = $data['status'];
            $magang->save();

            $setCabang = auth('sanctum')->user()->id_cabang_aktif = $magang->lowongan->cabang->id;
            $setCabang->save();

            // Hapus magang jika statusnya ditolak
            if ($data['status'] == 'ditolak') {
                $magang->delete();
                $message = 'Berhasil menolak magang';
            } else {
                $message = 'Berhasil menyetujui magang';
            }

            // Commit transaksi
            DB::commit();

            // Kembalikan respons
            return Api::response(
                MagangResource::make($magang),
                $message,
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Kembalikan respons kesalahan
            return Api::response(null, 'Terjadi kesalahan, silakan coba lagi' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function getMagangById(int $id)
    {
        $magang = $this->MagangInterface->find($id);
        return Api::response(
            MagangResource::make($magang),
            'Magang fetched successfully',
            Response::HTTP_OK
        );
    }
}