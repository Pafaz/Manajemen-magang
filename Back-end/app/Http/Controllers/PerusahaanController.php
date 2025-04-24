<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\Perusahaan;
use App\Services\PerusahaanService;
use App\Http\Requests\PerusahaanRequest;
use App\Http\Resources\PerusahaanResource;
use Symfony\Component\HttpFoundation\Response;

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
    $perusahaan = $this->perusahaanService->simpanProfil($request->validated(), false);

    return Api::response(new PerusahaanResource($perusahaan), 'Profil perusahaan berhasil dilengkapi', Response::HTTP_CREATED);
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
    public function edit(Perusahaan $perusahaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PerusahaanRequest $request)
    {
        $perusahaan = $this->perusahaanService->simpanProfil($request->validated(), true);
    
        return Api::response(new PerusahaanResource($perusahaan), 'Profil perusahaan berhasil diperbarui', Response::HTTP_OK);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        return $this->perusahaanService->deletePerusahaan($id);
    }

}
