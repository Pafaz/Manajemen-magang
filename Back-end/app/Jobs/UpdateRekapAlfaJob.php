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

class UpdateRekapAlfaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RekapKehadiranService $service): void
    {
        $today = now()->toDateString();
        $pesertas = Peserta::where('status', 'aktif')->get();

        foreach ($pesertas as $peserta) {
            $sudahAbsen = $peserta->absensi()->whereDate('tanggal', $today)->exists();

            if (! $sudahAbsen) {
                $service->updateRekapAbsensi($peserta, $today, 'alfa');
                Log::info("ALFA: Peserta {$peserta->id} tanggal $today");
            }
        }
    }
}
