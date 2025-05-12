<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use App\Services\CabangService;
use App\Http\Requests\CabangRequest;

class CabangController extends Controller
{
    private CabangService $cabangService;

    public function __construct(CabangService $cabangService)
    {
        $this->cabangService = $cabangService;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(CabangRequest $request)
    {
        // $id_perusahaan = $this->cabangService->getCabangByPerusahaanId($request->id_perusahaan);
        // return $this->cabangService->updateCabang($request->validated(), $id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CabangRequest $request,  $cabang)
    {
        return $this->cabangService->simpanCabang($request->validated(), true, $cabang);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabang $cabang)
    {
        return $this->cabangService->deleteCabang($cabang->id);
    }

    public function setCabangAktif(Request $request)
    {
        return $this->cabangService->setCabangAktif($request->id_cabang);
    }
}