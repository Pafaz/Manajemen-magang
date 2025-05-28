<?php
namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Api;
use App\Models\RekapCabang;
use App\Interfaces\AdminInterface;
use App\Jobs\UpdateRekapCabangJob;
use App\Interfaces\DivisiInterface;
use App\Interfaces\JurnalInterface;
use App\Interfaces\MagangInterface;
use App\Interfaces\MentorInterface;
use App\Interfaces\AbsensiInterface;
use App\Interfaces\RekapCabangInterface;
use App\Http\Resources\RekapCabangResource;
use App\Interfaces\RekapKehadiranInterface;

class RekapCabangService
{
    private RekapKehadiranInterface $rekapKehadiranInterface;
    private MagangInterface $magangInterface;
    private AdminInterface $adminInterface;
    private MentorInterface $mentorInterface;
    private DivisiInterface $divisiInterface;
    private RekapCabangInterface $rekapCabangInterface;
    private JurnalInterface $jurnalInterface;

    public function __construct(MagangInterface $magangInterface, AdminInterface $adminInterface, MentorInterface $mentorInterface, DivisiInterface $divisiInterface, RekapCabangInterface $rekapCabangInterface, AbsensiInterface $absensiInterface, JurnalInterface $jurnalInterface, RekapKehadiranInterface $rekapKehadiranInterface)
    {
        $this->magangInterface = $magangInterface;
        $this->adminInterface = $adminInterface;
        $this->mentorInterface = $mentorInterface;
        $this->divisiInterface = $divisiInterface;
        $this->rekapCabangInterface = $rekapCabangInterface;
        $this->rekapKehadiranInterface = $rekapKehadiranInterface;
        $this->jurnalInterface = $jurnalInterface;
    }

    public function simpanRekap($id = null)
    {
        $id ? $id : $id = auth('sanctum')->user()->id_cabang_aktif; 
        $total_peserta = $this->magangInterface->getPesertaByCabang($id)->count();
        $total_admin = $this->adminInterface->getByCabang($id)->count();
        $total_mentor = $this->mentorInterface->getAll($id)->count();
        $total_divisi = $this->divisiInterface->getAll($id)->count();

        $pesertaPerDivisi = $this->magangInterface->getMagangPerDivisi($id);
        $mentorPerDivisi = $this->mentorInterface->getMentorPerDivisi($id);
        $pesertaPerBulanDanTahun = $this->magangInterface->countPesertaPerBulanDanTahun($id);
        $rekapJurnalPeserta = $this->getRekapJurnalMingguan($id);
        
        $rekapPerBulan = $this->rekapKehadiranInterface->getByCabangPerBulan($id);

        $rekapKehadiranGabungan = [];
        $tahun = now()->year;

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $formatBulan = sprintf('%d-%02d', $tahun, $bulan);

            $dataBulanIni = $rekapPerBulan->firstWhere('bulan', $formatBulan);

            $rekapKehadiranGabungan[] = [
                'bulan' => Carbon::create($tahun, $bulan)->translatedFormat('F'),
                'hadir' => $dataBulanIni->total_hadir ?? 0,
                'izin' => $dataBulanIni->total_izin ?? 0,
                'alpha' => $dataBulanIni->total_alpha ?? 0,
                'terlambat' => $dataBulanIni->total_terlambat ?? 0,
            ];
        }


        $rekap = [
            'total_peserta' => $total_peserta,
            'total_admin' => $total_admin,
            'total_mentor' => $total_mentor,
            'total_divisi' => $total_divisi,
            'peserta_per_bulan_tahun' => $pesertaPerBulanDanTahun,
            'absensi_12_bulan' => $rekapKehadiranGabungan,
            'rekap_jurnal_peserta' => $rekapJurnalPeserta,
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
            })
        ];

        return $rekap;
        // $this->rekapCabangInterface->update($id, $rekap);
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
            RekapCabangResource::make($rekapCabang),
            'Rekap Cabang berhasil ditampilkan',
        );
    }

    private function getRekapJurnalMingguan($id_cabang)
    {
        $tanggal7HariLalu = now()->subDays(6)->startOfDay();

        $peserta = $this->magangInterface->getPesertaByCabang($id_cabang)->pluck('id');
        $jumlahPeserta = $peserta->count();

        $jurnals = $this->jurnalInterface->getRekapJurnalByPeserta($peserta->toArray())
            ->groupBy('tanggal');

        $hasil = [];

        $jumlahHari = now()->dayOfWeek === 0 ? 7 : now()->dayOfWeek;

        for ($i = 0; $i < $jumlahHari; $i++) {
            $tanggal = $tanggal7HariLalu->copy()->addDays($i)->toDateString();

            $jurnalHariIni = $jurnals->get($tanggal, collect());

            $pesertaMengisi = $jurnalHariIni
                ->filter(fn($j) => trim($j->judul) !== 'kosong')
                ->pluck('id_peserta')
                ->unique();

            $hasil[] = [
                'tanggal' => $tanggal,
                'hari' => Carbon::parse($tanggal)->translatedFormat('l'),
                'mengisi' => $pesertaMengisi->count(),
                'tidak_mengisi' => $jumlahPeserta - $pesertaMengisi->count(),
            ];
        }

        return $hasil;
    }
}

