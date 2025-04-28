<?php
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
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\AdminCabangController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminPerusahaanController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UpdatePasswordController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register-perusahaan', [RegisterController::class, 'registerPerusahaan']);
Route::post('/register-peserta', [RegisterController::class, 'registerPeserta']);
Route::get('/auth/{role}', [GoogleAuthController::class, 'redirectAuth']);
Route::get('/auth/callback/peserta', [GoogleAuthController::class, 'callbackPeserta']);
Route::get('/auth/callback/perusahaan', [GoogleAuthController::class, 'callbackPerusahaan']);
Route::post('/send-reset-password', [ForgotPasswordController::class, 'submitForgetPasswordForm']);
Route::post('/update-password', [ForgotPasswordController::class, 'reset']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    //Peserta
    Route::group(['role:peserta'], function () {
        Route::apiResource('peserta', PesertaController::class);
        Route::apiResource('sekolah', SekolahController::class);
        Route::apiResource('jurusan', JurusanController::class);
        Route::apiResource('magang', MagangController::class);
    });

    //Perusahaan
    Route::group(['role:perusahaan'], function () {
        Route::apiResource('admin', AdminCabangController::class);
        Route::apiResource('divisi', DivisiController::class);
        Route::apiResource('cabang', CabangController::class);
        Route::apiResource('perusahaan', PerusahaanController::class);
        Route::apiResource('mentor', MentorController::class);
        Route::get('/perusahaan/detail', [PerusahaanController::class, 'show']);
        Route::put('/perusahaan/update', [PerusahaanController::class, 'update']);
        Route::get('/peserta/{id_perusahaan}', [PesertaController::class, 'showByPerusahaan']);
    });

    //Admin
    Route::group(['role:admin'], function () {
        Route::apiResource('piket', PiketController::class);
        Route::apiResource('kategori-proyek', KategoriController::class);
    });

    //Mentor
    Route::group(['role:mentor'], function () {
        //
    });

    //Superadmin
    Route::group(['role:superadmin'], function () {
        //
    });

    //foto
    Route::post('/foto/{foto}/update', [FotoController::class, 'update']);
    Route::post('/foto', [FotoController::class, 'store']);
    Route::delete('/foto/{foto}', [FotoController::class, 'destroy']);

    //auth
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);
});
