<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Menu Management
    public function index()
    {
        // Menampilkan menu yang ada
        $menu = Menu::latest()->paginate(5);
        return view('admin.menu.index', compact('menu'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'harga' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'required|min:10',
        ]);

        $menu = new Menu();
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->deskripsi = $request->deskripsi;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/menus', $image->hashName());
            $menu->image = $image->hashName();
        }

        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|min:10',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->deskripsi = $request->deskripsi;

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

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        Storage::delete('public/menus/' . $menu->image);
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function showOrders()
    {
        $orders = Order::with('items')->latest()->get(); // Ambil semua pesanan dengan item terkait

        // Debugging: Log apakah pesanan berhasil diambil
        if ($orders->isEmpty()) {
            Log::info('Tidak ada pesanan ditemukan.');
        } else {
            Log::info('Pesanan ditemukan: ', $orders->toArray());
        }

        return view('admin.orders.orders', compact('orders')); // Kirim variabel ke tampilan orders.blade.php
    }

    public function showOrderItems($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orderitems.orderitems', compact('order'));
    }

    // Menampilkan daftar pengguna
    public function userIndex()
    {
        $users = User::all(); // Mengambil semua pengguna
        return view('admin.users.index', compact('users')); // Mengirim data pengguna ke tampilan
    }

    // Memperbarui peran pengguna
    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|boolean' // Validasi untuk memastikan role adalah boolean
        ]);

        $user = User::findOrFail($id); // Mencari pengguna berdasarkan ID
        $user->role = $request->input('role'); // Mengupdate peran pengguna
        $user->save(); // Menyimpan perubahan

        return redirect()->route('admin.users')->with('success', 'Peran pengguna berhasil diperbarui.'); // Mengalihkan kembali dengan pesan sukses
    }

    // Menghapus pengguna
    public function destroyUser ($id)
    {
        $user = User::findOrFail($id); // Mencari pengguna berdasarkan ID
        $user->delete(); // Menghapus pengguna

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.'); // Mengalihkan kembali dengan pesan sukses
    }
}