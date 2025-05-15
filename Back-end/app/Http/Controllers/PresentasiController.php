<?php

namespace App\Http\Controllers;

use App\Models\Presentasi;
use Illuminate\Http\Request;
use App\Services\PresentasiService;

class PresentasiController extends Controller
{
    private PresentasiService $presentasiService;

    public function __construct(PresentasiService $presentasiService)
    {
        $this->presentasiService = $presentasiService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->presentasiService->getRiwayatPresentasi();
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
    public function store(Request $request)
    {
        $presentasi = $request->validate([
            "id_jadwal_presentasi"=> "required|numeric",
            "projek"=> "required|string|exists:kategori_proyek,nama",
        ]);

        return $this->presentasiService->applyPresentasi($presentasi);
    }

    /**
     * Display the specified resource.
     */
    public function show(Presentasi $presentasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presentasi $presentasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presentasi $presentasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Presentasi $presentasi)
    {
        //
    }
}
