<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use App\Services\CabangService;
use App\Http\Requests\CabangRequest;
use App\Services\RekapCabangService;

class CabangController extends Controller
{
    private CabangService $cabangService;
    private RekapCabangService $rekapCabangService;

    public function __construct(CabangService $cabangService, RekapCabangService $rekapCabangService)
    {
        $this->cabangService = $cabangService;
        $this->rekapCabangService = $rekapCabangService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_perusahaan = auth('sanctum')->user()->perusahaan->id;
        
        return $this->cabangService->getCabang(null, $id_perusahaan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CabangRequest $request)
    {
        return $this->cabangService->simpanCabang($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth('sanctum')->user();
        return $this->cabangService->getCabang($user->id_cabang_aktif, $user->perusahaan->id);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CabangRequest $request)
    {

        return $this->cabangService->simpanCabang($request->validated(), true, auth('sanctum')->user()->id_cabang_aktif);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $cabang)
    {
        return $this->cabangService->deleteCabang($cabang);
    }

    public function setCabangAktif(Request $request)
    {
        return $this->cabangService->setCabangAktif($request->id_cabang);
    }

public function getRekapCabang($cabangID = null)
    {
        return $this->rekapCabangService->getRekapCabang($cabangID);
    }
}