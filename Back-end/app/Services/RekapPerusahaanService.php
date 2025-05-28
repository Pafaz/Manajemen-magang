<?php
namespace App\Services;

use App\Helpers\Api;
use App\Interfaces\CabangInterface;
use App\Interfaces\JurnalInterface;
use App\Interfaces\MagangInterface;
use App\Interfaces\RekapCabangInterface;
use App\Interfaces\RekapPerusahaanInterface;


class RekapPerusahaanService
{
    private JurnalInterface $jurnalInterface;
    private MagangInterface $magangInterface;
    private CabangInterface $cabangInterface;
    private RekapPerusahaanInterface $rekapPerusahaanInterface;
    private RekapCabangInterface $rekapCabangInterface;

    public function __construct(JurnalInterface $jurnalInterface, MagangInterface $magangInterface, RekapPerusahaanInterface $rekapPerusahaanInterface, CabangInterface $cabangInterface, RekapCabangInterface $rekapCabangInterface)   
    {
        $this->jurnalInterface = $jurnalInterface;
        $this->magangInterface = $magangInterface;
        $this->rekapPerusahaanInterface = $rekapPerusahaanInterface;
        $this->rekapCabangInterface = $rekapCabangInterface;
        $this->cabangInterface = $cabangInterface;
    }

    public function simpanRekap()
    {
        $id = auth('sanctum')->user()->perusahaan->id; 

        // dd($id);
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

        $this->rekapPerusahaanInterface->update($id, $rekap);
    }

    public function getRekap($id = null)
    {
        $id = auth('sanctum')->user()->perusahaan->id; 

        $rekapPerusahaan = $this->rekapPerusahaanInterface->find($id);

        if (!$rekapPerusahaan) {
            return Api::response(
                'null',
                'Rekap Perusahaan tidak ditemukan',
            );
        }

        return Api::response(
            $rekapPerusahaan,
            'Rekap Perusahaan berhasil ditampilkan',
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
