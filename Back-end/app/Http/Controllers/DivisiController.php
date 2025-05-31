<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisiRequest;
use App\Models\Divisi;
use App\Services\DivisiService;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private DivisiService $divisiService;
    public function __construct(DivisiService $divisiService)
    {
        $this->divisiService = $divisiService;
    }

    public function index()
    {
        return $this->divisiService->getDivisi();
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
    public function store(DivisiRequest $DivisiRequest)
    {
        return $this->divisiService->simpanDivisi($DivisiRequest->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($divisi)
    {
        return $this->divisiService->getDivisi($divisi);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Divisi $divisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DivisiRequest $request, $divisi)
    {
        return $this->divisiService->simpanDivisi( $request->all(), true, $divisi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($divisi)
    {
        return $this->divisiService->deleteDivisi($divisi);
    }

    public function getByCabang($id)
    {
        return $this->divisiService->getByCabang($id);
    }
}
