<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    // Fungsi untuk menampilkan daftar menu di halaman admin
    public function index()
    {
        $menu = Menu::latest()->paginate(5);
        return view('admin.menu.index', compact('menu')); // Kirim variabel ke tampilan
    }

    // Fungsi untuk menampilkan halaman tambah menu
    public function create()
    {
        $categories = Category::all();
        return view('admin.menu.create', compact('categories')); // Mengembalikan tampilan untuk menambahkan menu baru
    }

    // Fungsi untuk menyimpan data menu baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5|unique:menus,nama', // Menambahkan validasi unik
            'harga' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'required|min:10',
            'category_id' => 'required|exists:categories,id'
        ]);

        $menu = new Menu();
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->deskripsi = $request->deskripsi;
        $menu->category_id = $request->category_id;

        // Mengupload gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/menus', $image->hashName());
            $menu->image = $image->hashName();
        }

        $menu->save(); // Simpan menu ke database
        Alert::success('Berhasil', 'Menu berhasil ditambahkan')->autoclose(1500);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Fungsi untuk mengupdate menu
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|min:5|unique:menus,nama,' . $id, // Menambahkan validasi unik dengan pengecualian ID
            'harga' => 'required|numeric',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'required|min:10',
            'category_id' => 'required|exists:categories,id'
        ]);

        $menu = Menu::findOrFail($id);
        $menu->nama = $request->nama;
        $menu->harga = $request->harga;
        $menu->deskripsi = $request->deskripsi;
        $menu->category_id = $request->category_id;

        // Mengupload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage
            if ($menu->image) {
                Storage::delete('public/menus/' . $menu->image);
            }
            $image = $request->file('image');
            $image->storeAs('public/menus', $image->hashName());
            $menu->image = $image->hashName();
        }

        $menu->save(); // Simpan perubahan menu ke database

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // Fungsi untuk menghapus menu
    public function destroy($id)
{
    $menu = Menu::findOrFail($id);

    // Hapus gambar jika ada
    if ($menu->image && Storage::exists('public/menus/' . $menu->image)) {
        Storage::delete('public/menus/' . $menu->image);
    }

    $menu->delete();

    return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
}

    // Fungsi checkout
    public function checkout(Request $request)
    {
        $checkoutData = json_decode($request->input('checkoutData'), true);
        // Proses checkout data di sini
        return redirect()->route('confirmation');
    }

    public function edit($id)
{
    $menu = Menu::findOrFail($id);
    $categories = Category::all(); // Ambil semua kategori untuk dropdown
    return view('admin.menu.edit', compact('menu', 'categories'));
}

    // Fungsi untuk menampilkan menu di frontend
    public function showFrontendMenu()
    {
        $menus = Menu::where('is_active', true)->get();
        $categories = Category::all();
        return view('frontend.menu', compact('menus', 'categories'));  // Kirim ke tampilan
    }

    public function showFrontendMakanan()
    {
        $menus = Menu::where('category_id', '5')->get();
        return view('frontend.makanan', compact('menus'));  // Kirim ke tampilan
    }

    public function showFrontendCemilan()
    {
        $menus = Menu::where('category_id', '6')->get();
        return view('frontend.cemilan', compact('menus'));  // Kirim ke tampilan
    }

    public function showFrontendDessert()
    {
        $menus = Menu::where('category_id', '7')->get();
        return view('frontend.dessert', compact('menus'));  // Kirim ke tampilan
    }

    // Fungsi untuk menampilkan menu minuman
    public function showFrontendKopi()
    {
        $menus = Menu::where('category_id', '1')->get();
        return view('frontend.kopi', compact('menus'));  // Kirim ke tampilan
    }

    public function showFrontendNonkopi()
    {
        $menus = Menu::where('category_id', '2')->get();
        return view('frontend.nonkopi', compact('menus'));  // Kirim ke tampilan
    }

    public function showFrontendMinuman()
    {
        $menus = Menu::where('category_id', '3')->get();
        return view('frontend.minuman', compact('menus'));  // Kirim ke tampilan
    }

    public function showFrontendPaket()
    {
        $menus = Menu::where('category_id', '8')->get();

        return view('frontend.paket', compact('menus'));  // Kirim ke tampilan
    }

    public function toggle($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update(['is_active' => !$menu->is_active]);

        $status = $menu->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.menu.index')->with('success', "Menu berhasil $status!");
    }

    
}