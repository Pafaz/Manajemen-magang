<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Services\LowonganService;
use App\Http\Requests\LowonganRequest;

class LowonganController extends Controller
{
    private LowonganService $lowonganService;

    public function __construct(LowonganService $lowonganService)
    {
        $this->lowonganService = $lowonganService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->lowonganService->getAllLowongan();
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
    public function store(LowonganRequest $request)
    {
        return $this->lowonganService->simpanLowongan(null, $request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->lowonganService->getLowonganById($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lowongan $lowongan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LowonganRequest $request, int $id)
    {
        return $this->lowonganService->simpanLowongan($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }

    public function tutupLowongan(int $id)
    {
        return $this->lowonganService->tutupLowongan($id);
    }
}