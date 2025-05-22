<?php

namespace App\Services;

use App\Helpers\Api;
use App\Models\Magang;
use App\Interfaces\AdminInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\DivisiInterface;
use App\Interfaces\MagangInterface;
use App\Interfaces\MentorInterface;

class RekapCabangService
{
    private MagangInterface $magangInterface;
    private AdminInterface $adminInterface;
    private MentorInterface $mentorInterface;
    private DivisiInterface $divisiInterface;
    

    public function __construct(MagangInterface $magangInterface, AdminInterface $adminInterface, MentorInterface $mentorInterface, DivisiInterface $divisiInterface)
    {
        $this->magangInterface = $magangInterface;
        $this->adminInterface = $adminInterface;
        $this->mentorInterface = $mentorInterface;
        $this->divisiInterface = $divisiInterface;
    }

    public function getRekapCabang($id)
    {
        if (auth()->user()->hasRole('admin')) {
            $id_cabang = auth()->user()->id_cabang_aktif;
        } else if($id == null) {
                        return Api::response(
                'null',
                'Masukkan ID Cabang',
            );
        } else {
            $id_cabang = $id;
        }

        // dd($id_cabang);
        $total_peserta = $this->magangInterface->countPeserta($id_cabang);
        $total_admin = $this->adminInterface->getByCabang($id_cabang)->count();
        $total_mentor = $this->mentorInterface->getAll($id_cabang)->count();
        $total_divisi = $this->divisiInterface->getAll($id_cabang)->count();

        $pesertaPerDivisi = $this->magangInterface->getMagangPerDivisi($id_cabang);
        $mentorPerDivisi = $this->mentorInterface->getMentorPerDivisi($id_cabang);

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
}
