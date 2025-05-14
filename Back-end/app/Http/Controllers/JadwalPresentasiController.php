<?php

namespace App\Http\Controllers;

use App\Http\Requests\JadwalPresentasiRequest;
use Illuminate\Http\Request;
use App\Services\PresentasiService;

class JadwalPresentasiController extends Controller
{
    private PresentasiService $presentasiService;

    public function __construct(PresentasiService $presentasiService)
    {
        $this->presentasiService = $presentasiService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->presentasiService->getJadwalPresentasi();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return $this->presentasiService->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JadwalPresentasiRequest $request)
    {
        // dd($request->all());
        return $this->presentasiService->createJadwalPresentasi($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->presentasiService->getDetailJadwalPresentasi( $id );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($jadwal_Presentasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$jadwal_Presentasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($jadwal_Presentasi)
    {
        //
    }
}
