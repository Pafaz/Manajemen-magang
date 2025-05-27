<?php
namespace App\Jobs;

use App\Models\Peserta;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Services\RekapKehadiranService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRekapHadirJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RekapKehadiranService $service): void
    {
        $today = now()->toDateString();

        $pesertas = Peserta::whereHas('magang', function ($query) {
            $query->where('status', 'diterima');
        })
        ->get();

        foreach ($pesertas as $peserta) {
            try {
                $absensi = $peserta->absensi()->whereDate('tanggal', $today)->first();

                if ($absensi) {
                    $terlambat = $absensi->jam_masuk_akhir;
                    
                    $service->updateRekapHarian($peserta->id, $today, $terlambat);

                    Log::info("HADIR: {$peserta->user->nama} tanggal $today (Terlambat: " . ($terlambat ? 'YA' : 'TIDAK') . ")");
                } else {
                    Log::info("HADIR: {$peserta->user->nama} tanggal $today tidak memiliki absensi.");
                }
            } catch (\Exception $e) {
                Log::error("Gagal memperbarui rekap kehadiran untuk Peserta {$peserta->nama} tanggal $today", [
                    'error' => $e->getMessage(),
                    'stack_trace' => $e->getTraceAsString(),
                    'peserta_id' => $peserta->id,
                    'tanggal' => $today,
                ]);
            }
        }
    }
}
