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
        $jurnal = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'bukti' => 'required|image|mimes:jpg,png,jpeg,',
        ]);
        return $this->jurnalService->simpanJurnal($jurnal);
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
    public function update(Request $request, $id)
    {
        $jurnal = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'bukti' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        return $this->jurnalService->simpanJurnal($jurnal, true, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurnal $jurnal)
    {
        //
    }
}
