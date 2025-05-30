<?php

namespace App\Http\Controllers;

use App\Models\Admin_cabang;
use App\Services\AdminService;
use App\Http\Requests\AdminRequest;

class AdminCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        return $this->adminService->getAllAdmin();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        return $this->adminService->simpanAdmin(null, $request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->adminService->findAdmin($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin_cabang $admin_cabang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, string $id)
    {
        return $this->adminService->simpanAdmin($id, data: $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->adminService->deleteAdmin($id);
    }
}
