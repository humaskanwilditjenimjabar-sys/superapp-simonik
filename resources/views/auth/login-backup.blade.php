<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login - SIMONIK</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

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

        /* background-attachment: fixed tidak berjalan di iOS Safari */
        @supports (-webkit-touch-callout: none) {

            html,
            body {
                background-attachment: scroll;
            }
        }

        .logo-watermark {
            position: fixed;
            top: 50%;
            right: -10%;
            transform: translateY(-50%);
            width: min(700px, 60vw);
            opacity: 0.04;
            pointer-events: none;
            z-index: 0;
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
            transition: all 0.4s ease;
            width: 100%;
            max-width: 400px;
        }

        /* hover hanya untuk perangkat yang mendukung hover (bukan touchscreen) */
        @media (hover: hover) {
            .glass-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.6);
                border-color: rgba(212, 175, 55, 0.3);
            }
        }

        .btn-gold {
            background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%);
            color: #ffffff;
            font-weight: 800;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        @media (hover: hover) {
            .btn-gold:hover {
                filter: brightness(1.1);
                transform: scale(1.02);
            }
        }

        .btn-gold:active {
            transform: scale(0.98);
        }

        .input-dark {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
            outline: none;
            width: 100%;
        }

        .input-dark::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .input-dark:focus {
            border-color: rgba(212, 175, 55, 0.5);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
            background: rgba(15, 23, 42, 0.9);
        }

        .input-dark.input-error {
            border-color: rgba(220, 38, 38, 0.6);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .logo-box {
            width: 6rem;
            height: 6rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(12px);
            transition: all 0.5s ease;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        @media (hover: hover) {
            .logo-box:hover {
                transform: scale(1.05);
                box-shadow: 0 25px 60px rgba(212, 175, 55, 0.2);
            }
        }

        .checkbox-gold {
            appearance: none;
            -webkit-appearance: none;
            width: 16px;
            height: 16px;
            min-width: 16px;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            background: rgba(15, 23, 42, 0.7);
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
            position: relative;
        }

        .checkbox-gold:checked {
            background: linear-gradient(135deg, #d4af37, #b8860b);
            border-color: #d4af37;
        }

        .checkbox-gold:checked::after {
            content: '';
            position: absolute;
            left: 3px;
            top: 1px;
            width: 5px;
            height: 8px;
            border: 2px solid #0F172A;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }

        /* ── Tablet (641px – 1023px) ────────────────────── */
        @media (max-width: 1023px) {
            .content-wrapper {
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 28px 24px;
                gap: 20px;
            }

            .logo-watermark {
                display: none;
            }

            .logo-box {
                width: 4.5rem !important;
                height: 4.5rem !important;
                border-radius: 1.5rem !important;
                margin-bottom: 12px !important;
            }

            .branding-title {
                font-size: 3.5rem !important;
            }

            .glass-card {
                padding: 2rem !important;
                border-radius: 1.75rem !important;
                max-width: 460px !important;
            }

            .footer-info {
                margin-top: 12px !important;
                padding-top: 10px !important;
            }
        }

        /* ── Mobile (≤ 639px) ────────────────────────────── */
        @media (max-width: 639px) {
            .content-wrapper {
                padding: 20px 16px;
                gap: 14px;
            }

            .logo-box {
                width: 3.5rem !important;
                height: 3.5rem !important;
                border-radius: 1rem !important;
                margin-bottom: 8px !important;
            }

            .branding-title {
                font-size: 2.75rem !important;
            }

            .glass-card {
                padding: 1.5rem !important;
                border-radius: 1.5rem !important;
                max-width: 100% !important;
            }

            .mobile-hide {
                display: none !important;
            }

            .footer-info {
                margin-top: 10px !important;
                padding-top: 8px !important;
            }
        }

        /* ── Layar sangat kecil (≤ 380px) ───────────────── */
        @media (max-width: 380px) {
            .content-wrapper {
                padding: 16px 12px;
                gap: 10px;
            }

            .logo-box {
                width: 3rem !important;
                height: 3rem !important;
                border-radius: 0.875rem !important;
                margin-bottom: 6px !important;
            }

            .branding-title {
                font-size: 2.25rem !important;
            }

            .glass-card {
                padding: 1.25rem !important;
                border-radius: 1.25rem !important;
            }
        }
    </style>
</head>
<img src="{{ asset('images/logo-kementerian.png') }}" alt="" class="logo-watermark" aria-hidden="true">

<body class="flex items-center justify-center min-h-screen py-4 sm:py-6">

    <div class="bg-overlay"></div>

    {{-- Main Content --}}
    <div
        class="content-wrapper w-full max-w-245 flex flex-row items-center justify-center gap-20 relative z-10 px-4 sm:px-6 py-4">

        {{-- KIRI: Branding --}}
        <div class="branding-section flex flex-col items-center justify-center text-center lg:w-1/2">
            <div class="logo-box">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SIMONIK"
                    style="width:3.5rem; height:3.5rem; object-fit:contain; filter:drop-shadow(0 8px 8px rgba(0,0,0,0.5));"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                <svg style="display:none; width:2.25rem; height:2.25rem;" fill="none" stroke="white"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 21h18M3 7v1a3 3 0 006 0V7m0 1a3 3 0 006 0V7m0 1a3 3 0 006 0V7M3 21V9.5M21 21V9.5M12 3L2 9h20L12 3z" />
                </svg>
            </div>

            <div class="relative">
                <h1 class="branding-title text-6xl lg:text-7xl font-black text-white tracking-tighter leading-none">
                    SI<span style="color: #d4af37;">MONIK</span>
                </h1>
                <span class="absolute -bottom-3 right-0 text-[9px] font-bold uppercase"
                    style="color: rgba(255,255,255,0.2); letter-spacing: 0.2em;">
                    v0.1
                </span>
            </div>

            <div class="mt-5 mobile-hide"
                style="height: 1px; width: 6rem; background: linear-gradient(to right, transparent, rgba(212,175,55,0.4), transparent);">
            </div>

            <div class="mt-2 space-y-1">
                <p class="mobile-hide text-[15px] font-semibold"
                    style="color: rgba(255,255,255,0.6); letter-spacing: 0.15em;">
                    Sistem Informasi Monitoring Keimigrasian
                </p>
                <p class="text-[13px] font-bold uppercase" style="color: #d4af37; letter-spacing: 0.2em;">
                    Kanwil Ditjenim Jawa Barat
                </p>
            </div>
        </div>

        {{-- KANAN: Form Login --}}
        <div class="flex justify-center w-full lg:w-1/2">
            <div class="glass-card rounded-4xl p-8 lg:p-10 shadow-2xl">

                <h2 class="mobile-hide text-xl font-bold text-center uppercase"
                    style="color: #d4af37; letter-spacing: 0.15em;">
                    Login
                </h2>

                <div class="lg:mt-3 mobile-hide"
                    style="height: 1px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent);">
                </div>

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="mt-4 p-3 rounded-xl text-center"
                        style="background: rgba(220,38,38,0.15); border: 1px solid rgba(220,38,38,0.3);">
                        @foreach ($errors->all() as $error)
                            <p class="text-[11px] font-semibold" style="color: #fca5a5;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="mt-4 p-3 rounded-xl text-center"
                        style="background: rgba(22,163,74,0.15); border: 1px solid rgba(22,163,74,0.3);">
                        <p class="text-[11px] font-semibold" style="color: #86efac;">{{ session('status') }}</p>
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login.post') }}" class="mt-6 lg:mt-8 space-y-4">
                    @csrf

                    {{-- NIP --}}
                    <div>
                        <label class="block text-[9px] font-bold uppercase mb-2"
                            style="color: rgba(255,255,255,0.6); letter-spacing: 0.15em;">
                            NIP
                        </label>
                        <input type="text" name="nip" value="{{ old('nip') }}" required autofocus
                            maxlength="18" placeholder="Masukkan NIP (18 digit)"
                            class="input-dark {{ $errors->has('nip') ? 'input-error' : '' }} px-4 py-3 rounded-xl text-sm">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-[9px] font-bold uppercase mb-2"
                            style="color: rgba(255,255,255,0.6); letter-spacing: 0.15em;">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input type="password" id="password-input" name="password" required placeholder="••••••••"
                                class="input-dark {{ $errors->has('password') ? 'input-error' : '' }} px-4 py-3 pr-12 rounded-xl text-sm">
                            <button type="button" id="toggle-password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-lg transition-colors"
                                style="color: rgba(255,255,255,0.3);"
                                onmouseover="this.style.color='rgba(212,175,55,0.8)'"
                                onmouseout="this.style.color='rgba(255,255,255,0.3)'">
                                <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="icon-eye-off" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Ingat Saya --}}
                    <div class="flex items-center gap-2.5 pt-1">
                        <input type="checkbox" name="remember" id="remember" class="checkbox-gold">
                        <label for="remember" class="text-[10px] font-medium cursor-pointer select-none"
                            style="color: rgba(255,255,255,0.45);">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    {{-- Tombol Masuk --}}
                    <button type="submit"
                        class="btn-gold w-full py-3.5 rounded-xl shadow-lg uppercase text-[10px] mt-2"
                        style="letter-spacing: 0.15em;">
                        Masuk
                    </button>
                </form>

                {{-- Footer --}}
                <div class="footer-info mt-6 pt-5 text-center" style="border-top: 1px solid rgba(255,255,255,0.05);">
                    <p class="text-[9px] uppercase leading-relaxed"
                        style="color: rgba(255,255,255,0.3); letter-spacing: 0.1em;">
                        Belum punya akun?
                        <a href="{{ route('daftar') }}"
                            style="color: rgba(212,175,55,0.6); cursor: pointer; transition: color 0.2s;"
                            onmouseover="this.style.color='rgba(212,175,55,1)'"
                            onmouseout="this.style.color='rgba(212,175,55,0.6)'">
                            Daftar Akun Operator
                        </a>
                    </p>
                    {{-- <p class="text-[9px] uppercase leading-relaxed mt-1"
                        style="color: rgba(255,255,255,0.3); letter-spacing: 0.1em;">
                        Bermasalah saat masuk? <br>
                        <span style="color: rgba(212,175,55,0.6);">
                            Hubungi Tim Administrator IT
                        </span>
                    </p> --}}
                </div>

            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password-input');
        const iconEye = document.getElementById('icon-eye');
        const iconEyeOff = document.getElementById('icon-eye-off');

        toggleBtn.addEventListener('click', function() {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            iconEye.classList.toggle('hidden', isPassword);
            iconEyeOff.classList.toggle('hidden', !isPassword);
        });

        // Validasi NIP hanya angka
        document.querySelector('input[name="nip"]').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>

</body>

</html>
