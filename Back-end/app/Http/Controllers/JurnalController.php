<?php

namespace App\Http\Controllers;

use App\Models\Jurnal;
use App\Services\JurnalService;
use Illuminate\Http\Request;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private JurnalService $jurnalService;
    public function __construct(JurnalService $jurnalService){
        $this->jurnalService = $jurnalService;
    }

    public function index()
    {
        return $this->jurnalService->getJurnal();
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
        return $this->jurnalService->simpanJurnal($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show( $jurnal)
    {
        return $this->jurnalService->getJurnal($jurnal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurnal $jurnal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $jurnal)
    {
        return $this->jurnalService->simpanJurnal($request->all(), true, $jurnal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        //
    }
}
