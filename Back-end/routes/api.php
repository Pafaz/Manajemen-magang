<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KategoriController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('peserta', PesertaController::class);
Route::apiResource('sekolah', SekolahController::class);
Route::apiResource('jurusan', JurusanController::class);
Route::apiResource('kategori', KategoriController::class);
