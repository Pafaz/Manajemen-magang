<?php

namespace App\Services;

use App\Helpers\Api;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MagangInterface;
use App\Http\Resources\MagangResource;
use App\Http\Resources\PesertaResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MagangDetailResource;
use App\Models\Surat;
use Symfony\Component\HttpFoundation\Response;

class MagangService
{
    private MagangInterface $MagangInterface;
    private FotoService $foto;

    private SuratService $suratService;
    private UserInterface $userInterface;

    public function __construct(MagangInterface $MagangInterface, FotoService $foto, UserInterface $userInterface, SuratService $suratService)
    {
        $this->MagangInterface = $MagangInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
        $this->suratService = $suratService;
    }

    public function getAllPesertaMagang()
    {
        $id = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->MagangInterface->getAll($id);
        return Api::response(
            MagangResource::collection($data),
            'Berhasil mendapatkan data peserta magang', 
        );
    }

    public function countPendaftar($lowonganId)
    {
        return $this->MagangInterface->countPendaftar($lowonganId);
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

        $magang = $this->MagangInterface->create([
            'id_peserta' => $user->peserta->id,
            'id_lowongan' => $data['id_lowongan'],
            'mulai' => $data['mulai'],
            'selesai' => $data['selesai'],
            'status' => 'menunggu',
        ]);

        if (!empty($data['surat_pernyataan_diri'])) {
            $this->foto->createFoto($data['surat_pernyataan_diri'],  $magang->id, 'surat_pernyataan_diri', 'magang');
        }
        return Api::response(
            MagangDetailResource::make($magang),
            'Berhasil mengajukan magang',
            Response::HTTP_CREATED
        );
    }

    public function approvalMagang(int $id, array $data)
    {
        // dd($id, $data);
        DB::beginTransaction();

        try {
            $magang = $this->MagangInterface->find($id);

            if (!in_array($data['status'], ['diterima', 'ditolak'])) {
                return Api::response(null, 'Status tidak valid', Response::HTTP_BAD_REQUEST);
            }

            if ($magang->status == $data['status']) {
                return Api::response(null, 'Status sudah sesuai', Response::HTTP_OK);
            }

            $magang->status = $data['status'];
            $magang->save();

            $id_peserta = $magang->peserta->user->id;

            $this->userInterface->update($id_peserta, ['id_cabang_aktif' => $magang->lowongan->id_cabang]);

            // dd($magang->lowongan->id_cabang);
            $dataSurat = [
                'id_peserta' => $magang->peserta->id,
                'id_cabang' => $magang->lowongan->cabang->id,
                'id_perusahaan' => $magang->lowongan->perusahaan->id,
                'perusahaan' => $magang->lowongan->perusahaan->user->nama,
                'alamat_perusahaan' => $magang->lowongan->perusahaan->alamat,
                'telepon_perusahaan' => $magang->lowongan->perusahaan->user->telepon,
                'email_perusahaan' => $magang->lowongan->perusahaan->user->email,
                'website_perusahaan' => $magang->lowongan->perusahaan->website,
                'no_surat' => 'CARA PRAKOSO',
                'sekolah' => $magang->peserta->sekolah,
                // 'alamat_mitra' => $magang->peserta->sekolah->alamat,
                // 'telepon_mitra' => $magang->peserta->sekolah->telepon,
                'tanggal_mulai' => $magang->mulai,
                'tanggal_selesai' => $magang->selesai,
                'peserta'=> $magang->peserta->user->nama,
                'no_identitas' => $magang->peserta->nomor_identitas,
                'penanggung_jawab' => $magang->lowongan->perusahaan->nama_penanggung_jawab,
                'jabatan_pj'=> $magang->lowongan->perusahaan->jabatan_penanggung_jawab,
            ];

            // dd($dataSurat);

            if ($data['status'] == 'ditolak') {
                $magang->delete();
                $message = 'Berhasil menolak magang';
            } else {
                $message = 'Berhasil menyetujui magang';
                $this->suratService->createSurat($dataSurat, 'penerimaan');
            }

            DB::commit();

            return Api::response(
                MagangResource::make($magang),
                $message,
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            DB::rollBack();

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