<!DOCTYPE html>
<html lang="id" x-data="simonik()"
    :class="{ 'sidebar-collapsed': collapsed, 'sidebar-mobile-open': mobileOpen }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIMONIK' }} — SIMONIK</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    {{-- Chart.js CDN — harus di head agar tersedia saat @push('scripts') dijalankan --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- Toast Container --}}
    <style>
        @keyframes toast-in {
            from {
                opacity: 0;
                transform: translateX(1.5rem) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes toast-out {
            from {
                opacity: 1;
                transform: translateX(0);
            }

            to {
                opacity: 0;
                transform: translateX(1.5rem);
            }
        }

        @keyframes toast-bar {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        /* ── Base ── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* ── Layout wrapper ── */
        #sk-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        #sk-sidebar {
            width: 260px;
            min-width: 260px;
            background: linear-gradient(180deg, #0f172a 0%, #1a2744 50%, #0f172a 100%);
            height: 100vh;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), min-width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 50;
            flex-shrink: 0;
        }

        /* Gold line top */
        #sk-sidebar::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #d4af37, #f0d87a, #d4af37, transparent);
            z-index: 10;
        }

        /* Watermark */
        #sk-sidebar::after {
            content: "";
            position: absolute;
            bottom: -5%;
            right: -18%;
            width: 70%;
            aspect-ratio: 1;
            background: url("/images/logo-kementerian.png") no-repeat center / contain;
            opacity: 0.035;
            pointer-events: none;
            z-index: 0;
            filter: brightness(0) invert(1);
        }

        #sk-sidebar>* {
            position: relative;
            z-index: 1;
        }

        /* Collapsed */
        .sidebar-collapsed #sk-sidebar {
            width: 72px !important;
            min-width: 72px !important;
        }

        .sidebar-collapsed .sk-nav-label,
        .sidebar-collapsed .sk-nav-section,
        .sidebar-collapsed .sk-brand-text,
        .sidebar-collapsed .sk-footer-text {
            display: none !important;
        }

        .sidebar-collapsed .sk-nav-item {
            justify-content: center !important;
            padding: 0.625rem !important;
        }

        .sidebar-collapsed .sk-brand {
            justify-content: center !important;
            padding: 1rem 0.5rem !important;
        }

        /* ── Nav items ── */
        .sk-nav-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.625rem;
            margin: 0 0.375rem 0.125rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.18s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .sk-nav-item:hover {
            background: rgba(30, 58, 138, 0.4);
            color: rgba(255, 255, 255, 0.9);
        }

        .sk-nav-item.active {
            background: rgba(30, 58, 138, 0.8);
            color: white;
            font-weight: 600;
            border-left: 3px solid #d4af37;
        }

        .sk-nav-item svg {
            width: 1rem;
            height: 1rem;
            flex-shrink: 0;
            color: rgba(255, 255, 255, 0.4);
            transition: color 0.18s;
        }

        .sk-nav-item:hover svg,
        .sk-nav-item.active svg {
            color: #d4af37;
        }

        .sk-nav-section {
            font-size: 0.5625rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.2);
            padding: 0.75rem 1rem 0.25rem;
        }

        /* ── Main area ── */
        #sk-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Topbar ── */
        #sk-topbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            height: 3.5rem;
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            gap: 0.75rem;
            position: sticky;
            top: 0;
            z-index: 40;
            flex-shrink: 0;
        }

        /* ── Content ── */
        #sk-content {
            flex: 1;
            padding: 1.25rem;
            overflow-x: hidden;
        }

        /* ── Toggle button ── */
        .sk-toggle-btn {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.625rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.18s;
            color: #1e3a8a;
        }

        .sk-toggle-btn:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        /* ── Avatar ── */
        .sk-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 0.5rem;
            background: linear-gradient(135deg, #d4af37, #b8860b);
            color: #0f172a;
            font-weight: 800;
            font-size: 0.6875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ── Dropdown ── */
        .sk-dropdown {
            position: fixed;
            width: 14rem;
            background: white;
            border-radius: 0.875rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
            z-index: 99999;
            overflow: hidden;
        }

        .sk-dd-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #475569;
            text-decoration: none;
            transition: all 0.15s;
        }

        .sk-dd-item:hover {
            background: #f8fafc;
            color: #1e3a8a;
        }

        .sk-dd-logout {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: #dc2626;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .sk-dd-logout:hover {
            background: #fef2f2;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 3px;
            height: 3px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(212, 175, 55, 0.4);
            border-radius: 9999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(212, 175, 55, 0.7);
        }

        /* ── Mobile overlay ── */
        #sk-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 45;
        }

        .sidebar-mobile-open #sk-overlay {
            display: block;
        }

        @media (max-width: 1023px) {
            #sk-sidebar {
                position: fixed !important;
                top: 0;
                left: 0;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                width: 260px !important;
                min-width: 260px !important;
                z-index: 99999 !important;
            }

            .sidebar-mobile-open #sk-sidebar {
                transform: translateX(0) !important;
            }

            .sidebar-collapsed #sk-sidebar {
                width: 260px !important;
                min-width: 260px !important;
            }
        }
    </style>
