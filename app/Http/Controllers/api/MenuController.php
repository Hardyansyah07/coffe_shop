<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $menus = Menu::when($search, function ($query) use ($search) {
                        return $query->where('nama', 'like', "%{$search}%");
                    })
                    ->when($category, function ($query) use ($category) {
                        return $query->where('category_id', $category);
                    })
                    ->paginate(10);

        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5|unique:menus,nama',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'required|min:10',
            'category_id' => 'required|exists:categories,id'
        ]);

        $menu = new Menu();
        $menu->fill($request->only(['nama', 'harga', 'deskripsi', 'category_id', 'stok']));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/menus', $image->hashName());
            $menu->image = $image->hashName();
        }

        $menu->save();

        return response()->json(['message' => 'Menu berhasil ditambahkan!', 'data' => $menu]);
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required|min:5|unique:menus,nama,' . $id,
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048',
            'deskripsi' => 'required|min:10',
            'category_id' => 'required|exists:categories,id'
        ]);

        $menu->fill($request->only(['nama', 'harga', 'deskripsi', 'category_id', 'stok']));

        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::delete('public/menus/' . $menu->image);
            }
            $image = $request->file('image');
            $image->storeAs('public/menus', $image->hashName());
            $menu->image = $image->hashName();
        }

        $menu->save();

        return response()->json(['message' => 'Menu berhasil diperbarui!', 'data' => $menu]);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->image) {
            Storage::delete('public/menus/' . $menu->image);
        }

        $menu->delete();

        return response()->json(['message' => 'Menu berhasil dihapus!']);
    }

    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_active = !$menu->is_active;
        $menu->save();

        return response()->json(['success' => true, 'is_active' => $menu->is_active]);
    }

    public function checkout(Request $request)
    {
        $checkoutData = json_decode($request->input('checkoutData'), true);

        foreach ($checkoutData as $item) {
            $menu = Menu::find($item['menu_id']);

            if (!$menu || $menu->stok < $item['quantity']) {
                return response()->json(['error' => 'Stok tidak mencukupi untuk ' . $menu->nama], 400);
            }

            $menu->stok -= $item['quantity'];
            $menu->save();
        }

        return response()->json(['message' => 'Pesanan berhasil dilakukan!']);
    }

    public function frontendMenus()
    {
        $menus = Menu::where('is_active', 1)->where('stok', '>', 0)->get();
        $categories = Category::all();

        return response()->json([
            'menus' => $menus,
            'categories' => $categories
        ]);
    }

    public function frontendByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $menus = Menu::where('is_active', 1)
            ->where('stok', '>', 0)
            ->where('category_id', $category->id)
            ->get();

        return response()->json([
            'category' => $category->name,
            'menus' => $menus
        ]);
    }
}
