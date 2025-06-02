<?php

namespace App\Http\Controllers;

use App\Services\PerusahaanService;
use App\Http\Requests\PerusahaanRequest;
use App\Services\RekapPerusahaanService;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private PerusahaanService $perusahaanService;
    private RekapPerusahaanService $rekapPerusahaanService;
    public function __construct(PerusahaanService $perusahaanService, RekapPerusahaanService $rekapPerusahaanService)
    {
        $this->perusahaanService = $perusahaanService;
        $this->rekapPerusahaanService = $rekapPerusahaanService;
    }
    public function index()
    {
        return $this->perusahaanService->getPerusahaan();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerusahaanRequest $request)
    {
        return $this->perusahaanService->simpanProfil($request->validated(), false);
    }

    /**
     * Display the specified resource.
     */

    public function show()
    {
        return $this->perusahaanService->isCompleteProfil();
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return $this->perusahaanService->getPerusahaanByAuth();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PerusahaanRequest $request)
    {
        return $this->perusahaanService->simpanProfil($request->validated(), true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->perusahaanService->deletePerusahaan($id);
    }

    public function getRekap()
    {
        // $id = auth()->user()->perusahaan->id;
        return $this->rekapPerusahaanService->getRekap();
    }

    public function getRekapAbsensi($id_cabang)
    {
        return $this->rekapPerusahaanService->getRekapAbsensi($id_cabang);
    }

    public function getRekapPeserta($id_cabang)
    {
        return $this->rekapPerusahaanService->getPesertaCabang($id_cabang);
    }

    public function getRekapJurnal($id_cabang)
    {
        return $this->rekapPerusahaanService->getJurnalCabang($id_cabang);
    }

    public function getRekapPendaftar($id_cabang)
    {
        return $this->rekapPerusahaanService->getRekapPendaftar($id_cabang);
    }

    public function getMitra()
    {
        return $this->perusahaanService->getMitra();
    }

    public function showMitra($id)
    {
        return $this->perusahaanService->showMitra($id);
    }
}
