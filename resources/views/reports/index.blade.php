@extends('layouts.app')
@section('title', 'Laporan')
@section('content')
@php
    $label = \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y');
    $total = $chartData->sum();
    $colors = ['#2563eb', '#f59e0b', '#16a34a', '#8b5cf6', '#ec4899', '#14b8a6'];
    $short = function ($n) {
        if ($n >= 1000000) return 'Rp ' . rtrim(rtrim(number_format($n / 1000000, 1, ',', '.'), '0'), ',') . ' jt';
        return $n > 0 ? 'Rp ' . number_format($n / 1000, 0, ',', '.') . ' rb' : 'Rp 0';
    };
@endphp
<div class="page-head">
    <div>
        <div class="eyebrow">Analisis Keuangan</div>
        <h1>Laporan Keuangan</h1>
        <p class="sub">Lihat ringkasan aktivitas keuangan per bulan.</p>
    </div>
    <div class="actions no-print">
        <form method="GET" class="period">
            <label>Periode</label>
            <input type="month" name="month" value="{{ $month }}" onchange="this.form.submit()" style="width:170px">
        </form>
        <button class="btn light" onclick="window.print()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Cetak
        </button>
    </div>
</div>

<div class="grid g3" style="margin-bottom:16px">
    <div class="card stat"><small>Pemasukan</small><strong class="green">{{ rp($income) }}</strong></div>
    <div class="card stat"><small>Pengeluaran</small><strong class="red">{{ rp($expense) }}</strong></div>
    <div class="card stat"><small>Selisih</small><strong>{{ rp($income - $expense) }}</strong></div>
</div>

<div class="grid g-report">
    <div class="card">
        <div class="card-head"><div><div class="card-title">Pengeluaran per Kategori</div><div class="card-sub">{{ $label }}</div></div></div>
        @if ($chartData->isEmpty())
            <p class="muted">Belum ada pengeluaran bulan ini.</p>
        @else
            <div class="donut-wrap">
                <div class="donut">
                    <canvas id="chart"></canvas>
                    <div class="donut-center"><b>{{ $short($total) }}</b><small>Total</small></div>
                </div>
                <div class="legend-col">
                    @foreach ($chartLabels as $i => $name)
                        <div><i class="dot" style="background:{{ $colors[$i % count($colors)] }}"></i>{{ $name }}
                            <strong>{{ $total > 0 ? round($chartData[$i] / $total * 100) : 0 }}%</strong></div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-head"><div><div class="card-title">Ringkasan per Kategori</div><div class="card-sub">Total transaksi</div></div></div>
        <div class="table-wrap table-flush"><table>
            <thead><tr><th>Kategori</th><th>Jenis</th><th class="r">Total</th></tr></thead>
            @forelse ($perCategory as $r)
                <tr>
                    <td><b>{{ $r->category->name }}</b></td>
                    <td><span class="pill {{ $r->type }}">{{ $r->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</span></td>
                    <td class="r" style="font-weight:500">{{ rp($r->total) }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="muted">Tidak ada data.</td></tr>
            @endforelse
        </table></div>
    </div>
</div>

<div class="card">
    <div class="card-head"><div><div class="card-title">Rincian Transaksi</div><div class="card-sub">{{ $transactions->count() }} transaksi pada periode ini</div></div></div>
    <div class="table-wrap table-flush"><table class="table-soft">
        <thead><tr><th>Tanggal</th><th>Kategori</th><th>Keterangan</th><th class="r">Nominal</th></tr></thead>
        @forelse ($transactions as $t)
            <tr>
                <td class="muted">{{ $t->date->format('d/m/Y') }}</td>
                <td><b>{{ $t->category->name }}</b></td>
                <td class="muted">{{ $t->description ?: '-' }}</td>
                <td class="r {{ $t->type == 'income' ? 'green' : 'red' }}" style="font-weight:600">{{ $t->type == 'income' ? '+' : '-' }}{{ rp($t->amount) }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="muted">Tidak ada transaksi.</td></tr>
        @endforelse
    </table></div>
</div>
@endsection

@push('scripts')
@if ($chartData->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const colors = @json($colors);
new Chart(document.getElementById('chart'), {
    type: 'doughnut',
    data: { labels: @json($chartLabels), datasets: [{ data: @json($chartData), backgroundColor: @json($chartLabels).map((_, i) => colors[i % colors.length]), borderWidth: 0 }] },
    options: { cutout: '68%', plugins: { legend: { display: false } } }
});
</script>
@endif
@endpush