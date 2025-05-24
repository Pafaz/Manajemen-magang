<?php
namespace App\Services;

use App\Helpers\Api;
use App\Models\Jurnal;
use App\Models\Absensi;
use App\Interfaces\AdminInterface;
use App\Interfaces\CabangInterface;
use App\Interfaces\DivisiInterface;
use App\Interfaces\JurnalInterface;
use App\Interfaces\MagangInterface;
use App\Interfaces\MentorInterface;
use App\Interfaces\AbsensiInterface;
use App\Interfaces\RekapCabangInterface;

class RekapPerusahaanService
{
    private CabangInterface $cabangInterface;
    private MagangInterface $magangInterface;
    private JurnalInterface $jurnalInterface;
    private AbsensiInterface $absensiInterface;

    public function __construct(MagangInterface $magangInterface, CabangInterface $cabangInterface, JurnalInterface $jurnalInterface, AbsensiInterface $absensiInterface)   
    {
        $this->magangInterface = $magangInterface;
        $this->cabangInterface = $cabangInterface;
        $this->jurnalInterface = $jurnalInterface;
        $this->absensiInterface = $absensiInterface;
    }

    public function simpanRekap($id = null)
    {
        $id ? $id : $id = auth('sanctum')->user()->id_cabang_aktif; 

        $total_peserta = $this->magangInterface->countPeserta($id);
        $total_cabang = $this->cabangInterface->getCabangByPerusahaanId($id)->count();
        $total_jurnal = $this->jurnalInterface->countByPerusahaan($id);
        $hadir_per_cabang = $this->absensiInterface->countAbsensiByCabang();

        $rekap = [
            'total_peserta' => $total_peserta,
            'total_cabang' => $total_cabang,
            'total_jurnal' => $total_jurnal,
            'hadir_per_cabang' => $hadir_per_cabang->map(function ($item) {
                return [
                    'id_cabang' => $item->id_cabang,
                    'nama_cabang' => $item->cabang->nama ?? '-',
                    'total_hadir' => $item->total,
                ];
            })
        ];

        return Api::response(
            $rekap,
            'Rekap Cabang berhasil disimpan',
        );
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
