<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daftar Akun Operator — SIMONIK</title>
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
            width: 100%;
            max-width: 640px;
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
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
        }

        .input-dark::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .input-dark:focus {
            border-color: rgba(212, 175, 55, 0.5);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
            background: rgba(15, 23, 42, 0.9);
        }

        .input-error {
            border-color: rgba(220, 38, 38, 0.6) !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }

        .label-field {
            display: block;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 0.5rem;
        }

        .jenis-btn {
            padding: 0.625rem;
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            background: rgba(15, 23, 42, 0.5);
            transition: all 0.2s;
        }

        .jenis-btn.active {
            border-color: rgba(212, 175, 55, 0.6);
            color: #d4af37;
            background: rgba(212, 175, 55, 0.1);
        }

        .upload-area {
            border: 1.5px dashed rgba(255, 255, 255, 0.15);
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: rgba(15, 23, 42, 0.3);
        }

        .upload-area:hover {
            border-color: rgba(212, 175, 55, 0.4);
            background: rgba(212, 175, 55, 0.05);
        }

        .upload-area.drag-over {
            border-color: rgba(212, 175, 55, 0.6);
            background: rgba(212, 175, 55, 0.08);
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
            transition: all 0.2s;
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
    </style>
</head>

<img src="{{ asset('images/logo-kementerian.png') }}" alt="" class="logo-watermark" aria-hidden="true">

<body class="flex items-center justify-center min-h-screen px-4" style="padding-top:3rem;padding-bottom:3rem;">
    <div class="bg-overlay"></div>

    <div class="w-full max-w-2xl relative z-10" style="margin-top:2rem;margin-bottom:2rem;">

        {{-- Header --}}
        <div class="flex items-center justify-center gap-4 mb-8">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="w-10 h-10 object-contain drop-shadow-lg">
            </div>
            <div>
                <h1 class="text-xl font-black text-white leading-tight">
                    Daftar <span style="color:#d4af37;">Akun Operator</span>
                </h1>
                <p class="text-[10px] font-bold uppercase mt-1"
                    style="color:rgba(255,255,255,0.4);letter-spacing:0.15em;">
                    SIMONIK · Kanwil Ditjenim Jawa Barat
                </p>
            </div>
        </div>

        <div class="glass-card rounded-3xl p-8 shadow-2xl mx-auto">

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl"
                    style="background:rgba(220,38,38,0.15);border:1px solid rgba(220,38,38,0.3);">
                    <p class="text-xs font-bold text-red-300 mb-2 uppercase" style="letter-spacing:0.1em;">Periksa
                        kembali:</p>
                    @foreach ($errors->all() as $error)
                        <p class="text-xs text-red-300">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('daftar.post') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- NIP + No HP --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label-field">NIP <span class="text-red-400">*</span></label>
                        <input type="text" name="nip" value="{{ old('nip') }}" maxlength="18"
                            placeholder="18 digit angka"
                            class="input-dark {{ $errors->has('nip') ? 'input-error' : '' }}">
                        @error('nip')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="label-field">No. HP <span class="text-red-400">*</span></label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" maxlength="15"
                            placeholder="08xxxxxxxxxx"
                            class="input-dark {{ $errors->has('no_hp') ? 'input-error' : '' }}">
                        @error('no_hp')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label class="label-field">Nama Lengkap <span class="text-red-400">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                        placeholder="Sesuai dokumen resmi"
                        class="input-dark {{ $errors->has('nama_lengkap') ? 'input-error' : '' }}">
                    @error('nama_lengkap')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jabatan --}}
                <div>
                    <label class="label-field">Jabatan <span class="text-red-400">*</span></label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Jabatan di kantor"
                        class="input-dark {{ $errors->has('jabatan') ? 'input-error' : '' }}">
                    @error('jabatan')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kantor Imigrasi --}}
                <div>
                    <label class="label-field">Kantor Imigrasi <span class="text-red-400">*</span></label>
                    <div class="relative" id="kanim-wrapper">
                        <div class="input-dark flex items-center gap-3 cursor-pointer {{ $errors->has('kanim_id') ? 'input-error' : '' }}"
                            id="kanim-display" onclick="toggleKanim()">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24" style="color:rgba(212,175,55,0.6);flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 21h18M3 7v1a3 3 0 006 0V7m0 1a3 3 0 006 0V7m0 1a3 3 0 006 0V7M3 21V9.5M21 21V9.5M12 3L2 9h20L12 3z" />
                            </svg>
                            <span id="kanim-label" style="color:rgba(255,255,255,0.3);font-size:0.875rem;">-- Pilih
                                Kantor Imigrasi --</span>
                            <svg class="ml-auto transition-transform duration-200" id="kanim-arrow" width="14"
                                height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                style="color:rgba(255,255,255,0.3);flex-shrink:0;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        <input type="hidden" name="kanim_id" id="kanim-value" value="{{ old('kanim_id') }}">
                        <div id="kanim-dropdown"
                            class="hidden absolute left-0 right-0 z-50 mt-2 rounded-2xl overflow-hidden shadow-2xl"
                            style="background:rgba(10,18,40,0.97);border:1px solid rgba(255,255,255,0.12);">
                            <div class="p-3" style="border-bottom:1px solid rgba(255,255,255,0.07);">
                                <div class="flex items-center gap-2 px-3 py-2 rounded-xl"
                                    style="background:rgba(255,255,255,0.06);">
                                    <svg width="14" height="14" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24"
                                        style="color:rgba(255,255,255,0.3);flex-shrink:0;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input type="text" id="kanim-search" placeholder="Cari kantor imigrasi..."
                                        class="bg-transparent outline-none w-full text-sm text-white placeholder-white/20"
                                        oninput="filterKanim(this.value)">
                                </div>
                            </div>
                            <div id="kanim-options" class="overflow-y-auto" style="max-height:220px;">
                                @foreach ($kanim as $k)
                                    <div class="kanim-option flex items-center gap-3 px-4 py-3 cursor-pointer transition-all duration-150"
                                        style="border-bottom:1px solid rgba(255,255,255,0.04);"
                                        data-value="{{ $k->id }}" data-label="{{ $k->nama_kanim }}"
                                        onclick="selectKanim({{ $k->id }}, '{{ addslashes($k->nama_kanim) }}')"
                                        onmouseover="this.style.background='rgba(212,175,55,0.08)'"
                                        onmouseout="this.style.background='transparent'">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                                            style="background:rgba(212,175,55,0.1);">
                                            <span class="text-[10px] font-black"
                                                style="color:#d4af37;">{{ substr($k->nama_kanim, 0, 2) }}</span>
                                        </div>
                                        <p class="text-sm font-medium text-white leading-tight">{{ $k->nama_kanim }}
                                        </p>
                                        <svg id="check-{{ $k->id }}" width="16" height="16"
                                            fill="none" stroke="currentColor" stroke-width="2.5"
                                            viewBox="0 0 24 24" class="ml-auto flex-shrink-0 hidden"
                                            style="color:#d4af37;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                @endforeach
                                <p id="kanim-empty" class="hidden text-center text-xs py-4"
                                    style="color:rgba(255,255,255,0.3);">Tidak ditemukan</p>
                            </div>
                        </div>
                    </div>
                    @error('kanim_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bidang --}}
                <div>
                    <label class="label-field">Bidang <span class="text-red-400">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="bidang" value="doklan" class="hidden"
                                {{ old('bidang') === 'doklan' ? 'checked' : '' }}>
                            <div class="jenis-btn text-center {{ old('bidang') === 'doklan' ? 'active' : '' }}"
                                id="btn-doklan">
                                📄 Doklan<p class="text-[9px] mt-1 opacity-70">Paspor & Izin Tinggal</p>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="bidang" value="wasdakim" class="hidden"
                                {{ old('bidang') === 'wasdakim' ? 'checked' : '' }}>
                            <div class="jenis-btn text-center {{ old('bidang') === 'wasdakim' ? 'active' : '' }}"
                                id="btn-wasdakim">
                                🔍 Wasdakim<p class="text-[9px] mt-1 opacity-70">Pengawasan</p>
                            </div>
                        </label>
                    </div>
                    @error('bidang')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Layanan --}}
                <div id="jenis-layanan-wrapper">
                    <label class="label-field">Jenis Layanan <span class="text-red-400">*</span></label>
                    <div id="jenis-doklan"
                        class="grid grid-cols-2 gap-2 {{ old('bidang') === 'doklan' ? '' : 'hidden' }}">
                        @foreach (['paspor' => 'Paspor', 'izin_tinggal' => 'Izin Tinggal'] as $val => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="jenis_layanan" value="{{ $val }}"
                                    class="hidden" {{ old('jenis_layanan') === $val ? 'checked' : '' }}>
                                <div
                                    class="jenis-btn text-center {{ old('jenis_layanan') === $val ? 'active' : '' }}">
                                    {{ $label }}</div>
                            </label>
                        @endforeach
                    </div>
                    <div id="jenis-wasdakim"
                        class="grid grid-cols-2 gap-2 {{ old('bidang') === 'wasdakim' ? '' : 'hidden' }}">
                        @foreach (['pengawasan' => 'Pengawasan', 'penindakan' => 'Penindakan'] as $val => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="jenis_layanan" value="{{ $val }}"
                                    class="hidden" {{ old('jenis_layanan') === $val ? 'checked' : '' }}>
                                <div
                                    class="jenis-btn text-center {{ old('jenis_layanan') === $val ? 'active' : '' }}">
                                    {{ $label }}</div>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs mt-1 {{ old('bidang') ? 'hidden' : '' }}" id="jenis-hint"
                        style="color:rgba(255,255,255,0.3);">Pilih bidang terlebih dahulu</p>
                    @error('jenis_layanan')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="label-field">Kata Sandi <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="password" id="pw1" name="password" placeholder="Min. 8 karakter"
                                class="input-dark pr-12 {{ $errors->has('password') ? 'input-error' : '' }}">
                            <button type="button" onclick="togglePw('pw1','eye1','eye-off1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1"
                                style="color:rgba(255,255,255,0.3);">
                                <svg id="eye1" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off1" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="label-field">Konfirmasi Sandi <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <input type="password" id="pw2" name="password_confirmation"
                                placeholder="Ulangi kata sandi"
                                class="input-dark pr-12 {{ $errors->has('password') ? 'input-error' : '' }}">
                            <button type="button" onclick="togglePw('pw2','eye2','eye-off2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 p-1"
                                style="color:rgba(255,255,255,0.3);">
                                <svg id="eye2" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off2" width="16" height="16" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Upload Surat --}}
                {{-- Jangan lupa buat file template suratnya dan simpan di public/templates/template-surat-pengajuan.pdf. Kalau belum ada filenya, tombol download tetap muncul tapi file-nya perlu disiapkan dulu. --}}
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="label-field" style="margin-bottom:0;">Surat Pengajuan <span
                                class="text-red-400">*</span> <span
                                style="color:rgba(255,255,255,0.3);text-transform:none;letter-spacing:0;">(PDF, maks.
                                2MB)</span></label>
                        <a href="{{ asset('templates/template-surat-pengajuan.pdf') }}" download
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase transition-all"
                            style="background:rgba(212,175,55,0.1);border:1px solid rgba(212,175,55,0.3);color:#d4af37;letter-spacing:0.1em;text-decoration:none;"
                            onmouseover="this.style.background='rgba(212,175,55,0.2)'"
                            onmouseout="this.style.background='rgba(212,175,55,0.1)'">
                            <svg width="12" height="12" fill="none" stroke="currentColor"
                                stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download Template
                        </a>
                    </div>
                    <div class="upload-area {{ $errors->has('surat_pengajuan') ? 'border-red-500' : '' }}"
                        id="upload-area" onclick="document.getElementById('surat_pengajuan').click()">
                        <input type="file" id="surat_pengajuan" name="surat_pengajuan" accept=".pdf"
                            class="hidden" onchange="updateFileName(this)">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor"
                            style="color:rgba(212,175,55,0.6);" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p id="file-name" class="text-xs" style="color:rgba(255,255,255,0.4);">Klik untuk pilih file
                            PDF</p>
                        <p class="text-[10px] mt-1" style="color:rgba(255,255,255,0.2);">atau drag & drop di sini</p>
                    </div>
                    @error('surat_pengajuan')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="pt-2">
                    <button type="submit" class="btn-gold w-full py-3.5 rounded-xl text-xs uppercase shadow-lg"
                        style="letter-spacing:0.15em;">
                        Kirim Pendaftaran
                    </button>
                </div>
            </form>

            {{-- Footer --}}
            <div class="mt-6 pt-4 text-center" style="border-top:1px solid rgba(255,255,255,0.05);">
                <p class="text-[9px] uppercase" style="color:rgba(255,255,255,0.3);letter-spacing:0.1em;">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" style="color:rgba(212,175,55,0.7);"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='rgba(212,175,55,0.7)'">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Password toggle
        function togglePw(inputId, eyeId, eyeOffId) {
            const pw = document.getElementById(inputId);
            const isPass = pw.type === 'password';
            pw.type = isPass ? 'text' : 'password';
            document.getElementById(eyeId).classList.toggle('hidden', isPass);
            document.getElementById(eyeOffId).classList.toggle('hidden', !isPass);
        }

        // Kanim dropdown
        let kanimOpen = false;

        function toggleKanim() {
            kanimOpen = !kanimOpen;
            document.getElementById('kanim-dropdown').classList.toggle('hidden', !kanimOpen);
            document.getElementById('kanim-arrow').style.transform = kanimOpen ? 'rotate(180deg)' : '';
            if (kanimOpen) setTimeout(() => document.getElementById('kanim-search').focus(), 100);
        }

        function selectKanim(id, label) {
            document.getElementById('kanim-value').value = id;
            document.getElementById('kanim-label').textContent = label;
            document.getElementById('kanim-label').style.color = 'white';
            document.querySelectorAll('[id^="check-"]').forEach(el => el.classList.add('hidden'));
            document.getElementById('check-' + id)?.classList.remove('hidden');
            kanimOpen = false;
            document.getElementById('kanim-dropdown').classList.add('hidden');
            document.getElementById('kanim-arrow').style.transform = '';
        }

        function filterKanim(query) {
            const q = query.toLowerCase();
            let found = 0;
            document.querySelectorAll('.kanim-option').forEach(el => {
                const match = el.dataset.label.toLowerCase().includes(q);
                el.classList.toggle('hidden', !match);
                if (match) found++;
            });
            document.getElementById('kanim-empty').classList.toggle('hidden', found > 0);
        }
        document.addEventListener('click', function(e) {
            if (!document.getElementById('kanim-wrapper')?.contains(e.target)) {
                kanimOpen = false;
                document.getElementById('kanim-dropdown')?.classList.add('hidden');
                document.getElementById('kanim-arrow').style.transform = '';
            }
        });
        const oldKanim = "{{ old('kanim_id') }}";
        if (oldKanim) {
            const opt = document.querySelector(`.kanim-option[data-value="${oldKanim}"]`);
            if (opt) selectKanim(oldKanim, opt.dataset.label);
        }

        // Bidang
        document.querySelectorAll('input[name="bidang"]').forEach(radio => {
            radio.addEventListener('change', function() {
                updateBidang(this.value);
                document.querySelectorAll('[id^="btn-"]').forEach(b => b.classList.remove('active'));
                document.getElementById('btn-' + this.value)?.classList.add('active');
            });
        });
        document.querySelectorAll('.jenis-btn').forEach(btn => {
            btn.closest('label').querySelector('input').addEventListener('change', function() {
                const group = this.closest('.grid').querySelectorAll('.jenis-btn');
                group.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });

        function updateBidang(bidang) {
            document.getElementById('jenis-doklan').classList.add('hidden');
            document.getElementById('jenis-wasdakim').classList.add('hidden');
            document.getElementById('jenis-hint').classList.add('hidden');
            document.querySelectorAll('input[name="jenis_layanan"]').forEach(r => {
                r.checked = false;
                r.closest('label').querySelector('.jenis-btn').classList.remove('active');
            });
            if (bidang === 'doklan') document.getElementById('jenis-doklan').classList.remove('hidden');
            if (bidang === 'wasdakim') document.getElementById('jenis-wasdakim').classList.remove('hidden');
        }

        // File upload
        function updateFileName(input) {
            const name = input.files[0]?.name || 'Klik untuk pilih file PDF';
            document.getElementById('file-name').textContent = name;
            if (input.files[0]) document.getElementById('upload-area').style.borderColor = 'rgba(212,175,55,0.6)';
        }
        const uploadArea = document.getElementById('upload-area');
        uploadArea.addEventListener('dragover', e => {
            e.preventDefault();
            uploadArea.classList.add('drag-over');
        });
        uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
        uploadArea.addEventListener('drop', e => {
            e.preventDefault();
            uploadArea.classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file?.type === 'application/pdf') {
                const input = document.getElementById('surat_pengajuan');
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                updateFileName(input);
            }
        });

        // NIP only numbers
        document.querySelector('input[name="nip"]').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>

</html>
