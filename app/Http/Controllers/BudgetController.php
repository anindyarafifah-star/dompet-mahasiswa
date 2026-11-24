<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $month = $request->get('month', now()->format('Y-m'));
        $date = Carbon::parse($month . '-01');

        $budgets = $user->budgets()->with('category')->where('month', $month)->get()
            ->map(function ($b) use ($user, $date) {
                $b->spent = (int) $user->transactions()->month($date)
                    ->where('type', 'expense')->where('category_id', $b->category_id)->sum('amount');
                $b->percent = $b->amount > 0 ? round($b->spent / $b->amount * 100) : 0;
                return $b;
            });

        $categories = $user->categories()->where('type', 'expense')->orderBy('name')->get();

        return view('budgets.index', compact('budgets', 'categories', 'month'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'category_id' => ['required', Rule::exists('categories', 'id')
                ->where('user_id', $user->id)->where('type', 'expense')],
            'month' => 'required|date_format:Y-m',
            'amount' => 'required|integer|min:1',
        ]);

        Budget::updateOrCreate(
            ['user_id' => $user->id, 'category_id' => $data['category_id'], 'month' => $data['month']],
            ['amount' => $data['amount']]
        );

        return redirect()->route('budgets.index', ['month' => $data['month']])
            ->with('success', 'Anggaran berhasil disimpan.');
    }

    public function destroy(Request $request, Budget $budget)
    {
        abort_unless($budget->user_id === $request->user()->id, 403);
        $budget->delete();

        return back()->with('success', 'Anggaran berhasil dihapus.');
    }
}