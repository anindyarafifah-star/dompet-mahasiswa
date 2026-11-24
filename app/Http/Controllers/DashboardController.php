<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $income = $user->transactions()->where('type', 'income')->sum('amount');
        $expense = $user->transactions()->where('type', 'expense')->sum('amount');
        $recent = $user->transactions()->with('category')->latest('date')->latest('id')->take(5)->get();

        // Data grafik 6 bulan terakhir
        $labels = $incomeData = $expenseData = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->startOfMonth()->subMonths($i);
            $labels[] = $m->translatedFormat('M');
            $incomeData[] = (int) $user->transactions()->month($m)->where('type', 'income')->sum('amount');
            $expenseData[] = (int) $user->transactions()->month($m)->where('type', 'expense')->sum('amount');
        }

        return view('dashboard', compact('income', 'expense', 'recent', 'labels', 'incomeData', 'expenseData'));
    }
}