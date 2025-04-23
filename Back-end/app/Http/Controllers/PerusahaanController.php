<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerusahaanRequest;
use App\Models\Perusahaan;
use App\Services\PerusahaanService;

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
        return$this->perusahaanService->getAllPerusahaan();
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
        return $this->perusahaanService->createPerusahaan($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        return $this->perusahaanService->getPerusahaan($id);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PerusahaanRequest $request,  $id)
    {
        return $this->perusahaanService->updatePerusahaan($request->validated(), $id);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        return $this->perusahaanService->deletePerusahaan($id);
    }

}
