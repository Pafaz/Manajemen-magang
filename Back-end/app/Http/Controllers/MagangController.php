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
        return $this->magangService->getAllPesertaMagang();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function setMentor($idMentor, Request $request)
    {
        $data = $request->validate([
            'pesertas' => 'required|array',
        ]);
        return $this->magangService->setMentor($idMentor, $data['pesertas']);
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
    public function show($magang)
    {
        return $this->magangService->getMagangbyId($magang);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function approveMany(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'status' => 'required|string|in:diterima,ditolak',
            'no_surat' => 'required|string'
        ]);
    
        return $this->magangService->approveMany($validated['ids'], $validated['status'], $validated['no_surat']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $magang)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:diterima,ditolak',
            'no_surat' => 'required|string'
        ]);

        return $this->magangService->approvalMagang($magang, $validated);
    }

    public function editDivisi(Request $request, string $id)
    {
        $validated = $request->validate([
            'id_divisi' => 'required|exists:divisi,id',
            'id_mentor' => 'required|exists:mentor,id',
        ]);
        return $this->magangService->editDivisi($id, $validated);
    }

    public function destroy(Magang $magang)
    {
        //
    }
}
