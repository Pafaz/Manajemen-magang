<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register-perusahaan', [AuthController::class, 'register_perusahaan']);
Route::post('/register-peserta', [AuthController::class, 'register_peserta']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::apiResource('peserta', PesertaController::class);
Route::apiResource('sekolah', SekolahController::class);
Route::apiResource('jurusan', JurusanController::class);
Route::apiResource('kategori', KategoriController::class);
Route::apiResource('foto', FotoController::class);
Route::post('/foto/{foto}/update', [FotoController::class, 'update']);


