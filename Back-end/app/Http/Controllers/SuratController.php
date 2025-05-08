<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use App\Services\SuratService;
use App\Http\Requests\SuratPeringatanRequest;

use function PHPUnit\Framework\returnSelf;

class SuratController extends Controller
{
    private SuratService $suratService;

    public function __construct(SuratService $suratService)
    {
        $this->suratService = $suratService;
    }

    public function index()
    {
        return $this->suratService->getSuratByCabang('penerimaan', );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SuratPeringatanRequest $request)
    {
        return $this->suratService->createSurat($request->validated(), 'peringatan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Surat $surat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surat $surat)
    {
        //
    }
}
