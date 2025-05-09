<?php

namespace App\Http\Controllers;

use App\Http\Requests\IzinRequest;
use App\Models\Izin;
use App\Services\IzinService;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private IzinService $izinService;

    public function __construct(IzinService $izinService)
    {
        $this->izinService = $izinService;
    }

    public function index()
    {
        return $this->izinService->getIzin();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    public function approveMany(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'status_izin' => 'required|string|in:diterima,ditolak',
        ]);

        return $this->izinService->approveManyIzin($validated['ids'], $validated['status_izin']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IzinRequest $request)
    {
        return $this->izinService->simpanIzinPeserta($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($izin)
    {
        return $this->izinService->getIzin($izin);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Izin $izin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IzinRequest $request, $izin)
    {
        return $this->izinService->approveIzin($request->validated(), $izin);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Izin $izin)
    {
        //
    }
}
