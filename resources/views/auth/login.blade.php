@extends('layouts.guest')
@section('title', 'Masuk')
@section('content')
<h1>Selamat datang kembali</h1>
<p class="auth-sub">Kelola keuangan kuliahmu dengan mudah.</p>

@if ($errors->any())
    <div class="alert-err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Masukkan password" required>
    </div>
    <label class="check"><input type="checkbox" name="remember"> Ingat saya</label>
    <button class="btn-block">Masuk</button>
</form>

<p class="auth-foot">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
@endsection