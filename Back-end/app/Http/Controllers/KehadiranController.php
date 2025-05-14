<?php

namespace App\Http\Controllers;

use App\Services\KehadiranService;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    private KehadiranService $kehadiranService;
    public function __construct(KehadiranService $kehadiranService)
    {
        $this->kehadiranService = $kehadiranService;
    }
    public function store()
    {
        return $this->kehadiranService->simpanKehadiran();
    }

    public function index()
    {
        return $this->kehadiranService->getKehadiran();
    }
}
