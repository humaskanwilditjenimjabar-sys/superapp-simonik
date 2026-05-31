<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan — SIMONIK</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        *,
        *::before,
        *::after {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background: radial-gradient(circle at top right, #ffffff 0%, #1e3a8a 30%, #020617 100%);
            background-attachment: fixed;
        }

        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: rgba(12, 42, 176, 0.75);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen py-8 px-4">
    <div class="bg-overlay"></div>
    <div class="w-full max-w-md relative z-10 text-center">
        <div class="glass-card rounded-3xl p-10 shadow-2xl">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl flex items-center justify-center"
                style="background:rgba(212,175,55,0.1);border:1px solid rgba(212,175,55,0.3);">
                <svg class="w-10 h-10" fill="none" stroke="#d4af37" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-xl font-black text-white mb-2">Pendaftaran Terkirim!</h1>
            <p class="text-sm mb-6" style="color:rgba(255,255,255,0.5);">Akun kamu sedang menunggu persetujuan dari
                Administrator. Kamu akan dihubungi setelah akun disetujui.</p>
            <div class="p-4 rounded-2xl mb-6"
                style="background:rgba(212,175,55,0.08);border:1px solid rgba(212,175,55,0.2);">
                <p class="text-xs font-semibold" style="color:rgba(212,175,55,0.8);">Proses persetujuan biasanya memakan
                    waktu 1x24 jam kerja</p>
            </div>
            <a href="{{ route('login') }}" class="block w-full py-3 rounded-xl text-center text-xs font-black uppercase"
                style="background:linear-gradient(135deg,#d4af37,#b8860b);color:white;letter-spacing:0.15em;">
                Kembali ke Login
            </a>
        </div>
        <p class="text-xs mt-6" style="color:rgba(255,255,255,0.3);">© {{ date('Y') }} SIMONIK — Kanwil Ditjenim
            Jawa Barat</p>
    </div>
</body>

</html>
