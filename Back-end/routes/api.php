<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\AdminCabangController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\UpdatePasswordController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register/{role}', [RegisterController::class, 'register']);
Route::get('/auth/{role}', [GoogleAuthController::class, 'redirectAuth']);
Route::get('/auth/callback/peserta', [GoogleAuthController::class, 'callbackPeserta']);
Route::get('/auth/callback/perusahaan', [GoogleAuthController::class, 'callbackPerusahaan']);
Route::post('/send-otp', [PasswordResetController::class, 'sendOtp']);
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp']);
Route::post('/update-password-otp', [PasswordResetController::class, 'updatePassword']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    //Peserta
    Route::group(['role:peserta'], function () {
        Route::apiResource('peserta', PesertaController::class);
        Route::apiResource('mitra', SekolahController::class);
        Route::apiResource('jurusan', JurusanController::class);
        Route::apiResource('magang', MagangController::class);
        Route::get('/peserta/detail', [PesertaController::class, 'show']);
    });

    //Perusahaan
    Route::group(['role:perusahaan'], function () {
        Route::apiResource('mitra', SekolahController::class);
        Route::apiResource('admin', AdminCabangController::class);
        Route::apiResource('divisi', DivisiController::class);
        Route::apiResource('cabang', CabangController::class);
        Route::apiResource('mentor', MentorController::class);
        Route::apiResource('cabang', CabangController::class);
        Route::apiResource('lowongan', LowonganController::class);
        Route::patch('/lowongan/{id}/tutup', [LowonganController::class, 'tutupLowongan']);
        Route::post('/set-cabang-aktif', [CabangController::class, 'setCabangAktif']);
        //perusahaan
        Route::post('/perusahaan', [PerusahaanController::class, 'store']);
        Route::get('/perusahaan/detail', [PerusahaanController::class, 'show']);
        Route::put('/perusahaan/update', [PerusahaanController::class, 'update']);
        Route::get('/perusahaan/edit', [PerusahaanController::class, 'edit']);
    });

    //Admin
    Route::group(['role:admin'], function () {
        Route::apiResource('piket', PiketController::class);
        Route::apiResource('kategori-proyek', KategoriController::class);
    });

    //Mentor
    Route::group(['role:mentor'], function () {});

    //Superadmin
    Route::group(['role:superadmin'], function () {});

    //foto
    Route::post('/foto/{foto}/update', [FotoController::class, 'update']);
    Route::post('/foto', [FotoController::class, 'store']);
    Route::delete('/foto/{foto}', [FotoController::class, 'destroy']);

    //auth
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);
    Route::get('/get-user', [LoginController::class, 'getData']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/get-user', [LoginController::class, 'getData']);
});