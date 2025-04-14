<?php
use App\Http\Controllers\PerusahaanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\FotoController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register-perusahaan', [AuthController::class, 'register_perusahaan']);
Route::post('/register-peserta', [AuthController::class, 'register_peserta']);

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'reset']);

Route::group(['middleware' => ['auth:sanctum', 'role:peserta']], function () {
    Route::apiResource('peserta', PesertaController::class);
    Route::apiResource('sekolah', SekolahController::class);
    Route::apiResource('jurusan', JurusanController::class);
    Route::apiResource('magang', MagangController::class);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/foto/{foto}/update', [FotoController::class, 'update']);
    Route::apiResource('foto', FotoController::class);

});

Route::group(['middleware' => ['auth:sanctum','role:perusahaan']], function () {
    Route::apiResource('perusahaan', PerusahaanController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum','role:admin']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth_santum','role:superadmin']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth_santum','role:mentor']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
