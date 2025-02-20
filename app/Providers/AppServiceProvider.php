<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    // Hitung pesanan yang belum diproses
    $newOrdersCount = Order::where('order_status', 'pending')->count();

    // Hitung pengguna baru yang baru mendaftar hari ini, kecuali admin
    $newUsersCount = User::whereDate('created_at', today())
                         ->where('role', '!=', 'admin') // Hindari menghitung admin
                         ->count();

    // Bagikan data ke semua tampilan
    View::share([
        'newOrdersCount' => $newOrdersCount,
        'newUsersCount' => $newUsersCount,
    ]);
}

}
