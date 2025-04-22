<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\api\MenuController;
use App\Http\Controllers\WeeklyRevenueReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route tanpa autentikasi
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Endpoint untuk menu (tanpa autentikasi)
// Route::get('/menus', [MenuController::class, 'index']); // Get semua menu
Route::get('/menu', [\App\Http\Controllers\MenuController::class, 'indexapi']);
// Route::post('/menus', [MenuController::class, 'store']); // Tambah menu baru
// Route::get('/menus/{id}', [MenuController::class, 'show']); // Get detail menu
// Route::delete('/menus/{id}', [MenuController::class, 'destroy']); // Hapus menu

// Endpoint untuk "Your Menu" (misalnya untuk user tertentu)
// Route::get('/your-menu', [MenuController::class, 'yourMenu']);

// Route dengan autentikasi (butuh token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Proteksi route laporan mingguan
    Route::get('/weekly-reports', [WeeklyRevenueReportController::class, 'index']);

    // Tambahkan route logout agar bisa keluar dari sistem
    Route::post('/logout', [AuthController::class, 'logout']);
});
