<?php

namespace App\Jobs;

use App\Services\RekapCabangService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateRekapCabangJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $idCabang;

    public function __construct(int $idCabang)
    {
        $this->idCabang = $idCabang;
    }

    public function handle(RekapCabangService $service): void
    {
        $service->simpanRekap($this->idCabang);
    }

}
