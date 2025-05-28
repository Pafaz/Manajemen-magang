<?php

namespace App\Jobs;

use App\Models\Perusahaan;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Services\RekapCabangService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRekapPerusahaanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RekapCabangService $service): void
    {
        $perusahaanIds = Perusahaan::pluck("id");
        foreach ($perusahaanIds as $id) {
                Log::info('Dispatching UpdateRekapPerusahaanJob for Cabang ID: ' . $id);
                $service->simpanRekap($id);
        }
    }
}
