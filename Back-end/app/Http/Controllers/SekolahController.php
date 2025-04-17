<?php

namespace App\Http\Controllers;

use App\Http\Requests\SekolahRequest;
use App\Http\Requests\UpdateSekolahRequest;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Services\SekolahService;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private SekolahService $sekolahService;
    public function __construct(SekolahService $sekolahService)
    {
        $this->sekolahService = $sekolahService;
    }
    public function index()
    {
        return $this->sekolahService->getSchools();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SekolahRequest $request)
    {
        return $this->sekolahService->createSchool($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->sekolahService->getSchoolById($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSekolahRequest $request, $id)
    {
        return $this->sekolahService->updateSchool($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->sekolahService->deleteSchool($id);
    }
}
