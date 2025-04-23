<?php

namespace App\Http\Controllers;

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
        return $this->divisiService->getAllDivisi();
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
        return $this->divisiService->createDivisi($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Divisi $divisi)
    {
        return $this->divisiService->getDivisiById($divisi->id);
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
    public function update(Request $request, Divisi $divisi)
    {
        return $this->divisiService->updateDivisi($divisi->id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Divisi $divisi)
    {
        return $this->divisiService->deleteDivisi($divisi->id);
    }
}
