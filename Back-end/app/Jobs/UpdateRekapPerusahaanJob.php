<?php

namespace App\Jobs;

use App\Models\Perusahaan;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Services\RekapPerusahaanService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRekapPerusahaanJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RekapPerusahaanService $service): void
    {
        $perusahaanIds = Perusahaan::pluck("id");
        foreach ($perusahaanIds as $id) {
                Log::info('Dispatching UpdateRekapPerusahaanJob for Cabang ID: ' . $id);
                $service->simpanRekap($id);
        }
    }
}
