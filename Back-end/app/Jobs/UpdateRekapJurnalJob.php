<?php
namespace App\Jobs;

use App\Models\Peserta;
use App\Services\JurnalService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRekapJurnalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(JurnalService $service): void
    {
        $today = now()->toDateString();

        $pesertas = Peserta::whereHas('magang', function ($query) {
                $query->where('status', 'diterima');
            })
            ->get();

        foreach ($pesertas as $peserta) {
            try {
                $jurnal = $peserta->jurnal()->whereDate('tanggal', $today)->exists();

                if (!$jurnal) {
                    $service->createJunalKosong($peserta);
                    Log::info("JURNAL: Peserta {$peserta->id} tanggal {$today} tidak mengisi jurnal");
                }
            } catch (\Exception $e) {
                Log::error("Gagal memperbarui jurnal untuk Peserta {$peserta->id} tanggal $today", [
                    'error' => $e->getMessage(),
                    'stack_trace' => $e->getTraceAsString(),
                    'peserta_id' => $peserta->id,
                    'tanggal' => $today,
                ]);
            }
        }
    }
}
