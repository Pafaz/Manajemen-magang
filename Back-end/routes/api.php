<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\RevisiController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\JamKantorController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PresentasiController;
use App\Http\Controllers\AdminCabangController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\JadwalPresentasiController;
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
Route::get('/lowongan-all', [LowonganController::class,'getAllLowongan']);
Route::get('/lowongan/{id}/detail', [LowonganController::class,'show']);
//show mitra di dashboard
Route::get('/mitra-all', [PerusahaanController::class, 'getMitra']);
Route::get('/mitra/{id}/detail', [PerusahaanController::class,'showMitra']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('divisi', DivisiController::class);

    //role Peserta
    Route::group(['middleware' => 'role:peserta'], function () {
        Route::get('/peserta/detail',[PesertaController::class, 'show']);
        Route::post('/magang', [MagangController::class, 'store']);
        Route::post('/kehadiran', [KehadiranController::class, 'store']);
        Route::get('/kehadiran',[KehadiranController::class, 'index']);
        Route::get('/rekap/kehadiran', [KehadiranController::class, 'getRekapKehadiran']);
        Route::post('/izin', [IzinController::class, 'store']);
        Route::post('/revisi/{route}', [RevisiController::class, 'store']);
        Route::get('/revisi/{revisi}', [RevisiController::class, 'show']);
        Route::put('/revisi/{revisi}', [RevisiController::class, 'update']);

        Route::get('/route-peserta-detail/{route}', [PesertaController::class, 'getDetailRoute']);
        Route::get('/route-peserta', [PesertaController::class, 'getDivisiRoute']);
        Route::get('/complete/peserta', [PesertaController::class, 'isCompleteProfil']);
        Route::get('/complete/magang', [PesertaController::class, 'isMagang']);
        Route::get('/complete/lowongan', [PesertaController::class,'isApplyLowongan']);
        Route::get('/piket-peserta', [PiketController::class,'getPiketPeserta']);
        Route::get('presentasi', [PresentasiController::class, 'getJadwalPresentasi']);
        Route::apiResource('peserta', PesertaController::class)->only(['store','update']);
        Route::apiResource('jurnal',JurnalController::class);
        Route::apiResource('jurusan', JurusanController::class);
        Route::apiResource('riwayat-presentasi', PresentasiController::class)->only(['index','store']);
    });

    //role Perusahaan
    Route::group(['middleware' => 'role:perusahaan'], function () {
        Route::get('/divisi/cabang/{cabangId}', [DivisiController::class, 'getByCabang']);
        Route::put('/cabang-update', [CabangController::class,'update']);
        Route::put('/lowongan/{id}/tutup', [LowonganController::class, 'tutupLowongan']);
        //set cabang aktif
        Route::post('/set-cabang-aktif', [CabangController::class, 'setCabangAktif']);
        //manajemen perusahaan
        Route::post('/perusahaan', [PerusahaanController::class, 'store']);
        Route::get('/perusahaan/detail', [PerusahaanController::class, 'show']);
        Route::put('/perusahaan/update', [PerusahaanController::class, 'update']);
        Route::get('/perusahaan/edit', [PerusahaanController::class, 'edit']);
        //Rekap Perusahaan
        Route::get('/perusahaan/rekap', [PerusahaanController::class, 'getRekap']);
        Route::get('/absensi/rekap/{cabangID?}', [PerusahaanController::class, 'getRekapAbsensi']);
        Route::get('/peserta/rekap/{cabangID?}', [PerusahaanController::class, 'getRekapPeserta']);
        Route::get('/jurnal/rekap/{cabangID?}', [PerusahaanController::class, 'getRekapJurnal']);
        //manajemen lowongan
        Route::apiResource('lowongan', LowonganController::class)->only(['index','store', 'update']);
        //manajemen mitra
        Route::apiResource('mitra', SekolahController::class);
        //manajemen admin
        Route::apiResource('admin', AdminCabangController::class);
        //manajemen cabang
        Route::apiResource('cabang', CabangController::class)->only(['index','store','destroy']);
    });

    //role admin dan perusahaan
    Route::group(['middleware' => ['checkRoles:admin,perusahaan']], function () {
        //profile cabang 
        Route::get('/cabang-detail', [CabangController::class, 'show']);
        Route::put('/cabang-update', [CabangController::class, 'update']);
        Route::get('/cabang/rekap/{cabangID?}', [CabangController::class, 'getRekapCabang']);
        //pendataan
        Route::get('/peserta-by-cabang', [PesertaController::class, 'showByCabang']);
        Route::get('/peserta-by-divisi/{divisiId}', [PesertaController::class,'showByDivisi']);
        Route::get('/jurnal-peserta-cabang', [PesertaController::class, 'getJurnalPeserta']);
        Route::get('/kehadiran-peserta-cabang', [PesertaController::class, 'getKehadiranPesertabyCabang']);
        //jam-kantor
        Route::put('jam-kantor/{hari}/nonaktif', [JamKantorController::class, 'unactivatedJamKantor']);
        Route::put('jam-kantor/{hari}/aktif', [JamKantorController::class, 'activatedJamKantor']);
        //surat
        Route::get('surat-peringatan', [SuratController::class,'getSuratPeringatan']);
        //manajemen mentor
        Route::put('/set-mentor/{mentorId}', [MagangController::class, 'setMentor']);
        Route::put('/divisi/peserta/{pesertaId}', [MagangController::class, 'editDivisi']);
        //manajemen piket
        Route::delete('piket/{piketId}/peserta/{pesertaId}', [PiketController::class, 'removePeserta']);
        //approval magang peserta
        Route::put('/many/magang', [MagangController::class, 'approveMany']);
        //approval izin peserta
        Route::put('/many/izin', [IzinController::class, 'approveMany']);
        Route::get('/izin', [IzinController::class, 'index']);
        Route::put('/izin/{id}', [IzinController::class, 'update']);
        Route::get('/izin/{id}', [IzinController::class, 'show']);
        Route::apiResource('jam-kantor', JamKantorController::class);
        Route::apiResource('surat', SuratController::class);
        Route::apiResource('piket', PiketController::class)->only(['index','store','update','destroy']);
        Route::apiResource('mentor', MentorController::class);
        Route::apiResource('magang', MagangController::class)->only(['index','show', 'update']);
    });

    //Mentor
    Route::group(['middleware' => 'role:mentor'], function () {
        Route::get('/peserta-progress', [PesertaController::class, 'showByProgress']);
        Route::get('/peserta-progress/{id}', [PesertaController::class, 'showDetailProgress']);
        Route::put('/peserta-progress/{id}', [PesertaController::class, 'markDoneRoute']);
        Route::put('presentasi/{id}', [JadwalPresentasiController::class,'update']);
        Route::apiResource('jadwal-presentasi', JadwalPresentasiController::class)->only(['index','store', 'show']);
    });

    //Superadmin
    Route::group(['middleware' => 'role:superadmin'], function () {});

    //auth
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);
    Route::get('/get-user', [LoginController::class, 'getData']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/get-user', [LoginController::class, 'getData']);
});