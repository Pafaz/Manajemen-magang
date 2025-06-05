<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use App\Services\PesertaService;
use App\Http\Requests\PesertaRequest;
use App\Services\RekapPesertaService;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private PesertaService $pesertaService;
    private RekapPesertaService $rekapPesertaService;
    public function __construct(PesertaService $pesertaService, RekapPesertaService $rekapPesertaService)
    {
        $this->pesertaService = $pesertaService;
        $this->rekapPesertaService = $rekapPesertaService;
    }

    public function index()
    {
        return $this->pesertaService->getPeserta();
    }
    public function isCompleteProfil(){
        return $this->pesertaService->checkAllStatus();
    }

    public function isMagang(){
        return $this->pesertaService->isMagang();
    }

    public function isApplyLowongan(){
        return $this->pesertaService->isApplyLowongan();
    }

    // MENTOR
    public function showByProgress(){
        return $this->pesertaService->getPesertaByProgress();
    }

    public function showDetailProgress($idPeserta){
        return $this->pesertaService->getDetailProgressByMentor($idPeserta);
    }

    public function markDoneRoute($idPeserta, Request $request){
        return $this->pesertaService->markDoneRoute($idPeserta, $request['id_kategori_proyek']);
    }
    // END MENTOR

    // perusahaan & admin
    public function getJurnalPeserta()
    {
        return $this->pesertaService->getJurnalPesertaByCabang();
    }
    public function showByCabang()
    {
        return $this->pesertaService->getPesertaByCabang();
    }
    public function showByDivisi($id)
    {
        return $this->pesertaService->getPesertaByDivisi($id);
    }
    public function getKehadiranPesertabyCabang()
    {
        return $this->pesertaService->getKehadiranPesertaByCabang();
    }
    // END PERUSAHAAN & ADMIN

    // PROFILE PESERTA
    public function store(PesertaRequest $request)
    {
        return $this->pesertaService->simpanProfilPeserta($request->validated());
    }
    public function show()
    {
        return $this->pesertaService->getPesertaDetail();
    }
    public function update(PesertaRequest $request, $id)
    {
        return $this->pesertaService->simpanProfilPeserta($request->all(), true, $id);
    }
    public function destroy($id)
    {
        return $this->pesertaService->deletePeserta($id);
    }
    // END PROFILE PESERTA

    // ROUTE PESERTA
    public function getDivisiRoute()
    {
        return $this->pesertaService->getDivisiRoute();
    }
    public function getDetailRoute($route)
    {
        return $this->pesertaService->getDetailRoute($route);
    }
    public function getRekapPeserta()
    {
        return $this->rekapPesertaService->simpanRekap();
    }
    // END ROUTE PESERTA

}
