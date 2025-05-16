<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Services\AbsensiService;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private AbsensiService $absensiService;
    public function __construct(AbsensiService $absensiService){
        $this->absensiService = $absensiService;
    }
    public function index()
    {
        return $this->absensiService->getAbsensi();
    }
}
