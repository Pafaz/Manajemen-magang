<?php

namespace App\Http\Controllers;

use App\Http\Requests\MagangRequest;
use App\Models\Magang;
use App\Services\MagangService;
use Illuminate\Http\Request;

class MagangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private MagangService $magangService;
    public function __construct(MagangService $magangService)
    {
        $this->magangService = $magangService;
    }
    public function index()
    {
        return $this->magangService->getAllMagang();
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
    public function store(MagangRequest $request)
    {
        return $this->magangService->applyMagang($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Magang $magang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Magang $magang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Magang $magang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Magang $magang)
    {
        //
    }
}
