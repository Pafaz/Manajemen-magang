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
use App\Interfaces\PesertaInterface;
use App\Interfaces\RekapCabangInterface;
use App\Models\RekapCabang;

class RekapPerusahaanService
{
    private CabangInterface $cabangInterface;
    private JurnalInterface $jurnalInterface;
    private PesertaInterface $pesertaInterface;
    private RekapCabangInterface $rekapCabangInterface;
    private MagangInterface $magangInterface;

    public function __construct(CabangInterface $cabangInterface, JurnalInterface $jurnalInterface, PesertaInterface $pesertaInterface, RekapCabangInterface $rekapCabangInterface, MagangInterface $magangInterface)   
    {
        $this->cabangInterface = $cabangInterface;
        $this->jurnalInterface = $jurnalInterface;
        $this->pesertaInterface = $pesertaInterface;
        $this->rekapCabangInterface = $rekapCabangInterface;
        $this->magangInterface = $magangInterface;
    }

    public function simpanRekap()
    {
        $id = auth('sanctum')->user()->perusahaan->id; 

        $peserta_aktif = $this->magangInterface->countPesertaByPerusahaan($id);
        $peserta_menunggu = $this->magangInterface->countPesertaMenungguByPerusahaan($id);
        $peserta_alumni = $this->magangInterface->countAlumniByPerusahaan($id);
        $total_cabang = $this->cabangInterface->getCabangByPerusahaanId($id)->count();
        $total_jurnal = $this->jurnalInterface->countByPerusahaan($id);

        $rekap = [
            'total_cabang' => $total_cabang,
            'total_jurnal' => $total_jurnal,
            'peserta' => [
                'aktif' => $peserta_aktif,
                'menunggu' => $peserta_menunggu,
                'alumni' => $peserta_alumni,
                'total' => $peserta_aktif + $peserta_menunggu + $peserta_alumni
            ]
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

    public function getRekapAbsensi($id_cabang)
    {
        $rekapCabang = $this->rekapCabangInterface->find($id_cabang);

        $absensi = json_decode($rekapCabang['absensi_12_bulan']);

        return Api::response(
            $absensi,
            'Rekap Peserta berhasil ditampilkan',
        );
    }

    public function getPesertaCabang($id_cabang)
    {
        $rekapCabang = $this->rekapCabangInterface->find($id_cabang);

        $peserta = json_decode($rekapCabang['peserta_per_bulan_tahun']);

        return Api::response(
            $peserta,
            'Rekap Peserta berhasil ditampilkan',
        );
    }

    public function getJurnalCabang($id_cabang)
    {
        // dd($id_cabang);
        $rekapCabang = $this->rekapCabangInterface->find($id_cabang);

        $jurnal = json_decode($rekapCabang['rekap_jurnal_peserta']);

        return Api::response(
            $jurnal,
            'Rekap Jurnal berhasil ditampilkan',
        );
    }
}
