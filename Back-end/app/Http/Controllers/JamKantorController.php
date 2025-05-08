<?php

namespace App\Http\Controllers;

use App\Http\Requests\JamKantorRequest;
use App\Models\Jam_Kantor;
use App\Services\JamKantorService;
use Illuminate\Http\Request;

class JamKantorController extends Controller
{
    private JamKantorService $jamKantorService;

    public function __construct(JamKantorService $jamKantorService)
    {
        $this->jamKantorService = $jamKantorService;
    }

    public function index()
    {
        return $this->jamKantorService->getJamKantor();
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
    public function store(JamKantorRequest $request)
    {
        return $this->jamKantorService->simpanJamKantor($request->validated(), null);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jam_Kantor $jam_Kantor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jam_Kantor $jam_Kantor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JamKantorRequest $request, $hari)
    {
        return $this->jamKantorService->simpanJamKantor($request->validated(), $hari);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jam_Kantor $jam_Kantor)
    {
        //
    }

    public function unactivatedJamKantor($id)
    {
        return $this->jamKantorService->updateStatusJamKantor($id, false);
    }

    public function activatedJamKantor($id)
    {
        return $this->jamKantorService->updateStatusJamKantor($id, true);
    }
}
