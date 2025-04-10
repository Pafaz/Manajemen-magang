<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/perusahan', [AuthController::class, 'register']);
Route::post('/register/peserta', [AuthController::class, 'register']);

Route::post('/password/email', [PasswordResetController::class, 'sendResetLink']);
Route::post('/password/reset', [PasswordResetController::class, 'reset']);

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('peserta', PesertaController::class);
        Route::apiResource('sekolah', SekolahController::class);
        Route::apiResource('jurusan', JurusanController::class);
    }
);

// Route::apiResource('peserta', PesertaController::class);
// Route::apiResource('sekolah', SekolahController::class);
// Route::apiResource('jurusan', JurusanController::class);
