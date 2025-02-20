<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    // Dashboard Admin
    public function index()
    {
        // Ambil jumlah total pesanan
        $totalOrders = Order::count();

        // Hitung total pendapatan hari ini
        $totalRevenue = Order::whereDate('created_at', today())->sum('subtotal');

        // Ambil jumlah total pengguna
        $totalUsers = User::count();

        // Ambil pesanan terbaru (5 terakhir)
        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get();

        // Ambil data pendapatan 7 hari terakhir
        $revenueData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(subtotal) as total'))
                            ->whereBetween('created_at', [now()->subDays(6), now()])
                            ->groupBy('date')
                            ->orderBy('date', 'asc')
                            ->get();

        // Format data untuk Chart.js
        $revenueLabels = $revenueData->pluck('date');
        $revenueData = $revenueData->pluck('total');

        // Kirim data ke view
        return view('admin.orders.dashboard', compact('totalOrders', 'totalRevenue', 'totalUsers', 'recentOrders', 'revenueLabels', 'revenueData'));
    }

    // Menampilkan daftar menu di halaman admin
    public function menuIndex()
    {
        $menu = Menu::latest()->paginate(5);
        return view('admin.menu.index', compact('menu'));
    }

    // Menampilkan halaman tambah menu
    public function create()
    {
        return view('admin.menu.create');
    }

    // Menyimpan menu baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'harga' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'required|min:10',
            'is_active' => 'required|boolean'
        ]);

        $menu = new Menu();
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->deskripsi = $request->deskripsi;
        $menu->is_active = $request->is_active;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/menus', $image->hashName());
            $menu->image = $image->hashName();
        }

        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Menampilkan halaman edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    // Mengupdate menu
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|min:10',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'is_active' => 'required|boolean'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->deskripsi = $request->deskripsi;
        $menu->is_active = $request->is_active;

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            Storage::delete('public/menus/' . $menu->image);
            $image = $request->file('image');
            $image->storeAs('public/menus', $image->hashName());
            $menu->image = $image->hashName();
        }

        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // Fungsi untuk menghapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->image) {
            Storage::delete('public/menus/' . $menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_active = !$menu->is_active; // Toggle nilai is_active
        $menu->save();
        Alert::success('Berhasil')->autoclose(1500);
    
        return response()->json(['success' => true, 'is_active' => $menu->is_active]);
    }
    
    // Menampilkan daftar pesanan
    public function showOrders()
    {
        $orders = Order::with('items')->latest()->get();

        if ($orders->isEmpty()) {
            Log::info('Tidak ada pesanan ditemukan.');
        } else {
            Log::info('Pesanan ditemukan: ', $orders->toArray());
        }

        return view('admin.orders.orders', compact('orders'));
    }

    // Menampilkan item dalam satu pesanan
    public function showOrderItems($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orderitems.orderitems', compact('order'));
    }

    // Menampilkan daftar pengguna
    public function userIndex()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Memperbarui peran pengguna
    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|boolean'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->input('role');
        $user->save();
        Alert::success('Berhasil', 'Peran pengguna berhasil diperbarui.')->autoclose(1500);

        return redirect()->route('admin.users')->with('success', 'Peran pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Alert::success('Berhasil', 'Pengguna berhasil dihapus.')->autoclose(1500);

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
