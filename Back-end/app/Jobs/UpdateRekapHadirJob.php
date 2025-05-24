<?php
namespace App\Jobs;

use App\Models\Peserta;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Services\RekapKehadiranService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRekapHadirJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RekapKehadiranService $service): void
    {
        $today = now()->toDateString();
        $pesertas = Peserta::where('status', 'aktif')->get();

        foreach ($pesertas as $peserta) {
            $absensi = $peserta->absensi()->whereDate('tanggal', $today)->first();

            if ($absensi) {
                $terlambat = $absensi->jam_masuk > '08:15';
                $service->updateRekapHarian($peserta, $today, $terlambat);
                Log::info("HADIR: Peserta {$peserta->id} tanggal $today (Terlambat: ".($terlambat ? 'YA' : 'TIDAK').")");
            }
        }
    }
}
