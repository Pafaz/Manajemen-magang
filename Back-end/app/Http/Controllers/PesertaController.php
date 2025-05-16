<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesertaRequest;
use App\Models\Peserta;
use App\Services\PesertaService;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private PesertaService $pesertaService;
    public function __construct(PesertaService $pesertaService)
    {
        $this->pesertaService = $pesertaService;
    }

    public function index()
    {
        return $this->pesertaService->getPeserta();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(PesertaRequest $request)
    {
        return $this->pesertaService->simpanProfilPeserta($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return $this->pesertaService->getPeserta();
    }

    public function isCompleteProfil(){
        return $this->pesertaService->isCompleteProfil();
    }

    public function isMagang(){
        return $this->pesertaService->isMagang();
    }

    public function isApplyLowongan(){
        return $this->pesertaService->isApplyLowongan();
    }

    public function getJurnalPeserta()
    {
        return $this->pesertaService->getJurnalPesertaByCabang();
    }

    public function showByCabang()
    {
        return $this->pesertaService->getPesertaByCabang();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getKehadiranPesertabyCabang()
    {
        return $this->pesertaService->getKehadiranPesertaByCabang();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PesertaRequest $request, $id)
    {
        return $this->pesertaService->simpanProfilPeserta($request->all(), true, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->pesertaService->deletePeserta($id);
    }
}
