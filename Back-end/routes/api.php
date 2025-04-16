<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\UpdatePasswordController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/auth/callback', [AuthController::class, 'loginGoogle']);
// Route::get('/auth/redirect', [AuthController::class, 'redirectGoogle']);

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
    Route::post('/foto/{foto}/update', [FotoController::class, 'update']);
    Route::apiResource('foto', FotoController::class);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum','role:perusahaan']], function () {
    Route::apiResource('perusahaan', PerusahaanController::class);
    Route::apiResource('cabang', CabangController::class);
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum','role:admin']], function () {
    Route::apiResource('piket', PiketController::class);
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::group(['middleware' => ['auth_santum','role:superadmin']], function () {
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::group(['middleware' => ['auth_santum','role:mentor']], function () {
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);
});
