<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\AdminCabangController;
use App\Http\Controllers\AdminPerusahaanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\MagangController;

Route::post('/login/google', [GoogleAuthController::class, 'loginWithGoogle']);

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register-perusahaan', [RegisterController::class, 'registerPerusahaan']);
Route::post('/register-peserta', [RegisterController::class, 'registerPeserta']);

Route::group(['middleware' => ['auth:sanctum', 'role:peserta']], function () {
    Route::apiResource('peserta', PesertaController::class);
    Route::apiResource('sekolah', SekolahController::class);
    Route::apiResource('jurusan', JurusanController::class);
    Route::apiResource('magang', MagangController::class);
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);

    //foto
    Route::post('/foto/{foto}/update', [FotoController::class, 'update']);
    Route::post('/foto', [FotoController::class, 'store']);
    Route::delete('/foto/{foto}', [FotoController::class, 'destroy']);

    //auth
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/get-user',[LoginController::class,'getData']);
});
