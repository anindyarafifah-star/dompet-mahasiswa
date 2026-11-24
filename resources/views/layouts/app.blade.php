<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dompet Mahasiswa')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb; --green: #16a34a; --red: #dc2626; --amber: #f59e0b; --amber-text: #b45309;
            --bg: #f1f5f9; --card: #fff; --text: #0f172a; --muted: #64748b; --line: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Inter, system-ui, -apple-system, "Segoe UI", sans-serif; font-size: 14px; background: var(--bg); color: var(--text); }
        a { color: var(--primary); text-decoration: none; }
        .container { max-width: 1100px; margin: 0 auto; padding: 28px 24px 48px; }
        .narrow { max-width: 560px; margin: 0 auto; }
        .muted { color: var(--muted); } .inline { display: inline; }
        .green { color: var(--green); } .red { color: var(--red); } .amber { color: var(--amber-text); }

        /* Navbar */
        .topbar { background: var(--card); border-bottom: 1px solid var(--line); }
        .topbar-in { max-width: 1100px; margin: 0 auto; padding: 0 24px; height: 64px; display: flex; align-items: center; gap: 28px; }
        .brand { font-size: 18px; font-weight: 700; color: var(--primary); }
        .menu { display: flex; height: 100%; gap: 4px; overflow-x: auto; }
        .menu a { display: flex; align-items: center; padding: 0 14px; color: var(--muted); font-weight: 500; border-bottom: 2px solid transparent; }
        .menu a:hover { color: var(--text); }
        .menu a.active { color: var(--primary); border-color: var(--primary); }
        .user { margin-left: auto; display: flex; align-items: center; gap: 14px; }
        .logout { background: none; border: 0; padding: 0; font: inherit; color: var(--muted); cursor: pointer; }
        .logout:hover { color: var(--red); }

        /* Header halaman */
        .page-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
        .eyebrow { font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--primary); margin-bottom: 6px; }
        h1 { font-size: 24px; line-height: 1.2; margin: 0; letter-spacing: -.01em; }
        .sub { color: var(--muted); margin: 6px 0 0; }
        .back { display: inline-block; color: var(--muted); font-size: 13px; margin-bottom: 14px; }
        .actions { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; }

        /* Kartu dan grid */
        .card { background: var(--card); border: 1px solid var(--line); border-radius: 14px; padding: 20px; margin-bottom: 16px; }
        .card-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 14px; }
        .card-title { font-size: 16px; font-weight: 700; } .card-sub { font-size: 12px; color: var(--muted); margin-top: 3px; }
        .grid { display: grid; gap: 16px; align-items: start; }
        .g3 { grid-template-columns: repeat(3, 1fr); } .g2 { grid-template-columns: 1fr 1fr; }
        .g-dash { grid-template-columns: 1.35fr 1fr; } .g-report { grid-template-columns: 1fr 1.35fr; }
        .stat { border-left: 3px solid var(--primary); padding: 16px 20px; margin-bottom: 0; }
        .stat small { display: block; color: var(--muted); font-size: 14px; }
        .stat strong { display: block; font-size: 28px; font-weight: 700; margin-top: 4px; letter-spacing: -.01em; }
        .sq { width: 32px; height: 32px; border-radius: 8px; display: grid; place-items: center; font-weight: 700; font-size: 18px; }
        .sq.g { background: #dcfce7; color: var(--green); } .sq.r { background: #fee2e2; color: var(--red); }

        /* Form */
        label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .field { margin-bottom: 18px; }
        input, select, textarea { width: 100%; font: inherit; color: var(--text); background: #fff; border: 1px solid #cbd5e1; border-radius: 10px; }
        input:not([type=checkbox]), select { height: 44px; padding: 0 14px; }
        textarea { min-height: 96px; padding: 12px 14px; resize: vertical; }
        input[type=checkbox] { width: auto; height: auto; }
        input::placeholder, textarea::placeholder { color: #94a3b8; }
        input:focus, select:focus, textarea:focus { outline: 0; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,.18); }
        select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%230f172a' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 38px; }
        .form-row { display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap; }
        .form-row > .grow { flex: 1; min-width: 160px; } .form-row > .fixed { width: 200px; }
        .period label { margin-bottom: 4px; font-size: 12px; }

        /* Tombol */
        .btn { display: inline-flex; align-items: center; gap: 6px; background: var(--primary); color: #fff; border: 1px solid transparent; padding: 10px 18px; border-radius: 8px; font: inherit; font-weight: 600; cursor: pointer; }
        .btn:hover { filter: brightness(.95); }
        .btn.green { background: var(--green); } .btn.red { background: var(--red); }
        .btn.light { background: #f1f5f9; color: #334155; border-color: var(--line); }
        .btn.sm { padding: 7px 12px; font-size: 12px; }
        .link-danger { background: none; border: 0; padding: 0; font: inherit; font-size: 11px; color: var(--muted); cursor: pointer; text-decoration: underline; }
        .link-danger:hover { color: var(--red); }

        /* Notifikasi, badge, tabel */
        .alert { padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert.ok { background: #dcfce7; color: #166534; } .alert.err { background: #fee2e2; color: #991b1b; }
        .pill { display: inline-block; padding: 3px 12px; border-radius: 99px; font-size: 12px; font-weight: 500; }
        .pill.income { background: #dcfce7; color: #166534; } .pill.expense { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--muted); padding: 12px 16px; }
        td { padding: 14px 16px; border-top: 1px solid var(--line); }
        .table-wrap { overflow-x: auto; } .r { text-align: right; }
        .table-soft th { background: #f8fafc; } .table-flush { margin: 0 -20px -20px; width: calc(100% + 40px); }

        /* Transaksi terbaru */
        .recent { display: flex; align-items: center; gap: 12px; padding: 14px 0; border-top: 1px solid var(--line); }
        .recent:first-of-type { border-top: 0; }
        .ico { width: 32px; height: 32px; border-radius: 10px; display: grid; place-items: center; flex: none; }
        .ico.exp { background: #fee2e2; color: var(--red); } .ico.inc { background: #dcfce7; color: var(--green); }
        .recent .mid { flex: 1; min-width: 0; } .recent .mid b { display: block; } .recent .mid small { color: var(--muted); }
        .recent .amt { font-weight: 700; }

        /* Chart */
        .chart-box { position: relative; height: 290px; }
        .legend { display: flex; gap: 14px; font-size: 12px; color: var(--muted); }
        .dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 6px; }
        .donut-wrap { display: flex; align-items: center; justify-content: center; gap: 28px; flex-wrap: wrap; padding: 8px 0; }
        .donut { position: relative; width: 190px; height: 190px; }
        .donut-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none; }
        .donut-center b { font-size: 15px; } .donut-center small { color: var(--muted); font-size: 11px; }
        .legend-col div { display: flex; align-items: center; gap: 8px; margin: 10px 0; font-size: 13px; }
        .legend-col strong { margin-left: auto; padding-left: 16px; }

        /* Kategori */
        .cat-row { display: flex; align-items: center; gap: 8px; padding: 12px 0; border-top: 1px solid var(--line); }
        .cat-row form.grow { flex: 1; display: flex; gap: 8px; align-items: center; }
        .cat-row input { height: 40px; } .cat-row .cnt { font-size: 11px; color: var(--muted); white-space: nowrap; }

        /* Anggaran */
        .b-item { padding: 16px 0; border-top: 1px solid var(--line); }
        .b-top { display: flex; justify-content: space-between; gap: 12px; align-items: flex-start; }
        .b-name { font-weight: 700; } .b-note { font-size: 11px; margin-top: 3px; }
        .b-amt { font-size: 13px; color: var(--muted); white-space: nowrap; } .b-amt strong { color: var(--text); }
        .bar { background: #e2e8f0; border-radius: 99px; height: 8px; overflow: hidden; margin: 8px 0 6px; }
        .bar > span { display: block; height: 100%; border-radius: 99px; background: var(--green); }
        .bar.warn > span { background: var(--amber); } .bar.over > span { background: var(--red); }
        .b-bot { display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: var(--muted); }
        .b-bot .pct { font-weight: 700; font-size: 12px; }

        /* Auth, pagination */
        .auth { max-width: 400px; margin: 60px auto; }
        .pager { display: flex; justify-content: space-between; align-items: center; gap: 10px; flex-wrap: wrap; font-size: 13px; }
        .pager .pages { display: flex; gap: 6px; flex-wrap: wrap; }
        .pager a, .pager span.current, .pager span.disabled { padding: 6px 12px; border: 1px solid var(--line); border-radius: 6px; color: var(--text); background: #fff; }
        .pager a:hover { background: #e2e8f0; }
        .pager span.current { background: var(--primary); border-color: var(--primary); color: #fff; }
        .pager span.disabled { color: #94a3b8; background: #f8fafc; }

        @media (max-width: 800px) {
            .g3, .g2, .g-dash, .g-report { grid-template-columns: 1fr; }
            .topbar-in { gap: 12px; padding: 0 12px; } .brand { font-size: 15px; }
        }
        @media print { .topbar, .no-print { display: none !important; } body { background: #fff; } }
    </style>
</head>
<body>
@auth
<header class="topbar">
    <div class="topbar-in">
        <a class="brand" href="{{ route('dashboard') }}">Dompet Mahasiswa</a>
        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">Transaksi</a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori</a>
            <a href="{{ route('budgets.index') }}" class="{{ request()->routeIs('budgets.*') ? 'active' : '' }}">Anggaran</a>
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Laporan</a>
        </nav>
        <div class="user">
            <strong>{{ auth()->user()->name }}</strong>
            <form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button class="logout">Keluar</button></form>
        </div>
    </div>
</header>
@endauth

<main class="container">
    @if (session('success')) <div class="alert ok">{{ session('success') }}</div> @endif
    @if ($errors->any())
        <div class="alert err">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    @yield('content')
</main>
@stack('scripts')
</body>
</html>