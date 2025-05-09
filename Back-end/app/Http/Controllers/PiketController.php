<?php

namespace App\Http\Controllers;

use App\Http\Requests\PiketRequest;
use App\Models\Piket;
use App\Services\PiketService;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    private PiketService $piketService;

    public function __construct(PiketService $piketService)
    {
        $this->piketService = $piketService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->piketService->getPiket();
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
    public function store(PiketRequest $request)
    {
        return $this->piketService->simpanPiket($request->validated(), null);
    }

    /**
     * Display the specified resource.
     */
    public function show(Piket $piket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Piket $piket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PiketRequest $request, $id)
    {
        return $this->piketService->simpanPiket($request->validated(), $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->piketService->deletePiket($id);
    }
    
    /**
     * Remove a specific participant from a piket schedule
     */
    public function removePeserta($piketId, $pesertaId)
    {
        return $this->piketService->removePesertaFromPiket($piketId, $pesertaId);
    }
}
