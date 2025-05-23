<?php
namespace App\Services;

use App\Helpers\Api;
use App\Models\RekapCabang;
use App\Interfaces\AdminInterface;
use App\Jobs\UpdateRekapCabangJob;
use App\Interfaces\DivisiInterface;
use App\Interfaces\MagangInterface;
use App\Interfaces\MentorInterface;
use App\Interfaces\RekapCabangInterface;

class RekapCabangService
{
    private MagangInterface $magangInterface;
    private AdminInterface $adminInterface;
    private MentorInterface $mentorInterface;
    private DivisiInterface $divisiInterface;
    private RekapCabangInterface $rekapCabangInterface;

    public function __construct(MagangInterface $magangInterface, AdminInterface $adminInterface, MentorInterface $mentorInterface, DivisiInterface $divisiInterface, RekapCabangInterface $rekapCabangInterface)
    {
        $this->magangInterface = $magangInterface;
        $this->adminInterface = $adminInterface;
        $this->mentorInterface = $mentorInterface;
        $this->divisiInterface = $divisiInterface;
        $this->rekapCabangInterface = $rekapCabangInterface;
    }

    public function getRekapCabang($id = null)
    {
        $id ? $id : $id = auth()->user()->id_cabang_aktif;   

        // dd($id_cabang);
        $total_peserta = $this->magangInterface->countPeserta($id);
        $total_admin = $this->adminInterface->getByCabang($id)->count();
        $total_mentor = $this->mentorInterface->getAll($id)->count();
        $total_divisi = $this->divisiInterface->getAll($id)->count();

        $pesertaPerDivisi = $this->magangInterface->getMagangPerDivisi($id);
        $mentorPerDivisi = $this->mentorInterface->getMentorPerDivisi($id);

        $rekap = [
            'total_peserta' => $total_peserta,
            'total_admin' => $total_admin,
            'total_mentor' => $total_mentor,
            'total_divisi' => $total_divisi,
            'peserta_per_divisi' => $pesertaPerDivisi->map(function ($item) {
                return [
                    'id_divisi' => $item->id_divisi,
                    'nama_divisi' => $item->divisi->nama ?? '-',
                    'total_peserta' => $item->total,
                ];
            }),
            'mentor_per_divisi' => $mentorPerDivisi->map(function ($item) {
                return [
                    'id_divisi' => $item->id_divisi,
                    'nama_divisi' => $item->divisi->nama ?? '-',
                    'total_mentor' => $item->total,
                ];
            }),
        ];

        return Api::response(
            $rekap,
            'Rekap Cabang berhasil ditampilkan',
        );
    }

    public function simpanRekap($id = null)
    {
        $id ? $id : $id = auth('sanctum')->user()->id_cabang_aktif; 

        $total_peserta = $this->magangInterface->countPeserta($id);
        $total_admin = $this->adminInterface->getByCabang($id)->count();
        $total_mentor = $this->mentorInterface->getAll($id)->count();
        $total_divisi = $this->divisiInterface->getAll($id)->count();

        $pesertaPerDivisi = $this->magangInterface->getMagangPerDivisi($id);
        $mentorPerDivisi = $this->mentorInterface->getMentorPerDivisi($id);

        $rekap = [
            'total_peserta' => $total_peserta,
            'total_admin' => $total_admin,
            'total_mentor' => $total_mentor,
            'total_divisi' => $total_divisi,
            'peserta_per_divisi' => $pesertaPerDivisi->map(function ($item) {
                return [
                    'id_divisi' => $item->id_divisi,
                    'nama_divisi' => $item->divisi->nama ?? '-',
                    'total_peserta' => $item->total,
                ];
            }),
            'mentor_per_divisi' => $mentorPerDivisi->map(function ($item) {
                return [
                    'id_divisi' => $item->id_divisi,
                    'nama_divisi' => $item->divisi->nama ?? '-',
                    'total_mentor' => $item->total,
                ];
            }),
        ];

        $rekapCabang = $this->rekapCabangInterface->update($id, $rekap);
    }

    public function getRekap($id = null)
    {
        $id ? $id : $id = auth('sanctum')->user()->id_cabang_aktif; 

        $rekapCabang = $this->rekapCabangInterface->find($id);

        if (!$rekapCabang) {
            return Api::response(
                'null',
                'Rekap Cabang tidak ditemukan',
            );
        }

        return Api::response(
            $rekapCabang,
            'Rekap Cabang berhasil ditampilkan',
        );
    }
}
