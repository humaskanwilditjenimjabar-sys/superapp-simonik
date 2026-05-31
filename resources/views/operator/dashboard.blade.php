<div class="space-y-4">

    {{-- ══════════════════════════════════════════════
         HEADER CARD — Info Operator
    ══════════════════════════════════════════════ --}}
    <div class="rounded-2xl overflow-hidden"
        style="background:linear-gradient(135deg,#1e3a8a 0%,#1a3270 60%,#0f2557 100%);">

        {{-- Top strip: avatar + nama + status input --}}
        <div
            style="padding:1.25rem 1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">

            {{-- Kiri: Avatar + Nama + Jabatan --}}
            <div style="display:flex;align-items:center;gap:1rem;">
                {{-- Avatar besar --}}
                <div
                    style="width:3.25rem;height:3.25rem;border-radius:1rem;background:linear-gradient(135deg,rgba(212,175,55,0.3),rgba(212,175,55,0.1));border:2px solid rgba(212,175,55,0.4);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.125rem;font-weight:900;color:#d4af37;letter-spacing:-0.03em;">
                    {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->nama_lengkap)[1] ?? 'X', 0, 1)) }}
                </div>
                <div>
                    <p style="font-size:1.0625rem;font-weight:800;color:white;margin:0;line-height:1.2;">
                        {{ $user->nama_lengkap }}</p>
                    <p style="font-size:0.75rem;color:rgba(255,255,255,0.55);margin:0.2rem 0 0;">
                        {{ $user->jabatan ?? 'Operator' }}
                        @if ($user->kanim)
                            <span style="color:rgba(212,175,55,0.6);margin:0 0.375rem;">·</span>
                            {{ $user->kanim->nama_kanim }}
                        @endif
                    </p>
                </div>
            </div>

            {{-- Kanan: Badge status input --}}
            <div style="display:flex;align-items:center;gap:0.625rem;flex-wrap:wrap;">
                {{-- Hari ini --}}
                <div
                    style="display:flex;align-items:center;gap:0.4rem;padding:0.4375rem 0.875rem;border-radius:0.625rem;background:{{ $sudahHariIni ? 'rgba(22,163,74,0.18)' : 'rgba(220,38,38,0.18)' }};border:1px solid {{ $sudahHariIni ? 'rgba(22,163,74,0.35)' : 'rgba(220,38,38,0.35)' }};">
                    <svg style="width:0.8125rem;height:0.8125rem;" fill="none" viewBox="0 0 24 24"
                        stroke="{{ $sudahHariIni ? '#4ade80' : '#f87171' }}" stroke-width="2.5">
                        @if ($sudahHariIni)
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        @endif
                    </svg>
                    <span
                        style="font-size:0.6875rem;font-weight:600;color:{{ $sudahHariIni ? '#4ade80' : '#f87171' }};">
                        Hari ini {{ $sudahHariIni ? 'sudah' : 'belum' }} input
                    </span>
                </div>
                {{-- Kemarin --}}
                <div
                    style="display:flex;align-items:center;gap:0.4rem;padding:0.4375rem 0.875rem;border-radius:0.625rem;background:{{ $sudahKemarin ? 'rgba(22,163,74,0.18)' : 'rgba(217,119,6,0.18)' }};border:1px solid {{ $sudahKemarin ? 'rgba(22,163,74,0.35)' : 'rgba(217,119,6,0.35)' }};">
                    <svg style="width:0.8125rem;height:0.8125rem;" fill="none" viewBox="0 0 24 24"
                        stroke="{{ $sudahKemarin ? '#4ade80' : '#fbbf24' }}" stroke-width="2.5">
                        @if ($sudahKemarin)
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        @endif
                    </svg>
                    <span
                        style="font-size:0.6875rem;font-weight:600;color:{{ $sudahKemarin ? '#4ade80' : '#fbbf24' }};">
                        Kemarin {{ $sudahKemarin ? 'sudah' : 'belum' }} input
                    </span>
                </div>
            </div>
        </div>

        {{-- Divider tipis --}}
        <div style="height:1px;background:rgba(255,255,255,0.07);margin:0 1.5rem;"></div>

        {{-- Bottom strip: detail info operator --}}
        <div style="padding:0.875rem 1.5rem;display:flex;align-items:center;gap:0;flex-wrap:wrap;">

            {{-- NIP --}}
            <div
                style="display:flex;align-items:center;gap:0.5rem;padding-right:1.5rem;margin-right:1.5rem;border-right:1px solid rgba(255,255,255,0.1);">
                <svg style="width:0.875rem;height:0.875rem;color:rgba(212,175,55,0.7);flex-shrink:0;" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
                <div>
                    <p
                        style="font-size:0.5625rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.35);margin:0;">
                        NIP</p>
                    <p
                        style="font-size:0.75rem;font-weight:600;color:rgba(255,255,255,0.75);margin:0;letter-spacing:0.02em;">
                        {{ $user->nip }}</p>
                </div>
            </div>

            {{-- Bidang --}}
            <div
                style="display:flex;align-items:center;gap:0.5rem;padding-right:1.5rem;margin-right:1.5rem;border-right:1px solid rgba(255,255,255,0.1);">
                <svg style="width:0.875rem;height:0.875rem;color:rgba(212,175,55,0.7);flex-shrink:0;" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <div>
                    <p
                        style="font-size:0.5625rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.35);margin:0;">
                        Bidang</p>
                    <p
                        style="font-size:0.75rem;font-weight:600;color:rgba(255,255,255,0.75);margin:0;text-transform:capitalize;">
                        {{ $user->bidang ?? '-' }}</p>
                </div>
            </div>

            {{-- Jenis Layanan --}}
            <div
                style="display:flex;align-items:center;gap:0.5rem;padding-right:1.5rem;margin-right:1.5rem;border-right:1px solid rgba(255,255,255,0.1);">
                <svg style="width:0.875rem;height:0.875rem;color:rgba(212,175,55,0.7);flex-shrink:0;" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <div>
                    <p
                        style="font-size:0.5625rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.35);margin:0;">
                        Layanan</p>
                    <p
                        style="font-size:0.75rem;font-weight:600;color:rgba(255,255,255,0.75);margin:0;text-transform:capitalize;">
                        {{ match ($user->jenis_layanan ?? '') {
                            'paspor' => 'Paspor',
                            'izin_tinggal' => 'Izin Tinggal',
                            'keduanya' => 'Paspor & Izin Tinggal',
                            default => $user->jenis_layanan ?? '-',
                        } }}
                    </p>
                </div>
            </div>

            {{-- Tanggal Hari Ini --}}
            <div style="display:flex;align-items:center;gap:0.5rem;margin-left:auto;">
                <svg style="width:0.875rem;height:0.875rem;color:rgba(212,175,55,0.7);flex-shrink:0;" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div>
                    <p
                        style="font-size:0.5625rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.35);margin:0;">
                        Hari Ini</p>
                    <p style="font-size:0.75rem;font-weight:600;color:rgba(212,175,55,0.85);margin:0;">
                        {{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         STATS CARDS — 3 kartu ringkasan
    ══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-3 gap-4">
        @foreach ([['label' => 'Total Paspor', 'value' => formatAngka($totalPaspor), 'sub' => 'semua waktu', 'bg' => '#eff6ff', 'border' => '#bfdbfe', 'color' => '#1e3a8a', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'], ['label' => 'Bulan Ini', 'value' => formatAngka($totalBulanIni), 'sub' => now()->translatedFormat('F Y'), 'bg' => '#fffbeb', 'border' => '#fde68a', 'color' => '#d97706', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'], ['label' => 'Hari Ini', 'value' => formatAngka($totalHariIni), 'sub' => today()->translatedFormat('d F Y'), 'bg' => '#f0fdf4', 'border' => '#bbf7d0', 'color' => '#16a34a', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z']] as $stat)
            <div
                style="background:{{ $stat['bg'] }};border:1px solid {{ $stat['border'] }};border-radius:0.875rem;padding:1.125rem 1.25rem;display:flex;align-items:center;gap:1rem;">
                <div
                    style="width:2.75rem;height:2.75rem;border-radius:0.75rem;background:white;border:1px solid {{ $stat['border'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 8px {{ $stat['border'] }}80;">
                    <svg style="width:1.125rem;height:1.125rem;color:{{ $stat['color'] }};" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                    </svg>
                </div>
                <div style="min-width:0;">
                    <p
                        style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:{{ $stat['color'] }};opacity:0.65;margin:0 0 0.25rem;">
                        {{ $stat['label'] }}</p>
                    <p
                        style="font-size:1.625rem;font-weight:900;color:{{ $stat['color'] }};margin:0;line-height:1;letter-spacing:-0.03em;">
                        {{ $stat['value'] }}</p>
                    <p style="font-size:0.5625rem;color:{{ $stat['color'] }};opacity:0.45;margin:0.3rem 0 0;">
                        {{ $stat['sub'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════
         PER LOKASI — Tabel compact
    ══════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">

        {{-- Header tabel --}}
        <div
            style="padding:0.875rem 1.25rem;background:linear-gradient(135deg,#1e3a8a,#1a3270);display:flex;align-items:center;gap:0.625rem;">
            <div
                style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                <svg style="width:0.875rem;height:0.875rem;color:#d4af37;" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p style="font-size:0.8125rem;font-weight:700;color:white;margin:0;">Per Lokasi Layanan</p>
            <span
                style="margin-left:auto;font-size:0.625rem;font-weight:600;color:rgba(255,255,255,0.45);background:rgba(255,255,255,0.1);padding:0.25rem 0.625rem;border-radius:0.375rem;">
                {{ count($perLokasi) }} lokasi
            </span>
        </div>

        {{-- Tabel --}}
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                        <th
                            style="padding:0.625rem 1.25rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;">
                            Lokasi</th>
                        <th
                            style="padding:0.625rem 1rem;text-align:right;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;">
                            Total</th>
                        <th
                            style="padding:0.625rem 1rem;text-align:right;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;">
                            Bulan Ini</th>
                        <th
                            style="padding:0.625rem 1.25rem 0.625rem 0.75rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;min-width:8rem;">
                            Proporsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $maxTotal = $perLokasi->max('total') ?: 1; @endphp
                    @foreach ($perLokasi as $i => $lok)
                        <tr style="border-bottom:1px solid {{ $loop->last ? 'transparent' : '#f1f5f9' }};background:{{ $i % 2 === 0 ? 'white' : '#fafbfc' }};transition:background 0.15s;"
                            onmouseover="this.style.background='#f0f5ff'"
                            onmouseout="this.style.background='{{ $i % 2 === 0 ? 'white' : '#fafbfc' }}'">
                            {{-- Lokasi --}}
                            <td style="padding:0.75rem 1.25rem;">
                                <div style="display:flex;align-items:center;gap:0.625rem;">
                                    <div
                                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <svg style="width:0.75rem;height:0.75rem;color:#1e3a8a;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <span
                                        style="font-size:0.8125rem;font-weight:600;color:#1e293b;">{{ $lok['nama'] }}</span>
                                </div>
                            </td>
                            {{-- Total --}}
                            <td style="padding:0.75rem 1rem;text-align:right;">
                                <span
                                    style="font-size:0.875rem;font-weight:800;color:#1e3a8a;">{{ number_format($lok['total']) }}</span>
                            </td>
                            {{-- Bulan Ini --}}
                            <td style="padding:0.75rem 1rem;text-align:right;">
                                <span
                                    style="font-size:0.8125rem;font-weight:600;color:#d97706;background:#fffbeb;padding:0.1875rem 0.5rem;border-radius:0.375rem;border:1px solid #fde68a;">
                                    {{ number_format($lok['bulan_ini']) }}
                                </span>
                            </td>
                            {{-- Progress bar --}}
                            <td style="padding:0.75rem 1.25rem 0.75rem 0.75rem;">
                                @php $pct = $maxTotal > 0 ? round($lok['total'] / $maxTotal * 100) : 0; @endphp
                                <div style="display:flex;align-items:center;gap:0.5rem;">
                                    <div
                                        style="flex:1;height:5px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                                        <div
                                            style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,#1e3a8a,#3b5fc4);border-radius:9999px;transition:width 0.4s ease;">
                                        </div>
                                    </div>
                                    <span
                                        style="font-size:0.625rem;font-weight:600;color:#94a3b8;min-width:2.25rem;text-align:right;">{{ $pct }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- Footer total --}}
                <tfoot>
                    <tr style="background:#f8fafc;border-top:2px solid #e2e8f0;">
                        <td style="padding:0.75rem 1.25rem;">
                            <span style="font-size:0.75rem;font-weight:700;color:#475569;">Total Semua Lokasi</span>
                        </td>
                        <td style="padding:0.75rem 1rem;text-align:right;">
                            <span
                                style="font-size:0.875rem;font-weight:900;color:#1e3a8a;">{{ number_format($perLokasi->sum('total')) }}</span>
                        </td>
                        <td style="padding:0.75rem 1rem;text-align:right;">
                            <span
                                style="font-size:0.8125rem;font-weight:700;color:#d97706;">{{ number_format($perLokasi->sum('bulan_ini')) }}</span>
                        </td>
                        <td style="padding:0.75rem 1.25rem 0.75rem 0.75rem;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         CHART + JENIS LAYANAN
    ══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Chart Tren --}}
        <div class="lg:col-span-2 bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">
            {{-- Header --}}
            <div
                style="padding:0.875rem 1.25rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;border-bottom:1px solid #f1f5f9;background:linear-gradient(135deg,#1e3a8a,#1a3270);">
                <div style="display:flex;align-items:center;gap:0.75rem;">
                    <div
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                        <svg style="width:0.9375rem;height:0.9375rem;color:#d4af37;" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:0.8125rem;font-weight:700;color:white;margin:0;line-height:1.2;">Tren
                            Paspor Per Bulan</p>
                        <p style="font-size:0.625rem;color:rgba(255,255,255,0.45);margin:0.125rem 0 0;">Jumlah layanan
                            paspor yang diinput</p>
                    </div>
                </div>
                {{-- Filter range --}}
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <input type="date" wire:model.live="chartDari"
                        style="padding:0.375rem 0.625rem;border-radius:0.5rem;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.1);font-size:0.6875rem;outline:none;color:white;color-scheme:dark;font-family:inherit;"
                        onfocus="this.style.borderColor='#d4af37';this.style.background='rgba(212,175,55,0.15)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.2)';this.style.background='rgba(255,255,255,0.1)'">
                    <svg style="width:0.875rem;height:0.875rem;color:rgba(255,255,255,0.3);flex-shrink:0;"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                    <input type="date" wire:model.live="chartSampai"
                        style="padding:0.375rem 0.625rem;border-radius:0.5rem;border:1px solid rgba(255,255,255,0.2);background:rgba(255,255,255,0.1);font-size:0.6875rem;outline:none;color:white;color-scheme:dark;font-family:inherit;"
                        onfocus="this.style.borderColor='#d4af37';this.style.background='rgba(212,175,55,0.15)'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.2)';this.style.background='rgba(255,255,255,0.1)'">
                </div>
            </div>
            {{-- Canvas --}}
            <div style="padding:1.25rem 1.25rem 1rem;">
                <canvas id="pasporChart" height="115"></canvas>
            </div>
        </div>

        {{-- Jenis Layanan --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">
            {{-- Header --}}
            <div
                style="padding:0.875rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.625rem;background:linear-gradient(135deg,#1e3a8a,#1a3270);">
                <div
                    style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                    <svg style="width:0.875rem;height:0.875rem;color:#d4af37;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p style="font-size:0.8125rem;font-weight:700;color:white;margin:0;">Jenis Layanan</p>
            </div>
            {{-- List --}}
            <div style="padding:0.5rem 0;">
                @php $totalAll = $perJenis->sum('total'); @endphp
                @foreach ($perJenis as $j)
                    @php $pct = $totalAll > 0 ? round($j['total'] / $totalAll * 100) : 0; @endphp
                    <div style="padding:0.75rem 1.25rem;border-bottom:1px solid #f8fafc;"
                        onmouseover="this.style.background='#f8fafc'"
                        onmouseout="this.style.background='transparent'">
                        <div
                            style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.4375rem;">
                            <p
                                style="font-size:0.75rem;font-weight:600;color:#374151;margin:0;flex:1;padding-right:0.5rem;">
                                {{ $j['nama'] }}</p>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <span
                                    style="font-size:0.8125rem;font-weight:800;color:#1e3a8a;">{{ number_format($j['total']) }}</span>
                                <span
                                    style="font-size:0.5625rem;font-weight:600;color:white;background:#1e3a8a;padding:0.125rem 0.4375rem;border-radius:9999px;min-width:2rem;text-align:center;">{{ $pct }}%</span>
                            </div>
                        </div>
                        <div style="height:5px;background:#f1f5f9;border-radius:9999px;overflow:hidden;">
                            <div
                                style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,#1e3a8a,#3b5fc4);border-radius:9999px;">
                            </div>
                        </div>
                        <p style="font-size:0.5625rem;color:#94a3b8;margin:0.3rem 0 0;">
                            {{ formatAngka($j['bulan_ini']) }} bulan ini</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            let chart = null;

            function buildChart(labels, data) {
                const canvas = document.getElementById('pasporChart');
                if (!canvas) return;
                if (chart) chart.destroy();

                const ctx = canvas.getContext('2d');

                // Gradient area fill — navy ke transparan, cocok di background putih
                const areaGradient = ctx.createLinearGradient(0, 0, 0, canvas.offsetHeight || 220);
                areaGradient.addColorStop(0, 'rgba(30,58,138,0.18)');
                areaGradient.addColorStop(0.5, 'rgba(30,58,138,0.06)');
                areaGradient.addColorStop(1, 'rgba(30,58,138,0)');

                chart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Paspor',
                            data,
                            fill: true,
                            backgroundColor: areaGradient,
                            borderColor: '#1e3a8a',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#1e3a8a',
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: '#d4af37',
                            pointHoverBorderColor: 'white',
                            pointHoverBorderWidth: 2.5,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: {
                            duration: 700,
                            easing: 'easeInOutQuart',
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleColor: 'rgba(255,255,255,0.5)',
                                bodyColor: '#d4af37',
                                borderColor: 'rgba(30,58,138,0.4)',
                                borderWidth: 1,
                                padding: {
                                    top: 10,
                                    bottom: 10,
                                    left: 14,
                                    right: 14
                                },
                                cornerRadius: 10,
                                displayColors: false,
                                titleFont: {
                                    size: 10,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 13,
                                    weight: '800'
                                },
                                callbacks: {
                                    title: items => items[0].label,
                                    label: item => item.parsed.y.toLocaleString('id-ID') + ' paspor',
                                }
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.05)',
                                    drawBorder: false,
                                },
                                ticks: {
                                    font: {
                                        size: 10
                                    },
                                    color: '#94a3b8',
                                    padding: 8,
                                    callback: v => v.toLocaleString('id-ID'),
                                },
                                border: {
                                    display: false
                                },
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 10
                                    },
                                    color: '#94a3b8',
                                    padding: 6,
                                },
                                border: {
                                    display: false
                                },
                            }
                        }
                    }
                });
            }

            buildChart({!! $chartLabels !!}, {!! $chartData !!});

            Livewire.on('chartUpdated', ({
                labels,
                data
            }) => {
                buildChart(labels, data);
            });
        });
    </script>
@endpush
