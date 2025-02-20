<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WeeklyRevenueReportController;
use Illuminate\Support\Facades\Auth;

// Autentikasi
Auth::routes(['register' => false]);

// Frontend Routes (Halaman yang bisa diakses tanpa login)
Route::get('/', [MenuController::class, 'showFrontendMenu'])->name('frontend.menu');

// Checkout Routes (Halaman yang bisa diakses tanpa login)
Route::get('/checkout', [CheckoutController::class, 'showFrontendCheckout'])->name('checkout');
Route::post('/checkout/confirm', [CheckoutController::class, 'confirmation'])->name('checkout.confirm');
Route::get('/confirmation', [CheckoutController::class, 'showConfirmation'])->name('confirmation');

// Rute untuk pendaftaran pengguna (user dapat mendaftar sebelum login)
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Rute untuk login (user dapat login sebelum mengakses halaman yang dibatasi)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rute untuk halaman setelah login (User  dapat mengakses home setelah login)
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Rute untuk kategori
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('frontend.category');

// Rute untuk menu makanan dan minuman
Route::get('/menu/makanan', [MenuController::class, 'showFrontendMakanan'])->name('frontend.makanan');
Route::get('/menu/kopi', [MenuController::class, 'showFrontendKopi'])->name('frontend.kopi');
Route::get('/menu/cemilan', [MenuController::class, 'showFrontendCemilan'])->name('frontend.cemilan');
Route::get('/menu/dessert', [MenuController::class, 'showFrontendDessert'])->name('frontend.dessert');
Route::get('/menu/nonkopi', [MenuController::class, 'showFrontendNonkopi'])->name('frontend.nonkopi');
Route::get('/menu/minuman', [MenuController::class, 'showFrontendMinuman'])->name('frontend.minuman');
Route::get('/menu/paket', [MenuController::class, 'showFrontendPaket'])->name('frontend.paket');

// Rute untuk halaman tentang dan toko
Route::get('/about', function () {
    return view('frontend.about');
})->name('frontend.about');

Route::get('/store', function () {
    return view('frontend.store');
})->name('frontend.store');

// Rute untuk kategori (CRUD)
Route::apiResource('categories', CategoryController::class); // Menambahkan rute kategori

// Admin Routes (Hanya dapat diakses oleh admin yang sudah login)
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    // Admin Dashboard (Page utama admin)
    Route::get('/', [AdminController::class, 'index'])->name('admin.orders.dashboard');


    // Rute untuk Menu (Mengelola menu)
    Route::resource('/menu', MenuController::class)->names([
        'index' => 'admin.menu.index',
        'create' => 'admin.menu.create',
        'store' => 'admin.menu.store',
        'show' => 'admin.menu.show',
        'edit' => 'admin.menu.edit',
        'update' => 'admin.menu.update',
        'destroy' => 'admin.menu.destroy',
    ]);
    Route::post('/admin/menu/{id}/toggle-status',  [MenuController::class, 'toggleStatus'])->name('admin.menu.toggleStatus');

    // Rute untuk Kategori (Mengelola kategori)
    Route::resource('/categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Rute untuk melihat semua pesanan
    Route::get('/orders', [AdminController::class, 'showOrders'])->name('admin.orders');
    Route::post('/orders/{id}/update-payment', [OrderController::class, 'updatePaymentStatus'])->name('orders.updatePayment');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateOrderStatus'])->name('orders.updateStatus');


    Route::get('/sales-reports', [SalesReportController::class, 'index'])->name('admin.sales_reports.index');
    Route::post('/sales-reports/generate', [SalesReportController::class, 'generateReport'])->name('sales_reports.generate');


    // Rute untuk melihat item pesanan berdasarkan ID
    Route::get('/orders/{id}/items', [AdminController::class, 'showOrderItems'])->name('admin.orders.items.show');

    // Rute untuk memperbarui status pesanan
    Route::post('/orders/{id}/{status}', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update');

    // Rute untuk mengupdate peran pengguna
    Route::get('/users', [AdminController::class, 'userIndex'])->name('admin.users'); // Route for listing users
    Route::post('/users/{id}/role', [AdminController::class, 'updateUser Role'])->name('admin.users.updateRole'); // Route for updating user role
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy'); // Route for deleting a user

    Route::get('/weekly-report', [WeeklyRevenueReportController::class, 'index'])->name('weekly.report');

});