<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return redirect()->route('accounts.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:in,out',
            'icon' => 'nullable|string|max:10',
        ]);

        Category::create($validated);

        return redirect()->back()->with('success_category', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:in,out',
            'icon' => 'nullable|string|max:10',
        ]);

        $category->update($validated);

        return redirect()->back()->with('success_category', 'Data Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->transactions()->exists()) {
            return redirect()->back()->with('error_category', 'Gagal dihapus: Kategori ini masih digunakan pada data transaksi.');
        }

        $category->delete();

        return redirect()->back()->with('success_category', 'Kategori berhasil dihapus.');
    }
}
