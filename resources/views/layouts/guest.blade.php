<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dompet Mahasiswa')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2563eb; --text: #0f172a; --muted: #64748b; --line: #e2e8f0; }
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 24px;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", sans-serif; font-size: 14px; color: var(--text);
            background: radial-gradient(ellipse 60% 50% at 50% 0%, #dbeafe 0%, #f1f5f9 100%) no-repeat, #f1f5f9;
        }
        a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .auth-card {
            width: 100%; max-width: 400px; background: #fff; border: 1px solid var(--line);
            border-radius: 16px; padding: 28px 28px 24px; box-shadow: 0 20px 40px -12px rgba(15, 23, 42, .12);
        }
        .auth-logo {
            width: 44px; height: 44px; margin: 0 auto 14px; border-radius: 12px; background: var(--primary); color: #fff;
            display: grid; place-items: center; box-shadow: 0 8px 18px rgba(37, 99, 235, .35);
        }
        .auth-card h1 { font-size: 20px; text-align: center; margin: 0; letter-spacing: -.01em; }
        .auth-sub { text-align: center; color: var(--muted); font-size: 12px; margin: 6px 0 22px; }
        .field { margin-bottom: 16px; }
        label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        input:not([type=checkbox]) {
            width: 100%; height: 42px; padding: 0 14px; font: inherit; color: var(--text);
            background: #fff; border: 1px solid #cbd5e1; border-radius: 10px;
        }
        input::placeholder { color: #94a3b8; }
        input:focus { outline: 0; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, .18); }
        .check { display: flex; align-items: center; gap: 8px; font-weight: 400; font-size: 13px; color: var(--muted); margin-bottom: 16px; cursor: pointer; }
        .check input { margin: 0; }
        .btn-block {
            width: 100%; height: 42px; border: 0; border-radius: 8px; background: var(--primary); color: #fff;
            font: inherit; font-weight: 600; cursor: pointer;
        }
        .btn-block:hover { filter: brightness(.95); }
        .auth-foot { text-align: center; color: var(--muted); margin: 18px 0 0; font-size: 13px; }
        .alert-err { background: #fee2e2; color: #991b1b; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4z"/></svg>
        </div>

        @yield('content')
    </div>
</body>
</html>