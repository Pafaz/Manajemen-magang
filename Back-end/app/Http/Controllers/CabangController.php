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
        return $this->cabangService->getAllCabang();
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
        return $this->cabangService->createCabang($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabang $cabang)
    {
        //
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
    public function update(Request $request, Cabang $cabang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabang $cabang)
    {
        //
    }
}
