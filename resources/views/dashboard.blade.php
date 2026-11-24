@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="page-head">
    <div>
        <div class="eyebrow">Ringkasan Keuangan</div>
        <h1>Halo, {{ auth()->user()->name }}</h1>
        <p class="sub">Pantau kondisi keuanganmu hari ini.</p>
    </div>
    <div class="actions">
        <a class="btn green" href="{{ route('transactions.create', ['type' => 'income']) }}">+ Pemasukan</a>
        <a class="btn red" href="{{ route('transactions.create', ['type' => 'expense']) }}">+ Pengeluaran</a>
    </div>
</div>

<div class="grid g3" style="margin-bottom:16px">
    <div class="card stat"><small>Total Pemasukan</small><strong class="green">{{ rp($income) }}</strong></div>
    <div class="card stat"><small>Total Pengeluaran</small><strong class="red">{{ rp($expense) }}</strong></div>
    <div class="card stat"><small>Saldo</small><strong>{{ rp($income - $expense) }}</strong></div>
</div>

<div class="grid g-dash">
    <div class="card">
        <div class="card-head">
            <div><div class="card-title">Pemasukan vs Pengeluaran</div><div class="card-sub">6 bulan terakhir</div></div>
            <div class="legend">
                <span><i class="dot" style="background:#16a34a"></i>Pemasukan</span>
                <span><i class="dot" style="background:#dc2626"></i>Pengeluaran</span>
            </div>
        </div>
        <div class="chart-box"><canvas id="chart"></canvas></div>
    </div>

    <div class="card">
        <div class="card-head">
            <div><div class="card-title">Transaksi Terbaru</div><div class="card-sub">Aktivitas terkini</div></div>
            <a href="{{ route('transactions.index') }}" style="font-size:12px;font-weight:600">Lihat semua</a>
        </div>
        @forelse ($recent as $t)
            <div class="recent">
                <div class="ico {{ $t->type == 'income' ? 'inc' : 'exp' }}">
                    @if ($t->type == 'income')
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/></svg>
                    @else
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    @endif
                </div>
                <div class="mid"><b>{{ $t->category->name }}</b><small>{{ $t->description ?: '-' }} · {{ $t->date->format('d/m/Y') }}</small></div>
                <div class="amt {{ $t->type == 'income' ? 'green' : 'red' }}">{{ $t->type == 'income' ? '+' : '-' }}{{ rp($t->amount) }}</div>
            </div>
        @empty
            <p class="muted">Belum ada transaksi.</p>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const fmt = v => v >= 1e6 ? String(v / 1e6).replace('.', ',') + ' jt' : (v >= 1e3 ? (v / 1e3) + ' rb' : v);
new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [
            { label: 'Pemasukan', data: @json($incomeData), backgroundColor: '#16a34a', borderRadius: 4, barThickness: 14 },
            { label: 'Pengeluaran', data: @json($expenseData), backgroundColor: '#dc2626', borderRadius: 4, barThickness: 14 }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false },
            tooltip: { callbacks: { label: c => c.dataset.label + ': Rp ' + c.parsed.y.toLocaleString('id-ID') } } },
        scales: {
            x: { grid: { display: false }, border: { display: false } },
            y: { beginAtZero: true, grid: { color: '#e2e8f0' }, border: { display: false, dash: [4, 4] },
                 ticks: { callback: fmt, maxTicksLimit: 4, color: '#94a3b8' } }
        }
    }
});
</script>
@endpush