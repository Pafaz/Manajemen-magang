<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\FotoController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register-perusahaan', [AuthController::class, 'register_perusahaan']);
Route::post('/register-peserta', [AuthController::class, 'register_peserta']);

// routes/api.php
Route::post('/auth/google', [AuthController::class, 'googleLogin']);


Route::group(['middleware' => ['auth:sanctum', 'role:peserta']], function () {
    Route::apiResource('peserta', PesertaController::class);
    Route::apiResource('sekolah', SekolahController::class);
    Route::apiResource('jurusan', JurusanController::class);
    Route::apiResource('magang', MagangController::class);
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('foto', FotoController::class);
    Route::post('/foto/{foto}/update', [FotoController::class, 'update']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum','role:perusahaan']], function () {
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

