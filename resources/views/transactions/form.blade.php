@extends('layouts.app')
@section('title', $transaction->exists ? 'Ubah Transaksi' : 'Tambah Transaksi')
@section('content')
<div class="narrow">
    <a class="back" href="{{ route('transactions.index') }}">‹ Kembali ke transaksi</a>
    <div class="eyebrow">Catatan Keuangan</div>
    <h1>{{ $transaction->exists ? 'Ubah Transaksi' : 'Tambah Transaksi' }}</h1>
    <p class="sub">{{ $transaction->exists ? 'Perbarui data transaksi ini.' : 'Catat pemasukan atau pengeluaran baru.' }}</p>

    <div class="card" style="margin-top:20px">
        <form method="POST" action="{{ $transaction->exists ? route('transactions.update', $transaction) : route('transactions.store') }}">
            @csrf
            @if ($transaction->exists) @method('PUT') @endif

            <div class="field">
                <label>Jenis</label>
                <select name="type" id="type">
                    <option value="income" @selected(old('type', $transaction->type) == 'income')>Pemasukan</option>
                    <option value="expense" @selected(old('type', $transaction->type) == 'expense')>Pengeluaran</option>
                </select>
            </div>

            <div class="field">
                <label>Kategori</label>
                <select name="category_id" id="category" required>
                    <option value="" disabled @selected(! old('category_id', $transaction->category_id))>Pilih kategori</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" data-type="{{ $c->type }}" @selected(old('category_id', $transaction->category_id) == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Nominal (Rp)</label>
                <input type="number" name="amount" min="1" placeholder="0" value="{{ old('amount', $transaction->amount) }}" required>
            </div>

            <div class="field">
                <label>Tanggal</label>
                <input type="date" name="date" value="{{ old('date', optional($transaction->date)->format('Y-m-d')) }}" required>
            </div>

            <div class="field">
                <label>Keterangan (opsional)</label>
                <textarea name="description" maxlength="255" placeholder="Tambahkan catatan singkat">{{ old('description', $transaction->description) }}</textarea>
            </div>

            <button class="btn">Simpan</button>
            <a class="btn light" href="{{ route('transactions.index') }}">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const type = document.getElementById('type'), cat = document.getElementById('category');
function filterCategories() {
    [...cat.options].forEach(o => {
        if (!o.value) return;
        o.hidden = o.disabled = o.dataset.type !== type.value;
    });
    if (!cat.value || cat.selectedOptions[0]?.disabled) cat.value = '';
}
type.addEventListener('change', filterCategories);
filterCategories();
</script>
@endpush