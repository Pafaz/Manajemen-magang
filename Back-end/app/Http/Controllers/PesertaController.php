<?php

namespace App\Http\Controllers;

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
        return $this->pesertaService->getAllPeserta();
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
    public function store(Request $request)
    {
        // dd($request->all());
        return $this->pesertaService->createPeserta($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Peserta $peserta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peserta $peserta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peserta $peserta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peserta $peserta)
    {
        //
    }
}
