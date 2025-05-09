<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Services\FotoService;
use Illuminate\Http\Request;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private FotoService $fotoService;
    public function __construct(FotoService $fotoService)
    {
        $this->fotoService = $fotoService;
    }
    public function index()
    {
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
        return $this->fotoService->createFoto($request['file'], $request['id_referensi'], $request['type']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Foto $foto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Foto $foto)
    {

        return $this->fotoService->updateFoto($foto->id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Foto $foto)
    {
        return $this->fotoService->deleteFoto($foto->id);
    }
}
