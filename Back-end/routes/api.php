<?php

use App\Http\Controllers\JurusanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('peserta', PesertaController::class);
Route::apiResource('sekolah', SekolahController::class);
Route::apiResource('jurusan', JurusanController::class);
