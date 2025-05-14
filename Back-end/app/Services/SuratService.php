<?php

namespace App\Services;

use App\Helpers\Api;
use Illuminate\Support\Carbon;
use App\Interfaces\SuratInterface;
use Illuminate\Support\Facades\DB;
// use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Log;
use App\Interfaces\PesertaInterface;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SuratService
{
    private SuratInterface $suratInterface;
    private PesertaInterface $pesertaInterface;
    private const SURAT_PENERIMAAN = 'penerimaan';
    private const SURAT_PERINGATAN = 'peringatan';

    public function __construct(SuratInterface $suratInterface, PesertaInterface $pesertaInterface)
    {
        $this->suratInterface = $suratInterface;
        $this->pesertaInterface = $pesertaInterface;
    }
    

    public function getSuratByCabang(?string $jenis = null, bool $withPeserta = true)
    {
        $idCabang = auth('sanctum')->user()->id_cabang_aktif;

        // dd($idCabang);

        try {
            $surat = $this->suratInterface->getAllByCabang($idCabang, $jenis, $withPeserta);
            
            return Api::response(
                $surat,
                'Daftar surat berhasil diambil'
            );
        } catch (\Exception $e) {
            Log::error('Error retrieving surat: ' . $e->getMessage());
            
            return Api::response(
                null,
                'Terjadi kesalahan dalam pengambilan data surat: ' . $e->getMessage(),
                500
            );
        }
    }

    public function getSuratByPeserta(int $idPeserta, ?string $jenis = null)
    {
        try {
            $surat = $this->suratInterface->getAllByPeserta($idPeserta, $jenis);
            
            $surat->each(function ($item) {
                $item->download_url = asset('storage/' . $item->file_path);
            });
            
            return Api::response(
                $surat,
                'Daftar surat peserta berhasil diambil'
            );
        } catch (\Exception $e) {
            Log::error('Error retrieving surat for peserta: ' . $e->getMessage());
            
            return Api::response(
                null,
                'Terjadi kesalahan dalam pengambilan data surat peserta: ' . $e->getMessage(),
                500
            );
        }
    }
    
    public function getSuratStatsByCabang(int $idCabang)
    {
        try {
            $stats = $this->suratInterface->getStatsByCabang($idCabang);
            
            return Api::response(
                $stats,
                'Statistik surat berhasil diambil'
            );
        } catch (\Exception $e) {
            Log::error('Error retrieving surat statistics: ' . $e->getMessage());
            
            return Api::response(
                null,
                'Terjadi kesalahan dalam pengambilan statistik surat: ' . $e->getMessage(),
                500
            );
        }
    }

    public function createSurat(array $data, string $jenis)
    {
        DB::beginTransaction();

        try {
            $isPenerimaan = $jenis === self::SURAT_PENERIMAAN;
            $filePath = $this->generateSurat($data, $jenis);

            // dd($filePath, $data, $jenis, $isPenerimaan);

            $this->suratInterface->create([
                'id_peserta' => $data['id_peserta'],
                'id_cabang' => $isPenerimaan ? $data['id_cabang'] : auth('sanctum')->user()->id_cabang_aktif,
                'keterangan_surat'=> $isPenerimaan ? null : $data['keterangan_surat'],
                'alasan'=> $isPenerimaan ? null : $data['alasan'],
                'jenis' => $jenis,
                'file_path' => $filePath
            ]);

            // dd($cok);
            
            DB::commit();
            
            $message = $isPenerimaan 
                ? 'Surat Penerimaan berhasil dibuat' 
                : 'Surat Peringatan berhasil dibuat';
                
            return Api::response(null, $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating surat: ' . $e->getMessage());
            return Api::response(
                null,
                'Terjadi kesalahan dalam pembuatan surat. Silakan coba lagi: ' . $e->getMessage()
            );
        }
    }

    private function generateSurat(array $data, string $jenis): string
    {
        if ($jenis === self::SURAT_PENERIMAAN) {
            return $this->generateSuratPenerimaan($data);
        } else {
            return $this->generateSuratPeringatan($data);
        }
    }

    private function generateSuratPenerimaan(array $data): string
    {
        $fileName = "surat-penerimaan-{$data['peserta']}-{$data['id_peserta']}.pdf";
        $filePath = self::SURAT_PENERIMAAN . '/' . $fileName;

        // $pdf = Pdf::loadView('surat.penerimaan', $data);

        Pdf::view('surat.penerimaan', $data)
            ->disk('public')
            ->save($filePath);

        // Storage::disk('public')->put($filePath, $pdf->output());
        
        return $filePath;
    }

    private function generateSuratPeringatan(array $data): string
    {
        $perusahaan = auth('sanctum')->user();
        $peserta = $this->pesertaInterface->find($data['id_peserta']);
        
        $dataSurat = [
            'nama' => $peserta->user->nama,
            'perusahaan' => $perusahaan->nama,
            'alamat_perusahaan' => $perusahaan->perusahaan->alamat,
            'no_telepon' => $perusahaan->telepon,
            'keterangan_surat' => $data['keterangan_surat'],
            'alasan' => $data['alasan'],
            'email' => $perusahaan->email,
            'website' => $perusahaan->perusahaan->website,
            'nomor_surat' => '1313',
            'sekolah' => $peserta->sekolah,
            'nama_penanggung_jawab' => $perusahaan->perusahaan->nama_penanggung_jawab,
            'jabatan_penanggung_jawab' => $perusahaan->perusahaan->jabatan_penanggung_jawab,
            'bulan' => Carbon::now()->locale('id')->isoFormat('MMMM'),
            'tahun' => Carbon::now()->locale('id')->isoFormat('YYYY'),
            'tanggal' => Carbon::now()->locale('id')->isoFormat('D MMMM YYYY')
        ];
        
        $fileName = "surat-peringatan-{$data['id_peserta']}-{$data['keterangan_surat']}.pdf";
        $filePath = self::SURAT_PERINGATAN . '/' . $fileName;

        // $pdf = Pdf::loadView('surat.peringatan', $dataSurat);

        Pdf::view('surat.peringatan', $dataSurat)
            ->disk('public')
            ->save($filePath);

        // Storage::disk('public')->put($filePath, $pdf->output());
        
        return $filePath;
    }

    public function editSuratPeringatan(int $idSurat, array $data)
    {
        DB::beginTransaction();

        try {
            $surat = $this->suratInterface->find($idSurat);

            
            if (!$surat) {
                return Api::response(
                    null,
                    'Surat tidak ditemukan',
                    Response::HTTP_NOT_FOUND
                );
            }

            if (Storage::disk('public')->exists($surat->file_path)) {
                Storage::disk('public')->delete($surat->file_path);
            }

            $filePath = $this->generateSuratPeringatan($data);

            $surat->update([
                'keterangan_surat' => $data['keterangan_surat'],
                'alasan' => $data['alasan'],
                'file_path' => $filePath,
            ]);

            DB::commit();

            return Api::response(
                null,
                'Surat Peringatan berhasil diperbarui',
                Response::HTTP_OK
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating surat: ' . $e->getMessage());
            return Api::response(
                null,
                'Terjadi kesalahan dalam pengeditan surat: ' . $e->getMessage(),
                500
            );
        }
    }

}