<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\AbsensiService;

class GenerateAlfaHarian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-alfa-harian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate status alfa otomatis harian berdasarkan jam kantor aktif';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(AbsensiService::class)->generateAlfaPesertaHarian(Carbon::now());
        $this->info("Generate Alfa Harian executed successfully.");
    }
}
