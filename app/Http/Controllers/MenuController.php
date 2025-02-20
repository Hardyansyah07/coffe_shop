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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');
    
        // Ambil daftar kategori
        $categories = Category::all();
    
        // Query menu dengan pencarian dan filter kategori
        $menu = Menu::when($search, function ($query) use ($search) {
                    return $query->where('nama', 'like', "%{$search}%");
                })
                ->when($category, function ($query) use ($category) {
                    return $query->where('category_id', $category);
                })
                ->paginate(10);
    
        return view('admin.menu.index', compact('menu', 'categories'));
    }
    
    // Fungsi untuk menyimpan data menu baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5|unique:menus,nama',
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

    // Fungsi untuk menampilkan halaman edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all(); // Ambil semua kategori untuk dropdown
        return view('admin.menu.edit', compact('menu', 'categories'));
    }

    // Fungsi untuk mengupdate menu
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|min:5|unique:menus,nama,' . $id,
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
        Alert::success('Berhasil', 'Menu berhasil diperbarui!')->autoclose(1500);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // Fungsi untuk menghapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($menu->image) {
            Storage::delete('public/menus/' . $menu->image);
        }

        $menu->delete(); // Hapus menu dari database
        Alert::success('Berhasil', 'Menu berhasil dihapus!')->autoclose(1500);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_active = !$menu->is_active; // Toggle nilai is_active
        $menu->save();
    
        return response()->json(['success' => true, 'is_active' => $menu->is_active]);
    }
    
    // Fungsi checkout
    public function checkout(Request $request)
    {
        $checkoutData = json_decode($request->input('checkoutData'), true);
        // Proses checkout data di sini
        return redirect()->route('confirmation');
    }

    // Fungsi untuk menampilkan menu di frontend
        public function showFrontendMenu()
    {
        // Ambil menu yang statusnya ON (status = 1)
        $menus = Menu::where('is_active', 1)->get();
        $categories = Category::all();
        
        return view('frontend.menu', compact('menus', 'categories'));  // Kirim ke tampilan
    }

     public function showFrontendKopi()
    {
        // Ambil menu yang statusnya ON (status = 1)
        $menus = Menu::where('is_active', 1)->get();
        $categories = Category::all();
        
        return view('frontend.kopi', compact('menus', 'categories'));  // Kirim ke tampilan
    }

        public function showFrontendNonkopi()
    {
        // Ambil menu yang statusnya ON (status = 1)
        $menus = Menu::where('is_active', 1)->get();
        $categories = Category::all();
        
        return view('frontend.nonkopi', compact('menus', 'categories'));  // Kirim ke tampilan
    }

    public function showFrontendMinuman()
    {
        // Ambil menu yang statusnya ON (status = 1)
        $menus = Menu::where('is_active', 1)->get();
        $categories = Category::all();
        
        return view('frontend.minuman', compact('menus', 'categories'));  // Kirim ke tampilan
    }

    public function showFrontendPaket()
    {
        // Ambil menu yang statusnya ON (status = 1)
        $menus = Menu::where('is_active', 1)->get();
        $categories = Category::all();
        
        return view('frontend.paket', compact('menus', 'categories'));  // Kirim ke tampilan
    }

    public function showFrontendCemilan()
    {
        // Ambil menu yang statusnya ON (status = 1)
        $menus = Menu::where('is_active', 1)->get();
        $categories = Category::all();
        
        return view('frontend.cemilan', compact('menus', 'categories'));  // Kirim ke tampilan
    }

    public function showFrontendDessert()
    {
        // Ambil menu yang statusnya ON (status = 1)
        $menus = Menu::where('is_active', 1)->get();
        $categories = Category::all();
        
        return view('frontend.dessert', compact('menus', 'categories'));  // Kirim ke tampilan
    }

    public function showFrontendMakanan()
    {
        // Ambil menu yang statusnya ON (status = 1)
        $menus = Menu::where('is_active', 1)->get();
        $categories = Category::all();
        
        return view('frontend.makanan', compact('menus', 'categories'));  // Kirim ke tampilan
    }
}
