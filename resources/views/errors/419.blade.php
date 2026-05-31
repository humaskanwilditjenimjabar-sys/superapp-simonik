<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>419 — Sesi Telah Berakhir | SIMONIK</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            text-align: center;
            padding: 2rem;
            max-width: 480px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #f5f3ff;
            border: 1px solid #ddd6fe;
            border-radius: 9999px;
            padding: 0.375rem 1rem;
            font-size: 0.6875rem;
            font-weight: 700;
            color: #7c3aed;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .code {
            font-size: 6rem;
            font-weight: 900;
            color: #1e3a8a;
            line-height: 1;
            letter-spacing: -0.04em;
            margin-bottom: 0.5rem;
        }

        .code span {
            color: #d4af37;
        }

        h1 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.75rem;
        }

        p {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            background: #1e3a8a;
            color: white;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
            margin-right: 0.5rem;
        }

        .btn-primary:hover {
            background: #152d6e;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            background: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            margin-bottom: 2.5rem;
        }

        .logo-icon {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.625rem;
            background: linear-gradient(135deg, #1e3a8a, #1a3270);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-size: 1rem;
            font-weight: 900;
            color: #1e293b;
        }

        .logo-text span {
            color: #d4af37;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <div class="logo-icon">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    style="width:1.25rem;height:1.25rem;object-fit:contain;">
            </div>
            <span class="logo-text">SI<span>MONIK</span></span>
        </div>

        <div class="badge">
            <svg style="width:0.75rem;height:0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Sesi Berakhir
        </div>

        <div class="code">4<span>1</span>9</div>
        <h1>Sesi Telah Berakhir</h1>
        <p>Sesi kamu telah kedaluwarsa karena terlalu lama tidak aktif.<br>Silakan login kembali untuk melanjutkan.</p>

        <div>
            <a href="{{ url('/login') }}" class="btn-primary">
                <svg style="width:0.875rem;height:0.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Login Kembali
            </a>
            <a href="javascript:history.back()" class="btn-secondary">
                <svg style="width:0.875rem;height:0.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        <p style="margin-top:2.5rem;font-size:0.6875rem;color:#94a3b8;">
            &copy; {{ date('Y') }} SIMONIK — Kanwil Ditjenim Jawa Barat
        </p>
    </div>
</body>

</html>
