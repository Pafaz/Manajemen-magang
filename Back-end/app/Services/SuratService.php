<?php

namespace App\Services;

use App\Models\Surat;
use App\Models\Cabang;
use App\Models\Peserta;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Interfaces\SuratInterface;
use Illuminate\Support\Facades\Storage;

class SuratService
{
    private SuratInterface $suratInterface;

    public function __construct(SuratInterface $suratInterface)
    {
        $this->suratInterface = $suratInterface;
    }

    // public function createSurat(array $data, $jenis)
    // {
    //     // dd($data['id_peserta']);
    //     $pdf = Pdf::loadView('surat.penerimaan', $data);

    //     $fileName = 'surat-penerimaan-' . $data['peserta'] .'-'. $data['id_peserta']. '.pdf';
    //     $filePath = 'penerimaan/' . $fileName;

    //     $this->suratInterface->create([
    //         'id_peserta' => $data['id_peserta'],
    //         'id_admin_cabang' => $data['id_cabang'],
    //         'id_perusahaan' => $data['id_perusahaan'],
    //         'jenis' => $jenis,
    //         'file_path' => $filePath
    //     ]);

    //     Storage::disk('public')->put($filePath, $pdf->output());
    // }

    public function createSurat(array $data, $jenis)
    {
        // dd($data);
        // Cek apakah id_peserta valid dan ada di tabel peserta
        $peserta = Peserta::find($data['id_peserta']);
        if (!$peserta) {
            throw new \InvalidArgumentException('ID Peserta tidak ditemukan');
        }

        // Cek apakah id_admin_cabang valid dan ada di tabel admin_cabang
        $adminCabang = Cabang::find($data['id_cabang']);
        if (!$adminCabang) {
            throw new \InvalidArgumentException('ID Admin Cabang tidak ditemukan');
        }

        // Cek apakah id_perusahaan valid dan ada di tabel perusahaan
        $perusahaan = Perusahaan::find($data['id_perusahaan']);
        if (!$perusahaan) {
            throw new \InvalidArgumentException('ID Perusahaan tidak ditemukan');
        }

        // Jika semua validasi ok, lanjutkan untuk membuat surat
        $pdf = Pdf::loadView('surat.penerimaan', $data);

        $fileName = 'surat-penerimaan-' . $data['peserta'] .'-'. $data['id_peserta'] . '.pdf';
        $filePath = 'penerimaan/' . $fileName;

        $this->suratInterface->create([
            'id_peserta' => $data['id_peserta'],
            'id_cabang' => $data['id_cabang'],
            'id_perusahaan' => $data['id_perusahaan'],
            'jenis' => $jenis,
            'file_path' => $filePath
        ]);

        // Menyimpan PDF
        Storage::disk('public')->put($filePath, $pdf->output());
    }

}