</head>

<body>

    {{-- Toast Container --}}
    <div id="sk-toast"
        style="position:fixed;top:1.25rem;right:1.25rem;z-index:999999;display:flex;flex-direction:column;gap:0.5rem;pointer-events:none;">
    </div>

    <div id="sk-overlay" @click="mobileOpen = false"></div>

    <div id="sk-wrapper">

        {{-- ══ SIDEBAR ══ --}}
        <aside id="sk-sidebar">
            {{-- Brand --}}
            <div class="sk-brand"
                style="display:flex;align-items:center;gap:0.75rem;padding:1.125rem 1rem 0.875rem;flex-shrink:0;">
                <div
                    style="width:2.25rem;height:2.25rem;min-width:2.25rem;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,rgba(212,175,55,0.2),rgba(212,175,55,0.05));border:1px solid rgba(212,175,55,0.3);flex-shrink:0;">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                        style="width:1.25rem;height:1.25rem;object-fit:contain;">
                </div>
                <div class="sk-brand-text" style="display:flex;flex-direction:column;min-width:0;overflow:hidden;">
                    <p
                        style="color:white;font-weight:900;font-size:1rem;letter-spacing:-0.02em;line-height:1;margin:0;">
                        SI<span style="color:#d4af37;">MONIK</span>
                    </p>
                    <p
                        style="color:rgba(212,175,55,0.6);font-size:0.5625rem;font-weight:500;letter-spacing:0.1em;margin:0.25rem 0 0;white-space:nowrap;">
                        Kanwil Ditjenim Jabar
                    </p>
                </div>
            </div>

            {{-- Divider --}}
            <div
                style="height:1px;background:linear-gradient(90deg,transparent,rgba(212,175,55,0.3),transparent);margin:0 1rem 0.5rem;flex-shrink:0;">
            </div>

            {{-- Navigation --}}
            <nav style="flex:1;overflow-y:auto;overflow-x:hidden;padding:0.25rem 0.5rem;">
                @include('components.sidebar-nav')
            </nav>

            {{-- Footer --}}
            <div style="flex-shrink:0;padding:0 0.75rem 1rem;">
                <div
                    style="height:1px;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.08),transparent);margin-bottom:0.75rem;">
                </div>
                <div style="display:flex;align-items:flex-start;gap:0.5rem;padding:0 0.25rem;">
                    <div
                        style="width:0.375rem;height:0.375rem;border-radius:9999px;background:#d4af37;flex-shrink:0;margin-top:0.4rem;">
                    </div>
                    <div class="sk-footer-text" style="min-width:0;overflow:hidden;">
                        <p
                            style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(212,175,55,0.7);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ auth()->user()->role_label ?? auth()->user()->role }}
                        </p>
                        <p
                            style="font-size:0.6875rem;color:rgba(255,255,255,0.4);margin:0.125rem 0 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ auth()->user()->kanim?->nama_kanim ?? (auth()->user()->kanwil?->nama_kanwil ?? 'Kanwil Ditjenim Jabar') }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ══ MAIN ══ --}}
        <div id="sk-main">

            {{-- Topbar --}}
            <header id="sk-topbar">
                <div style="display:flex;align-items:center;gap:0.75rem;flex:1;min-width:0;">
                    <button @click="toggleSidebar()" class="sk-toggle-btn">
                        <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <span style="font-size:0.75rem;font-weight:500;color:#94a3b8;">SIMONIK</span>
                        <span style="color:#cbd5e1;">/</span>
                        <span
                            style="font-size:0.875rem;font-weight:700;color:#1e3a8a;">{{ $title ?? 'Dashboard' }}</span>
                    </div>
                </div>

                {{-- User dropdown --}}
                <div style="position:relative;" x-data="{ open: false }">
                    <button @click="open = !open; positionDropdown($event)"
                        style="display:flex;align-items:center;gap:0.625rem;padding:0.375rem 0.75rem;border-radius:0.75rem;background:#f8fafc;border:1px solid #e2e8f0;cursor:pointer;transition:all 0.18s;"
                        onmouseover="this.style.background='#eff6ff';this.style.borderColor='#bfdbfe'"
                        onmouseout="this.style.background='#f8fafc';this.style.borderColor='#e2e8f0'">
                        <div class="sk-avatar">
                            {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'U', 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->nama_lengkap ?? 'U U')[1] ?? 'U', 0, 1)) }}
                        </div>
                        <div style="text-align:left;">
                            <p
                                style="font-size:0.75rem;font-weight:600;color:#1e293b;line-height:1.2;margin:0;white-space:nowrap;">
                                {{ \Illuminate\Support\Str::limit(auth()->user()->nama_lengkap ?? '', 20) }}
                            </p>
                            <p style="font-size:0.625rem;color:#94a3b8;margin:0;">
                                {{ auth()->user()->role_label ?? auth()->user()->role }}
                            </p>
                        </div>
                        <svg style="width:0.75rem;height:0.75rem;color:#94a3b8;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.outside="open = false" x-cloak class="sk-dropdown" id="sk-user-dropdown"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <div style="padding:0.75rem 1rem;border-bottom:1px solid #f1f5f9;">
                            <p style="font-size:0.75rem;font-weight:700;color:#1e293b;margin:0;">
                                {{ auth()->user()->nama_lengkap }}</p>
                            <p style="font-size:0.625rem;color:#94a3b8;margin:0.25rem 0 0;">NIP
                                {{ auth()->user()->nip }}</p>
                        </div>
                        <div style="padding:0.375rem 0;">
                            <a href="#" class="sk-dd-item">
                                <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profil Saya
                            </a>
                            <a href="#" class="sk-dd-item">
                                <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                Ganti Password
                            </a>
                        </div>
                        <div style="padding:0.375rem 0;border-top:1px solid #f1f5f9;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="sk-dd-logout">
                                    <svg style="width:1rem;height:1rem;" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main id="sk-content">
                {{ $slot }}
            </main>

            {{-- Footer --}}
            <footer
                style="border-top:1px solid #e2e8f0;background:white;padding:0.625rem 1.25rem;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
                <p style="font-size:0.625rem;color:#94a3b8;margin:0;">&copy; {{ date('Y') }} SIMONIK — Kantor
                    Wilayah Direktorat Jenderal Imigrasi Jawa Barat</p>
                <p style="font-size:0.625rem;color:#94a3b8;margin:0;">v0.2</p>
            </footer>

        </div>{{-- /sk-main --}}
    </div>{{-- /sk-wrapper --}}

    @livewireScripts

    {{-- Toast JS --}}
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('sk-toast');
            const config = {
                success: {
                    bg: 'linear-gradient(135deg,#16a34a,#15803d)',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>',
                    label: 'Berhasil'
                },
                error: {
                    bg: 'linear-gradient(135deg,#dc2626,#b91c1c)',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>',
                    label: 'Gagal'
                },
                warning: {
                    bg: 'linear-gradient(135deg,#d97706,#b45309)',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.008v.008H12v-.008z"/>',
                    label: 'Perhatian'
                },
            };
            const c = config[type] || config.success;
            const toast = document.createElement('div');
            toast.style.cssText = `
                display:flex;align-items:center;gap:0.875rem;
                padding:0.875rem 1.125rem;border-radius:1rem;
                background:white;
                box-shadow:0 8px 30px rgba(0,0,0,0.12),0 2px 8px rgba(0,0,0,0.08);
                pointer-events:auto;min-width:18rem;max-width:24rem;
                animation:toast-in 0.35s cubic-bezier(0.34,1.56,0.64,1);
                border:1px solid rgba(0,0,0,0.06);
                overflow:hidden;position:relative;
            `;
            toast.innerHTML = `
                <div style="width:2.25rem;height:2.25rem;border-radius:0.625rem;background:${c.bg};display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">${c.icon}</svg>
                </div>
                <div style="flex:1;min-width:0;">
                    <p style="font-size:0.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.125rem;">${c.label}</p>
                    <p style="font-size:0.8125rem;font-weight:500;color:#1e293b;margin:0;line-height:1.4;">${message}</p>
                </div>
                <button onclick="this.closest('[data-toast]').remove()" style="background:none;border:none;cursor:pointer;color:#cbd5e1;padding:0.25rem;border-radius:0.375rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;" onmouseover="this.style.background='#f1f5f9';this.style.color='#64748b'" onmouseout="this.style.background='none';this.style.color='#cbd5e1'">
                    <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div style="position:absolute;bottom:0;left:0;height:3px;background:${c.bg};animation:toast-bar 3s linear forwards;border-radius:0 0 0 1rem;"></div>
            `;
            toast.setAttribute('data-toast', '');
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.animation = 'toast-out 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }, 3300);
        }

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (data) => {
                const msg = Array.isArray(data) ? data[0] : (data.message || data);
                showToast(typeof msg === 'object' ? msg.message : msg, 'success');
            });
            Livewire.on('notify-error', (data) => {
                const msg = Array.isArray(data) ? data[0] : (data.message || data);
                showToast(typeof msg === 'object' ? msg.message : msg, 'error');
            });
        });
    </script>

    <script>
        function simonik() {
            return {
                collapsed: localStorage.getItem('sk_collapsed') === 'true',
                mobileOpen: false,
                toggleSidebar() {
                    if (window.innerWidth >= 1024) {
                        this.collapsed = !this.collapsed;
                        localStorage.setItem('sk_collapsed', this.collapsed);
                    } else {
                        this.mobileOpen = !this.mobileOpen;
                    }
                },
                positionDropdown(e) {
                    this.$nextTick(() => {
                        const btn = e.currentTarget;
                        const dd = document.getElementById('sk-user-dropdown');
                        if (!dd) return;
                        const rect = btn.getBoundingClientRect();
                        dd.style.top = (rect.bottom + 8) + 'px';
                        dd.style.right = (window.innerWidth - rect.right) + 'px';
                    });
                }
            }
        }
    </script>

    {{-- Stack scripts — HARUS sebelum </body> agar @push('scripts') dari views bisa dirender --}}
    @stack('scripts')

</body>

</html>
