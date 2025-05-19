<?php

namespace App\Http\Controllers;

use App\Models\Revisi;
use App\Services\RevisiService;
use Illuminate\Http\Request;

class RevisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private RevisiService $revisiService;
    public function __construct(RevisiService $revisiService)
    {
        $this->revisiService = $revisiService;
    }
    public function index()
    {
        //
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
    public function store(Request $request, $route)
    {
        return $this->revisiService->simpanRevisi($request->all(), $route);
    }

    /**
     * Display the specified resource.
     */
    public function show($revisi)
    {
        return $this->revisiService->getRevisi($revisi);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revisi $revisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $revisi)
    {
        return $this->revisiService->updateRevisi($revisi, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revisi $revisi)
    {
        //
    }
}
