<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\JamKantorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PresentasiController;
use App\Http\Controllers\AdminCabangController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\UpdatePasswordController;
use App\Http\Controllers\JadwalPresentasiController;
use App\Http\Controllers\KehadiranController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register/{role}', [RegisterController::class, 'register']);
Route::get('/auth/{role}', [GoogleAuthController::class, 'redirectAuth']);
Route::get('/auth/callback/peserta', [GoogleAuthController::class, 'callbackPeserta']);
Route::get('/auth/callback/perusahaan', [GoogleAuthController::class, 'callbackPerusahaan']);
Route::post('/send-otp', [PasswordResetController::class, 'sendOtp']);
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp']);
Route::post('/update-password-otp', [PasswordResetController::class, 'updatePassword']);
Route::get('/lowongan-all', [LowonganController::class,'getAllLowongan']);
Route::get('/lowongan/{id}/detail', [LowonganController::class,'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('divisi', DivisiController::class);

    //Peserta
    Route::group(['middleware' => 'role:peserta'], function () {
        Route::apiResource('peserta', PesertaController::class);
        Route::apiResource('jurnal',JurnalController::class);
        Route::apiResource('jurusan', JurusanController::class);
        Route::get('/peserta/detail',[PesertaController::class, 'show']);
        Route::post('/magang', [MagangController::class, 'store']);
        Route::post('/kehadiran', [KehadiranController::class, 'store']);
        Route::get('/kehadiran',[KehadiranController::class, 'index']);
        Route::post('/izin', [IzinController::class, 'store']);
        Route::get('/complete/peserta', [PesertaController::class, 'isCompleteProfil']);
        Route::get('/complete/magang', [PesertaController::class, 'isMagang']);
        Route::get('/piket-peserta', [PiketController::class,'getPiketPeserta']);
    });

    //Perusahaan
    Route::group(['middleware' => 'role:perusahaan'], function () {
        Route::apiResource('mitra', SekolahController::class);
        Route::apiResource('admin', AdminCabangController::class);
        Route::apiResource('cabang', CabangController::class)->only(['index','store']);
        Route::apiResource('mentor', MentorController::class);
        Route::apiResource('cabang', CabangController::class);
        Route::apiResource('lowongan', LowonganController::class);
        Route::apiResource('jam-kantor', JamKantorController::class);
        Route::get('/cabang-detail', [CabangController::class, 'show']);
        Route::put('/cabang-update', [CabangController::class, 'update']);
        Route::apiResource('piket', PiketController::class)->only(['index','store','update','destroy']);
        Route::delete('piket/{piketId}/peserta/{pesertaId}', [PiketController::class, 'removePeserta']);

        Route::apiResource('magang', MagangController::class)->only(['index','show', 'update']);
        Route::put('/many/magang', [MagangController::class, 'approveMany']);

        Route::get('/peserta-by-cabang', [PesertaController::class, 'showByCabang']);
        Route::get('/jurnal-peserta-cabang', [PesertaController::class, 'getJurnalPeserta']);
        Route::put('jam-kantor/{hari}/nonaktif', [JamKantorController::class, 'unactivatedJamKantor']);
        Route::put('jam-kantor/{hari}/aktif', [JamKantorController::class, 'activatedJamKantor']);
        Route::apiResource('surat', SuratController::class);
        Route::get('surat-peringatan', [SuratController::class,'getSuratPeringatan']);
        Route::put('/lowongan/{id}/tutup', [LowonganController::class, 'tutupLowongan']);
        Route::post('/set-cabang-aktif', [CabangController::class, 'setCabangAktif']);

        Route::put('/many/izin', [IzinController::class, 'approveMany']);
        Route::get('/izin', [IzinController::class, 'index']);
        Route::put('/izin/{id}', [IzinController::class, 'update']);
        Route::get('/izin/{id}', [IzinController::class, 'show']);
        //perusahaan
        Route::post('/perusahaan', [PerusahaanController::class, 'store']);
        Route::get('/perusahaan/detail', [PerusahaanController::class, 'show']);
        Route::put('/perusahaan/update', [PerusahaanController::class, 'update']);
        Route::get('/perusahaan/edit', [PerusahaanController::class, 'edit']);
    });

    //Admin
    Route::group(['middleware' => 'role:admin'], function () {
        // Route::apiResource('piket', PiketController::class);
        Route::delete('piket/{piketId}/peserta/{pesertaId}', [PiketController::class, 'removePeserta']);
        Route::apiResource('kategori-proyek', KategoriController::class);
    });

    //Mentor
    Route::group(['middleware' => 'role:mentor'], function () {
        Route::apiResource('presentasi', JadwalPresentasiController::class)->only(['index','store', 'show']);
    });

    //Superadmin
    Route::group(['middleware' => 'role:superadmin'], function () {});

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