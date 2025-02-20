<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::paginate(10);
    return view('admin.categories.index', compact('categories'));
}

    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255', // Pastikan 'nama' diatur di sini
        ]);

        $categories = new Category();
        $categories->nama = $request->nama;

        $categories->save();
        alert::success('Success', 'Data Berhasil Ditambahkan')->autoClose(1000);
        return redirect()->route('categories.index');

        // Simpan kategori
        Category::create([
            'nama' => $request->nama, // Pastikan Anda menyertakan 'nama'
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

$category->update([
            'nama' => $request->nama,
        ]);
        Alert::success('Berhasil', 'Category berhasil diperbarui.')->autoclose(1500);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        Alert::success('Berhasil', 'Category berhasil dihapus')->autoclose(1500);
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}