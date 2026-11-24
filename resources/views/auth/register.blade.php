@extends('layouts.guest')
@section('title', 'Daftar')
@section('content')
<h1>Buat akun baru</h1>
<p class="auth-sub">Mulai catat dan atur keuangan kuliahmu.</p>

@if ($errors->any())
    <div class="alert-err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="field">
        <label for="name">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required autofocus>
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Masukkan password" required>
    </div>
    <div class="field">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password" required>
    </div>
    <button class="btn-block">Daftar</button>
</form>

<p class="auth-foot">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
@endsection