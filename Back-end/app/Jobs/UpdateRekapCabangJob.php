<?php
namespace App\Jobs;

use Illuminate\Queue\Jobs\Job;
use App\Services\RekapCabangService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UpdateRekapCabangJob implements ShouldQueue
{
    protected $id_cabang;

    public function __construct($id_cabang)
    {
        $this->id_cabang = $id_cabang;
    }

    public function handle(RekapCabangService $rekapCabangService)
    {
        $rekapCabangService->simpanRekap($this->id_cabang);
    }
}
