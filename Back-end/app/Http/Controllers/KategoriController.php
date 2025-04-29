<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Services\KategoriService;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private KategoriService $kategoriService;
    public function __construct(KategoriService $kategoriService)
    {
        $this->kategoriService = $kategoriService;
    }
    public function index()
    {
        return $this->kategoriService->getCategories();
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
        $data = $request->validate([
            'nama' => 'required|string',
            'card' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        return $this->kategoriService->simpanKategori($data);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        return $this->kategoriService->getCategories($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $kategori)
    {
        $data = $request->validate([
            'nama' => 'sometimes|string',
            'card' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return $this->kategoriService->simpanKategori($data, true, $kategori);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        return $this->kategoriService->deleteCategory($id);
    }
}
