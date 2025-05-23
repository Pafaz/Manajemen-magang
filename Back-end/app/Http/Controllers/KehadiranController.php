<?php

namespace App\Http\Controllers;

use App\Services\KehadiranService;
use App\Services\RekapKehadiranService;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    private KehadiranService $kehadiranService;
    private RekapKehadiranService $rekapKehadiranService;
    public function __construct(KehadiranService $kehadiranService, RekapKehadiranService $rekapKehadiranService)
    {
        $this->kehadiranService = $kehadiranService;
        $this->rekapKehadiranService = $rekapKehadiranService;
    }
    public function store()
    {
        return $this->kehadiranService->simpanKehadiran();
    }

    public function index()
    {
        return $this->kehadiranService->getKehadiran();
    }

    public function getRekapKehadiran()
    {
        return $this->rekapKehadiranService->getRekap();
    }
}
