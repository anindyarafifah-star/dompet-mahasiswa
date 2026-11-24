<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $request->user()->categories()->withCount('transactions')->orderBy('name')->get();

        return view('categories.index', [
            'income' => $categories->where('type', 'income'),
            'expense' => $categories->where('type', 'expense'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
        ]);
        $request->user()->categories()->create($data);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        abort_unless($category->user_id === $request->user()->id, 403);
        $category->update($request->validate(['name' => 'required|string|max:100']));

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, Category $category)
    {
        abort_unless($category->user_id === $request->user()->id, 403);

        if ($category->transactions()->exists()) {
            return back()->withErrors(['category' => 'Kategori masih dipakai oleh transaksi dan tidak bisa dihapus.']);
        }
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}