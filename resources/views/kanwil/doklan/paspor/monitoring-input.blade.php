<div class="space-y-5">

    {{-- Header --}}
    <div class="rounded-2xl p-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        style="background:#1E3A8A;">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
                style="background:rgba(255,255,255,0.15);">
                <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-white">Monitoring Input Paspor</p>
                <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">
                    Pantau kepatuhan input data harian per Kanim
                </p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl p-4" style="border:1px solid #E2E8F0;">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            {{-- Kanim --}}
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#1E3A8A;">
                    Kantor Imigrasi <span style="color:#ef4444;">*</span>
                </label>
                <select wire:model.live="filterKanim" class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                    style="border-color:#E2E8F0;color:#1E293B;background:white;"
                    onfocus="this.style.borderColor='#1E3A8A'" onblur="this.style.borderColor='#E2E8F0'">
                    <option value="">— Pilih Kanim —</option>
                    @foreach ($kanims as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kanim }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Lokasi --}}
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#1E3A8A;">Lokasi Layanan</label>
                <select wire:model.live="filterLokasi" class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                    style="border-color:#E2E8F0;color:#1E293B;background:white;"
                    onfocus="this.style.borderColor='#1E3A8A'" onblur="this.style.borderColor='#E2E8F0'"
                    @disabled(!$filterKanim)>
                    <option value="">Semua Lokasi</option>
                    @foreach ($lokasiList as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Dari --}}
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#1E3A8A;">Dari Tanggal</label>
                <input type="date" wire:model.live="filterDari"
                    class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                    style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                    onblur="this.style.borderColor='#E2E8F0'">
            </div>
            {{-- Sampai --}}
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:#1E3A8A;">Sampai Tanggal</label>
                <div class="flex items-end gap-2">
                    <input type="date" wire:model.live="filterSampai"
                        class="flex-1 px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                        onblur="this.style.borderColor='#E2E8F0'">
                    @if (
                        $filterKanim ||
                            $filterLokasi ||
                            $filterDari !== now()->startOfMonth()->format('Y-m-d') ||
                            $filterSampai !== now()->format('Y-m-d'))
                        <button wire:click="resetFilter"
                            class="inline-flex items-center gap-1 px-3 py-2.5 rounded-xl text-xs font-semibold shrink-0"
                            style="background:#FEF2F2;color:#DC2626;border:1px solid #FECACA;">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (!$filterKanim)
        {{-- Placeholder --}}
        <div class="bg-white rounded-2xl p-12 text-center" style="border:1px solid #E2E8F0;">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                style="background:#EFF6FF;border:1px solid #BFDBFE;">
                <svg class="w-8 h-8" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <p class="text-sm font-semibold" style="color:#1E293B;">Pilih Kantor Imigrasi</p>
            <p class="text-xs mt-1" style="color:#94A3B8;">Pilih kanim dan range tanggal untuk melihat monitoring input
            </p>
        </div>
    @else
        {{-- Summary Cards --}}
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:0.75rem;">
            @foreach ([['label' => 'Hari dalam Range', 'value' => $totalHariRange, 'bg' => '#f8fafc', 'border' => '#e2e8f0', 'color' => '#475569'], ['label' => 'Hari Kerja', 'value' => $totalHariKerja, 'bg' => '#eff6ff', 'border' => '#bfdbfe', 'color' => '#1e3a8a'], ['label' => 'Sudah Input', 'value' => $totalSudahInput, 'bg' => '#f0fdf4', 'border' => '#bbf7d0', 'color' => '#16a34a'], ['label' => 'Belum Input', 'value' => $totalBelumInput, 'bg' => '#fef2f2', 'border' => '#fecaca', 'color' => '#dc2626'], ['label' => 'Total Paspor', 'value' => number_format($totalJumlah), 'bg' => '#fffbeb', 'border' => '#fde68a', 'color' => '#d97706']] as $s)
                <div
                    style="background:{{ $s['bg'] }};border:1px solid {{ $s['border'] }};border-radius:0.875rem;padding:1rem 1.125rem;">
                    <p
                        style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:{{ $s['color'] }};opacity:0.7;margin:0 0 0.375rem;">
                        {{ $s['label'] }}</p>
                    <p style="font-size:1.5rem;font-weight:900;color:{{ $s['color'] }};margin:0;line-height:1;">
                        {{ $s['value'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-4 flex-wrap px-1">
            <p class="text-xs font-semibold" style="color:#475569;">Keterangan:</p>
            @foreach ([['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'label' => 'Sudah input'], ['bg' => '#fef2f2', 'border' => '#fecaca', 'label' => 'Belum input (lewat)'], ['bg' => '#fffbeb', 'border' => '#fde68a', 'label' => 'Belum input (mendatang)'], ['bg' => '#f8fafc', 'border' => '#e2e8f0', 'label' => 'Hari libur / Minggu']] as $leg)
                <div class="flex items-center gap-1.5">
                    <div
                        style="width:1rem;height:1rem;border-radius:0.25rem;background:{{ $leg['bg'] }};border:1px solid {{ $leg['border'] }};">
                    </div>
                    <span class="text-xs" style="color:#475569;">{{ $leg['label'] }}</span>
                </div>
            @endforeach
            <div class="flex items-center gap-1.5">
                <div style="width:1rem;height:1rem;border-radius:0.25rem;background:#eff6ff;border:2px solid #1e3a8a;">
                </div>
                <span class="text-xs" style="color:#475569;">Hari ini</span>
            </div>
        </div>

        {{-- Grid Kalender --}}
        @if (count($kalender) > 0)
            <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;">
                <div class="px-4 py-3 flex items-center gap-2"
                    style="background:#F8FAFC;border-bottom:1px solid #F1F5F9;">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                    <p class="text-xs font-semibold" style="color:#1E3A8A;">
                        {{ $kanimInfo?->nama_kanim }}
                        @if ($filterLokasi && $lokasiList->firstWhere('id', $filterLokasi))
                            · {{ $lokasiList->firstWhere('id', $filterLokasi)?->nama_lokasi }}
                        @endif
                        · {{ \Carbon\Carbon::parse($filterDari)->translatedFormat('d M Y') }} –
                        {{ \Carbon\Carbon::parse($filterSampai)->translatedFormat('d M Y') }}
                    </p>
                </div>
                <div class="p-4">
                    <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:0.5rem;">
                        {{-- Header hari --}}
                        @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $h)
                            <div
                                style="text-align:center;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;padding:0.25rem 0;color:{{ $h === 'Min' ? '#dc2626' : '#94a3b8' }};">
                                {{ $h }}
                            </div>
                        @endforeach

                        {{-- Offset --}}
                        @php $firstDow = $kalender[0]['day_of_week'] ?? 0; @endphp
                        @for ($i = 0; $i < $firstDow; $i++)
                            <div></div>
                        @endfor

                        {{-- Cell --}}
                        @foreach ($kalender as $day)
                            @php
                                if ($day['is_libur']) {
                                    $bg = '#f8fafc';
                                    $border = '1px solid #e2e8f0';
                                    $textColor = '#cbd5e1';
                                } elseif ($day['sudah_input']) {
                                    $bg = '#f0fdf4';
                                    $border = '1px solid #bbf7d0';
                                    $textColor = '#16a34a';
                                } elseif ($day['is_past']) {
                                    $bg = '#fef2f2';
                                    $border = '1px solid #fecaca';
                                    $textColor = '#dc2626';
                                } else {
                                    $bg = '#fffbeb';
                                    $border = '1px solid #fde68a';
                                    $textColor = '#d97706';
                                }
                                if ($day['is_today']) {
                                    $border = '2px solid #1e3a8a';
                                }
                                $clickable = !$day['is_libur'];
                            @endphp
                            <div @if ($clickable) wire:click="openPopup('{{ $day['tanggal'] }}')" @endif
                                style="background:{{ $bg }};border:{{ $border }};border-radius:0.625rem;padding:0.5rem 0.25rem;text-align:center;min-height:3.75rem;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.125rem;{{ $clickable ? 'cursor:pointer;' : '' }}"
                                @if ($clickable) onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'" @endif>
                                <p
                                    style="font-size:0.75rem;font-weight:{{ $day['is_today'] ? '900' : '600' }};color:{{ $day['is_today'] ? '#1e3a8a' : $textColor }};margin:0;line-height:1;">
                                    {{ $day['label'] }}
                                </p>
                                <p style="font-size:0.5rem;color:{{ $textColor }};opacity:0.6;margin:0;">
                                    {{ $day['hari'] }}
                                </p>
                                @if ($day['sudah_input'])
                                    <div
                                        style="margin-top:0.25rem;background:#16a34a;color:white;border-radius:0.25rem;padding:1px 5px;font-size:0.5625rem;font-weight:700;line-height:1.4;">
                                        {{ number_format($day['total_jumlah']) }}
                                    </div>
                                @elseif($day['is_libur'])
                                    <p style="font-size:0.5rem;color:#cbd5e1;margin:0.125rem 0 0;">
                                        {{ $day['is_sunday'] ? 'Minggu' : 'Libur' }}</p>
                                @elseif($day['is_past'])
                                    <p style="font-size:0.5rem;color:#dc2626;opacity:0.7;margin:0.125rem 0 0;">Kosong
                                    </p>
                                @else
                                    <p style="font-size:0.5rem;color:#d97706;opacity:0.7;margin:0.125rem 0 0;">Belum
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl p-8 text-center" style="border:1px solid #E2E8F0;">
                <p class="text-sm" style="color:#94A3B8;">Masukkan range tanggal untuk melihat kalender</p>
            </div>
        @endif

    @endif

    {{-- Modal Popup Detail Tanggal --}}
    @if ($showPopup && $popupTanggal)
        <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);padding:1rem;"
            wire:click.self="closePopup">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:26rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;">
                {{-- Header popup --}}
                <div
                    style="background:{{ $popupSudahInput ? 'linear-gradient(135deg,#15803d,#166534)' : 'linear-gradient(135deg,#dc2626,#b91c1c)' }};padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:0.625rem;">
                        <div
                            style="width:2rem;height:2rem;border-radius:0.5rem;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:1rem;height:1rem;" fill="none" stroke="white" viewBox="0 0 24 24"
                                stroke-width="2">
                                @if ($popupSudahInput)
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                @endif
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">
                                {{ \Carbon\Carbon::parse($popupTanggal)->translatedFormat('l, d F Y') }}
                            </p>
                            <p style="font-size:0.625rem;color:rgba(255,255,255,0.6);margin:0.1rem 0 0;">
                                {{ $popupSudahInput ? 'Data sudah diinput' : 'Data belum diinput' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="closePopup"
                        style="background:rgba(255,255,255,0.15);border:none;cursor:pointer;width:1.75rem;height:1.75rem;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:white;">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body popup --}}
                <div style="padding:1.25rem;">
                    @if ($popupSudahInput)
                        {{-- Total --}}
                        <div
                            style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:0.75rem;padding:0.875rem 1rem;display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                            <span style="font-size:0.75rem;font-weight:600;color:#16a34a;">Total Paspor Hari Ini</span>
                            <span
                                style="font-size:1.25rem;font-weight:900;color:#16a34a;">{{ number_format($popupTotal) }}</span>
                        </div>

                        {{-- Detail per lokasi & jenis --}}
                        <p
                            style="font-size:0.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748b;margin:0 0 0.625rem;">
                            Detail Per Lokasi & Jenis</p>
                        <div style="display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach ($popupDetail as $detail)
                                <div
                                    style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:0.625rem;padding:0.75rem 1rem;display:flex;align-items:center;justify-content:space-between;">
                                    <div>
                                        <p style="font-size:0.75rem;font-weight:600;color:#1e293b;margin:0;">
                                            {{ $detail['jenis'] }}</p>
                                        <div style="display:flex;align-items:center;gap:0.375rem;margin-top:0.2rem;">
                                            <svg style="width:0.75rem;height:0.75rem;color:#94a3b8;" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <p style="font-size:0.625rem;color:#94a3b8;margin:0;">
                                                {{ $detail['lokasi'] }}</p>
                                        </div>
                                    </div>
                                    <span
                                        style="font-size:1rem;font-weight:800;color:#1e3a8a;">{{ number_format($detail['jumlah']) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Belum input --}}
                        <div style="text-align:center;padding:1.5rem 0;">
                            <div
                                style="width:3.5rem;height:3.5rem;border-radius:1rem;background:#fef2f2;border:1px solid #fecaca;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                                <svg style="width:1.75rem;height:1.75rem;color:#dc2626;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                            </div>
                            <p style="font-size:0.875rem;font-weight:600;color:#dc2626;margin:0;">Data Paspor Belum
                                Diinput</p>
                            <p style="font-size:0.75rem;color:#94a3b8;margin:0.375rem 0 0;">
                                Tidak ada data yang diinput untuk tanggal
                                ini{{ $filterLokasi ? ' pada lokasi yang dipilih' : '' }}.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div
                    style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;">
                    <button wire:click="closePopup"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#1e3a8a;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
