<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = $user->transactions()->with('category')
            ->when($request->q, fn ($q, $v) => $q->where('description', 'like', "%{$v}%"))
            ->when($request->type, fn ($q, $v) => $q->where('type', $v))
            ->when($request->category_id, fn ($q, $v) => $q->where('category_id', $v))
            ->when($request->from, fn ($q, $v) => $q->whereDate('date', '>=', $v))
            ->when($request->to, fn ($q, $v) => $q->whereDate('date', '<=', $v))
            ->latest('date')->latest('id')
            ->paginate(10)->withQueryString();

        $categories = $user->categories()->orderBy('name')->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    public function create(Request $request)
    {
        $transaction = new Transaction([
            'type' => $request->get('type') === 'income' ? 'income' : 'expense',
            'date' => now()->toDateString(),
        ]);

        return view('transactions.form', [
            'transaction' => $transaction,
            'categories' => $request->user()->categories()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->user()->transactions()->create($this->validated($request));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(Request $request, Transaction $transaction)
    {
        $this->authorizeOwner($request, $transaction);

        return view('transactions.form', [
            'transaction' => $transaction,
            'categories' => $request->user()->categories()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorizeOwner($request, $transaction);
        $transaction->update($this->validated($request));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        $this->authorizeOwner($request, $transaction);
        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

    private function authorizeOwner(Request $request, Transaction $transaction): void
    {
        abort_unless($transaction->user_id === $request->user()->id, 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => ['required', Rule::exists('categories', 'id')
                ->where('user_id', $request->user()->id)
                ->where('type', $request->type)],
            'amount' => 'required|integer|min:1',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ], [
            'category_id.exists' => 'Kategori tidak sesuai dengan jenis transaksi.',
        ]);
    }
}