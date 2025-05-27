<?php

namespace App\Jobs;

use App\Models\Cabang;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Services\RekapCabangService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateRekapCabangJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(RekapCabangService $service): void
    {
        $cabangIds = Cabang::pluck("id");
        foreach ($cabangIds as $id) {
                Log::info('Dispatching UpdateRekapCabangJob for Cabang ID: ' . $id);
                $service->simpanRekap($id);
        }
    }
}
