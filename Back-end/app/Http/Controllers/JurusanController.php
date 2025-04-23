<?php

namespace App\Http\Controllers;

use App\Http\Requests\JurusanRequest;
use App\Models\Jurusan;
use App\Services\JurusanService;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private JurusanService $jurusanService;
    public function __construct(JurusanService $jurusanService)
    {
        $this->jurusanService = $jurusanService;
    }
    public function index()
    {
        return $this->jurusanService->getMajors();
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
    public function store(JurusanRequest $request)
    {
        return $this->jurusanService->createMajor($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        return $this->jurusanService->getMajorById($jurusan->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        return $this->jurusanService->updateMajor($jurusan->id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        return $this->jurusanService->deleteMajor($jurusan->id);
    }
}
