@extends('layouts.app')
@section('title', 'Anggaran')
@section('content')
@php $label = \Carbon\Carbon::parse($month . '-01')->translatedFormat('F Y'); @endphp
<div class="page-head">
    <div>
        <div class="eyebrow">Rencana Bulanan</div>
        <h1>Anggaran Bulanan</h1>
        <p class="sub">Tetapkan batas pengeluaran dan pantau pemakaiannya.</p>
    </div>
    <form method="GET" class="period">
        <label>Periode</label>
        <input type="month" name="month" value="{{ $month }}" onchange="this.form.submit()" style="width:170px">
    </form>
</div>

<form class="card" method="POST" action="{{ route('budgets.store') }}">
    @csrf
    <input type="hidden" name="month" value="{{ $month }}">
    <div class="form-row">
        <div class="grow"><label>Kategori pengeluaran</label>
            <select name="category_id" required>
                <option value="" disabled selected>Pilih kategori</option>
                @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
            </select></div>
        <div class="grow"><label>Batas anggaran (Rp) untuk {{ $month }}</label>
            <input type="number" name="amount" min="1" placeholder="0" required></div>
        <button class="btn">Simpan</button>
    </div>
</form>

<div class="card">
    <div class="card-head">
        <div><div class="card-title">Pemakaian Anggaran</div><div class="card-sub">{{ $label }}</div></div>
        <div class="card-sub">{{ $budgets->count() }} kategori</div>
    </div>
    @forelse ($budgets as $b)
        @php
            $cls = $b->percent >= 100 ? 'over' : ($b->percent >= 80 ? 'warn' : '');
            $tone = $b->percent >= 100 ? 'red' : ($b->percent >= 80 ? 'amber' : 'green');
        @endphp
        <div class="b-item">
            <div class="b-top">
                <div>
                    <div class="b-name">{{ $b->category->name }}</div>
                    @if ($b->percent >= 100) <div class="b-note red">Anggaran terlampaui {{ rp($b->spent - $b->amount) }}</div>
                    @elseif ($b->percent >= 80) <div class="b-note amber">Hampir mencapai batas anggaran</div> @endif
                </div>
                <div class="b-amt"><strong>{{ rp($b->spent) }}</strong> dari {{ rp($b->amount) }}</div>
            </div>
            <div class="bar {{ $cls }}"><span style="width:{{ min($b->percent, 100) }}%"></span></div>
            <div class="b-bot">
                <span>Terpakai
                    <form class="inline" method="POST" action="{{ route('budgets.destroy', $b) }}" onsubmit="return confirm('Hapus anggaran ini?')">
                        @csrf @method('DELETE') &nbsp;<button class="link-danger">Hapus</button>
                    </form>
                </span>
                <span class="pct {{ $tone }}">{{ $b->percent }}%</span>
            </div>
        </div>
    @empty
        <p class="muted" style="border-top:1px solid var(--line);padding-top:14px">Belum ada anggaran untuk bulan ini.</p>
    @endforelse
</div>
@endsection