<?php

namespace App\Http\Controllers;

use App\Services\PerusahaanService;
use App\Http\Requests\PerusahaanRequest;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private PerusahaanService $perusahaanService;
    public function __construct(PerusahaanService $perusahaanService)
    {
        $this->perusahaanService = $perusahaanService;
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
}
