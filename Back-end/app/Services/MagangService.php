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
use Symfony\Component\HttpFoundation\Response;

class MagangService
{
    private MagangInterface $MagangInterface;
    private FotoService $foto;
    private UserInterface $userInterface;

    public function __construct(MagangInterface $MagangInterface, FotoService $foto, UserInterface $userInterface)
    {
        $this->MagangInterface = $MagangInterface;
        $this->foto = $foto;
        $this->userInterface = $userInterface;
    }

    public function getAllPesertaMagang($status = null)
    {
        $id = auth('sanctum')->user()->id_cabang_aktif;
        $data = $this->MagangInterface->getAll($id, $status);
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
                $this->foto->createFoto($data[$key],  $magang->id, $type, 'magang');
            }
        }
        return Api::response(
            MagangDetailResource::make($magang),
            'Berhasil mengajukan magang',
            Response::HTTP_CREATED
        );
    }

    public function approvalMagang(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            $magang = $this->MagangInterface->find($id);

            // dd($magang);
            if (!in_array($data['status'], ['diterima', 'ditolak'])) {
                return Api::response(null, 'Status tidak valid', Response::HTTP_BAD_REQUEST);
            }

            if ($magang->status == $data['status']) {
                return Api::response(null, 'Status sudah sesuai', Response::HTTP_OK);
            }

            $magang->status = $data['status'];
            $magang->save();

            $this->userInterface->update($magang->peserta->user->id, ['id_cabang_aktif' => $magang->lowongan->id_cabang]);

            $dataSurat = [
                            'nomor' => '154',
                            'sekolah' => $magang->peserta->user->nama,
                            'alamat_sekolah' => $magang->peserta->sekolah->alamat,
                            'nama_perusahaan' => $magang->lowongan->perusahaan->user->nama,
                            'tanggal_mulai' => $magang->mulai,
                            'tanggal_selesai' => $magang->selesai,
                            'peserta' => $magang->peserta->user->nama,
                            'no_identitas' => $magang->peserta->nomor_identitas
                        ];

            // dd($dataSurat);

            if ($data['status'] == 'ditolak') {
                $magang->delete();
                $message = 'Berhasil menolak magang';
            } else {
                $message = 'Berhasil menyetujui magang';

                $pdf = Pdf::loadView('surat.penerimaan', $dataSurat);

                $fileName = 'surat-penerimaan-' . $magang->id_lowongan . '.pdf';
                $filePath = 'surat_penerimaan/' . $fileName;

                Storage::disk('public')->put($filePath, $pdf->output());
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