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

class UpdateRekapAlfaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RekapKehadiranService $service): void
    {
        $today = now()->toDateString();
        
        $pesertas = Peserta::whereHas('magang', function ($query) {
            $query->where('status', 'diterima');
        })->get();

        foreach ($pesertas as $peserta) {
            try {
                $sudahAbsen = $peserta->absensi()->whereDate('tanggal', $today)->exists();

                if (! $sudahAbsen) {
                    $service->updateRekapAbsensi($peserta->id, $today, 'alfa');
                    Log::info("ALFA: {$peserta->user->nama} tanggal $today");
                }
            } catch (\Exception $e) {
                Log::error("Gagal memperbarui rekap absensi untuk Peserta {$peserta->id} tanggal $today", [
                    'error' => $e->getMessage(),
                    'stack_trace' => $e->getTraceAsString(),
                    'peserta_id' => $peserta->id,
                    'tanggal' => $today,
                ]);
            }
        }
    }
}
