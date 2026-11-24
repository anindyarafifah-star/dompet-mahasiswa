<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $month = $request->get('month', now()->format('Y-m'));
        $date = Carbon::parse($month . '-01');

        $base = fn () => $user->transactions()->month($date);

        $income = $base()->where('type', 'income')->sum('amount');
        $expense = $base()->where('type', 'expense')->sum('amount');

        $perCategory = $base()
            ->selectRaw('category_id, type, SUM(amount) as total')
            ->groupBy('category_id', 'type')
            ->with('category')
            ->orderByDesc('total')
            ->get();

        $transactions = $base()->with('category')->orderBy('date')->get();

        $expenseRows = $perCategory->where('type', 'expense');
        $chartLabels = $expenseRows->map(fn ($r) => $r->category->name)->values();
        $chartData = $expenseRows->pluck('total')->map(fn ($v) => (int) $v)->values();

        return view('reports.index', compact(
            'month', 'income', 'expense', 'perCategory', 'transactions', 'chartLabels', 'chartData'
        ));
    }
}