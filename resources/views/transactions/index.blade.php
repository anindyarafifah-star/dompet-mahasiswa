@extends('layouts.app')
@section('title', 'Transaksi')
@section('content')
<div class="page-head">
    <div>
        <div class="eyebrow">Catatan Keuangan</div>
        <h1>Transaksi</h1>
        <p class="sub">Kelola semua pemasukan dan pengeluaranmu.</p>
    </div>
    <div class="actions">
        <a class="btn green" href="{{ route('transactions.create', ['type' => 'income']) }}">+ Pemasukan</a>
        <a class="btn red" href="{{ route('transactions.create', ['type' => 'expense']) }}">+ Pengeluaran</a>
    </div>
</div>

<form class="card" method="GET">
    <div class="form-row">
        <div class="grow"><label>Cari keterangan</label><input name="q" value="{{ request('q') }}" placeholder="mis. makan siang"></div>
        <div class="grow"><label>Jenis</label>
            <select name="type"><option value="">Semua</option>
                <option value="income" @selected(request('type') == 'income')>Pemasukan</option>
                <option value="expense" @selected(request('type') == 'expense')>Pengeluaran</option></select></div>
        <div class="grow"><label>Kategori</label>
            <select name="category_id"><option value="">Semua</option>
                @foreach ($categories as $c)<option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }} ({{ $c->type == 'income' ? 'masuk' : 'keluar' }})</option>@endforeach</select></div>
        <div class="grow"><label>Dari</label><input type="date" name="from" value="{{ request('from') }}"></div>
        <div class="grow"><label>Sampai</label><input type="date" name="to" value="{{ request('to') }}"></div>
        <button class="btn">Filter</button>
        <a class="btn light" href="{{ route('transactions.index') }}">Reset</a>
    </div>
</form>

<div class="card">
    <div class="table-wrap table-flush" style="margin-top:-20px"><table class="table-soft">
        <thead><tr><th>Tanggal</th><th>Jenis</th><th>Kategori</th><th>Keterangan</th><th class="r">Nominal</th><th></th></tr></thead>
        @forelse ($transactions as $t)
            <tr>
                <td class="muted">{{ $t->date->format('d/m/Y') }}</td>
                <td><span class="pill {{ $t->type }}">{{ $t->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</span></td>
                <td><b>{{ $t->category->name }}</b></td>
                <td class="muted">{{ $t->description ?: '-' }}</td>
                <td class="r {{ $t->type == 'income' ? 'green' : 'red' }}" style="font-weight:600">{{ $t->type == 'income' ? '+' : '-' }}{{ rp($t->amount) }}</td>
                <td class="r" style="white-space:nowrap">
                    <a class="btn light sm" href="{{ route('transactions.edit', $t) }}">Ubah</a>
                    <form class="inline" method="POST" action="{{ route('transactions.destroy', $t) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                        @csrf @method('DELETE')<button class="btn red sm">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted">Tidak ada transaksi.</td></tr>
        @endforelse
    </table></div>
    <div style="margin-top:20px">{{ $transactions->links('vendor.pagination.custom') }}</div>
</div>
@endsection