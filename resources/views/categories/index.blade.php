@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="page-head">
    <div>
        <div class="eyebrow">Pengaturan</div>
        <h1>Kategori Transaksi</h1>
        <p class="sub">Atur kategori agar transaksi lebih mudah dikelompokkan.</p>
    </div>
</div>

<form class="card" method="POST" action="{{ route('categories.store') }}">
    @csrf
    <div class="form-row">
        <div class="grow"><label>Nama kategori</label><input name="name" placeholder="mis. Uang Saku" required></div>
        <div class="fixed" style="width:300px"><label>Jenis</label>
            <select name="type"><option value="income">Pemasukan</option><option value="expense">Pengeluaran</option></select></div>
        <button class="btn">Tambah</button>
    </div>
</form>

<div class="grid g2">
@foreach ([['Pemasukan', $income, 'g', '+'], ['Pengeluaran', $expense, 'r', '−']] as [$title, $list, $tone, $sign])
    <div class="card">
        <div class="card-head">
            <div><div class="card-title">{{ $title }}</div><div class="card-sub">{{ $list->count() }} kategori tersedia</div></div>
            <div class="sq {{ $tone }}">{{ $sign }}</div>
        </div>
        @forelse ($list as $c)
            <div class="cat-row">
                <form class="grow" method="POST" action="{{ route('categories.update', $c) }}">
                    @csrf @method('PUT')
                    <input name="name" value="{{ $c->name }}" style="flex:1">
                    <button class="btn sm">Simpan</button>
                </form>
                <span class="cnt">{{ $c->transactions_count }} transaksi</span>
                <form method="POST" action="{{ route('categories.destroy', $c) }}" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')<button class="btn red sm">Hapus</button>
                </form>
            </div>
        @empty
            <p class="muted" style="border-top:1px solid var(--line);padding-top:12px">Belum ada kategori.</p>
        @endforelse
    </div>
@endforeach
</div>
@endsection