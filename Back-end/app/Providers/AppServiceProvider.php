<?php

namespace App\Providers;

use App\Helpers\Api;
use App\Interfaces\FotoInterface;
use App\Interfaces\IzinInterface;
use App\Interfaces\RekapPerusahaanInterface;
use App\Interfaces\RfidInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\AdminInterface;
use App\Interfaces\PiketInterface;
use App\Interfaces\RouteInterface;
use App\Interfaces\SuratInterface;
use App\Interfaces\CabangInterface;
use App\Interfaces\DivisiInterface;
use App\Interfaces\JurnalInterface;
use App\Interfaces\MagangInterface;
use App\Interfaces\MentorInterface;
use App\Interfaces\ProyekInterface;
use App\Interfaces\RevisiInterface;
use App\Interfaces\AbsensiInterface;
use App\Interfaces\JurusanInterface;
use App\Interfaces\PesertaInterface;
use App\Interfaces\SekolahInterface;
use App\Repositories\FotoRepository;
use App\Repositories\IzinRepository;
use App\Repositories\RekapPerusahaanRepository;
use App\Repositories\RfidRepository;
use App\Repositories\UserRepository;
use App\Interfaces\KategoriInterface;
use App\Interfaces\LowonganInterface;
use App\Interfaces\ProgressInterface;
use App\Repositories\AdminRepository;
use App\Repositories\PiketRepository;
use App\Repositories\RouteRepository;
use App\Repositories\SuratRepository;
use Illuminate\Support\Facades\Event;
use App\Interfaces\JamKantorInterface;
use App\Interfaces\KehadiranInterface;
use App\Repositories\CabangRepository;
use App\Repositories\DivisiRepository;
use App\Repositories\JurnalRepository;
use App\Repositories\MagangRepository;
use App\Repositories\MentorRepository;
use App\Repositories\ProyekRepository;
use App\Repositories\RevisiRepository;
use App\Interfaces\NotifikasiInterface;
use App\Interfaces\PerusahaanInterface;
use App\Interfaces\PresentasiInterface;
use App\Repositories\AbsensiRepository;
use App\Repositories\JurusanRepository;
use App\Repositories\PesertaRepository;
use App\Repositories\SekolahRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\RekapCabangInterface;
use App\Repositories\KategoriRepository;
use App\Repositories\LowonganRepository;
use App\Repositories\ProgressRepository;
use App\Repositories\JamKantorRepository;
use App\Repositories\KehadiranRepository;
use App\Repositories\NotifikasiRepository;
use App\Repositories\PerusahaanRepository;
use App\Repositories\PresentasiRepository;
use App\Interfaces\RekapKehadiranInterface;
use App\Repositories\RekapCabangRepository;
use App\Interfaces\JadwalPresentasiInterface;
use App\Repositories\RekapKehadiranRepository;
use App\Repositories\JadwalPresentasiRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AbsensiInterface::class, AbsensiRepository::class);
        $this->app->bind(CabangInterface::class, CabangRepository::class);
        $this->app->bind(DivisiInterface::class, DivisiRepository::class);
        $this->app->bind(FotoInterface::class, FotoRepository::class);
        $this->app->bind(IzinInterface::class, IzinRepository::class);
        $this->app->bind(JadwalPresentasiInterface::class, JadwalPresentasiRepository::class);
        $this->app->bind(JamKantorInterface::class, JamKantorRepository::class);
        $this->app->bind(JurusanInterface::class, JurusanRepository::class);
        $this->app->bind(KategoriInterface::class, KategoriRepository::class);
        $this->app->bind(LowonganInterface::class, LowonganRepository::class);
        $this->app->bind(MagangInterface::class, MagangRepository::class);
        $this->app->bind(MentorInterface::class, MentorRepository::class);
        $this->app->bind(NotifikasiInterface::class, NotifikasiRepository::class);
        $this->app->bind(PerusahaanInterface::class, PerusahaanRepository::class);
        $this->app->bind(PesertaInterface::class, PesertaRepository::class);
        $this->app->bind(PiketInterface::class, PiketRepository::class);
        $this->app->bind(PresentasiInterface::class, PresentasiRepository::class);
        $this->app->bind(ProgressInterface::class, ProgressRepository::class);
        $this->app->bind(ProyekInterface::class, ProyekRepository::class);
        $this->app->bind(RevisiInterface::class, RevisiRepository::class);
        $this->app->bind(RfidInterface::class, RfidRepository::class);
        $this->app->bind(SekolahInterface::class, SekolahRepository::class);
        $this->app->bind(SuratInterface::class, SuratRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
        $this->app->bind(JurnalInterface::class, JurnalRepository::class);
        $this->app->bind(KehadiranInterface::class, KehadiranRepository::class);
        $this->app->bind(RekapKehadiranInterface::class, RekapKehadiranRepository::class);
        $this->app->bind(RouteInterface::class, RouteRepository::class);
        $this->app->bind(RekapCabangInterface::class, RekapCabangRepository::class);
        $this->app->bind(RekapPerusahaanInterface::class, RekapPerusahaanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('google', \SocialiteProviders\Google\Provider::class);
        });
    }
}
