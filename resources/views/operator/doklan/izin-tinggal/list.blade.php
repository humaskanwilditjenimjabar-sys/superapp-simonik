<div class="space-y-5">

    {{-- Header --}}
    <div class="rounded-2xl p-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        style="background:#1E3A8A;">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
                style="background:rgba(255,255,255,0.15);">
                <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-white">Layanan Izin Tinggal</p>
                <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">
                    {{ auth()->user()->kanim?->nama_kanim ?? 'Kantor Imigrasi' }} ·
                    {{ today()->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
        <a href="{{ route('operator.doklan.izin-tinggal.input') }}"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold w-full sm:w-auto shrink-0"
            style="background:#D4AF37;color:#1E3A8A;" onmouseover="this.style.opacity='0.9'"
            onmouseout="this.style.opacity='1'">
            <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Data
        </a>
    </div>

    {{-- Flash --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl"
            style="background:#F0FDF4;border:1px solid #BBF7D0;">
            <div class="flex items-center gap-3">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="#16a34a" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-semibold" style="color:#16a34a;">{{ session('success') }}</p>
            </div>
            <button @click="show = false" style="color:#16a34a;background:none;border:none;cursor:pointer;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0.75rem;">
        {{-- Total Inputan --}}
        <button wire:click="setFilterCard('')"
            style="background:{{ $filterCard === '' ? '#1E3A8A' : 'white' }};border:{{ $filterCard === '' ? '2px solid #1E3A8A' : '1px solid #E2E8F0' }};border-radius:1rem;padding:1.125rem 1.25rem;text-align:left;cursor:pointer;transition:all 0.15s;width:100%;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.625rem;">
                <p
                    style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:{{ $filterCard === '' ? 'rgba(255,255,255,0.6)' : '#94A3B8' }};margin:0;">
                    Total Inputan</p>
                <div
                    style="width:2rem;height:2rem;border-radius:0.5rem;background:{{ $filterCard === '' ? 'rgba(255,255,255,0.15)' : '#EFF6FF' }};display:flex;align-items:center;justify-content:center;">
                    <svg style="width:1rem;height:1rem;" fill="none"
                        stroke="{{ $filterCard === '' ? 'white' : '#1E3A8A' }}" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p
                style="font-size:2rem;font-weight:900;color:{{ $filterCard === '' ? 'white' : '#1E3A8A' }};margin:0;line-height:1;letter-spacing:-0.03em;">
                {{ number_format($totalInputan) }}</p>
            <p
                style="font-size:0.6875rem;color:{{ $filterCard === '' ? 'rgba(255,255,255,0.5)' : '#94A3B8' }};margin:0.375rem 0 0;">
                semua riwayat</p>
        </button>

        {{-- ITK --}}
        <button wire:click="setFilterCard('itk')"
            style="background:{{ $filterCard === 'itk' ? '#7C3AED' : 'white' }};border:{{ $filterCard === 'itk' ? '2px solid #7C3AED' : '1px solid #E2E8F0' }};border-radius:1rem;padding:1.125rem 1.25rem;text-align:left;cursor:pointer;transition:all 0.15s;width:100%;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.625rem;">
                <p
                    style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:{{ $filterCard === 'itk' ? 'rgba(255,255,255,0.6)' : '#94A3B8' }};margin:0;">
                    Pemegang ITK</p>
                <div
                    style="width:2rem;height:2rem;border-radius:0.5rem;background:{{ $filterCard === 'itk' ? 'rgba(255,255,255,0.15)' : '#F5F3FF' }};display:flex;align-items:center;justify-content:center;">
                    <svg style="width:1rem;height:1rem;" fill="none"
                        stroke="{{ $filterCard === 'itk' ? 'white' : '#7C3AED' }}" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </div>
            </div>
            <p
                style="font-size:2rem;font-weight:900;color:{{ $filterCard === 'itk' ? 'white' : '#7C3AED' }};margin:0;line-height:1;letter-spacing:-0.03em;">
                {{ number_format($totalITK) }}</p>
            <p
                style="font-size:0.6875rem;color:{{ $filterCard === 'itk' ? 'rgba(255,255,255,0.5)' : '#94A3B8' }};margin:0.375rem 0 0;">
                izin tinggal kunjungan</p>
        </button>

        {{-- ITAS --}}
        <button wire:click="setFilterCard('itas')"
            style="background:{{ $filterCard === 'itas' ? '#0369A1' : 'white' }};border:{{ $filterCard === 'itas' ? '2px solid #0369A1' : '1px solid #E2E8F0' }};border-radius:1rem;padding:1.125rem 1.25rem;text-align:left;cursor:pointer;transition:all 0.15s;width:100%;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.625rem;">
                <p
                    style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:{{ $filterCard === 'itas' ? 'rgba(255,255,255,0.6)' : '#94A3B8' }};margin:0;">
                    Pemegang ITAS</p>
                <div
                    style="width:2rem;height:2rem;border-radius:0.5rem;background:{{ $filterCard === 'itas' ? 'rgba(255,255,255,0.15)' : '#E0F2FE' }};display:flex;align-items:center;justify-content:center;">
                    <svg style="width:1rem;height:1rem;" fill="none"
                        stroke="{{ $filterCard === 'itas' ? 'white' : '#0369A1' }}" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
            </div>
            <p
                style="font-size:2rem;font-weight:900;color:{{ $filterCard === 'itas' ? 'white' : '#0369A1' }};margin:0;line-height:1;letter-spacing:-0.03em;">
                {{ number_format($totalITAS) }}</p>
            <p
                style="font-size:0.6875rem;color:{{ $filterCard === 'itas' ? 'rgba(255,255,255,0.5)' : '#94A3B8' }};margin:0.375rem 0 0;">
                izin tinggal terbatas</p>
        </button>

        {{-- ITAP --}}
        <button wire:click="setFilterCard('itap')"
            style="background:{{ $filterCard === 'itap' ? '#16a34a' : 'white' }};border:{{ $filterCard === 'itap' ? '2px solid #16a34a' : '1px solid #E2E8F0' }};border-radius:1rem;padding:1.125rem 1.25rem;text-align:left;cursor:pointer;transition:all 0.15s;width:100%;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.625rem;">
                <p
                    style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:{{ $filterCard === 'itap' ? 'rgba(255,255,255,0.6)' : '#94A3B8' }};margin:0;">
                    Pemegang ITAP</p>
                <div
                    style="width:2rem;height:2rem;border-radius:0.5rem;background:{{ $filterCard === 'itap' ? 'rgba(255,255,255,0.15)' : '#F0FDF4' }};display:flex;align-items:center;justify-content:center;">
                    <svg style="width:1rem;height:1rem;" fill="none"
                        stroke="{{ $filterCard === 'itap' ? 'white' : '#16a34a' }}" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p
                style="font-size:2rem;font-weight:900;color:{{ $filterCard === 'itap' ? 'white' : '#16a34a' }};margin:0;line-height:1;letter-spacing:-0.03em;">
                {{ number_format($totalITAP) }}</p>
            <p
                style="font-size:0.6875rem;color:{{ $filterCard === 'itap' ? 'rgba(255,255,255,0.5)' : '#94A3B8' }};margin:0.375rem 0 0;">
                izin tinggal tetap</p>
        </button>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;" x-data="{ filterOpen: false }">
        <div class="flex items-center justify-between px-4 py-3 cursor-pointer"
            style="background:#F8FAFC;border-bottom:1px solid #F1F5F9;" @click="filterOpen = !filterOpen">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                <span class="text-xs font-semibold" style="color:#1E3A8A;">Filter & Pencarian</span>
                @if (
                    $search ||
                        $filterJenis ||
                        $filterNegara ||
                        $filterLokasi ||
                        $filterDariInput ||
                        $filterSampaiInput ||
                        $filterDariExpire ||
                        $filterSampaiExpire)
                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                        style="background:#1E3A8A;color:white;">Aktif</span>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2" @click.stop>
                    <span class="text-xs" style="color:#94A3B8;">Tampilkan</span>
                    <select wire:model.live="perPage"
                        class="pl-3 pr-7 py-1.5 rounded-lg text-xs font-bold border outline-none cursor-pointer appearance-none"
                        style="border-color:#E2E8F0;color:#1E3A8A;background:#EFF6FF;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-xs" style="color:#94A3B8;">data</span>
                </div>
                @if (
                    $search ||
                        $filterJenis ||
                        $filterNegara ||
                        $filterLokasi ||
                        $filterDariInput ||
                        $filterSampaiInput ||
                        $filterDariExpire ||
                        $filterSampaiExpire)
                    <button wire:click="resetFilter" @click.stop
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold cursor-pointer"
                        style="background:#FEF2F2;color:#DC2626;border:1px solid #FECACA;">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset
                    </button>
                @endif
                <svg class="w-4 h-4 transition-transform duration-200" :class="filterOpen ? 'rotate-180' : ''"
                    fill="none" stroke="#94A3B8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
        <div x-show="filterOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2">
            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                {{-- Cari WNA --}}
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Cari WNA</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="#94A3B8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Nama WNA atau nomor paspor..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>
                {{-- Jenis Layanan --}}
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Jenis Layanan</label>
                    <select wire:model.live="filterJenis"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;background:white;">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisList as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Kewarganegaraan --}}
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Kewarganegaraan</label>
                    <select wire:model.live="filterNegara"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;background:white;">
                        <option value="">Semua Kewarganegaraan</option>
                        @foreach ($negaraList as $n)
                            <option value="{{ $n->id }}">{{ $n->nama_negara }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Lokasi Layanan --}}
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Lokasi Layanan</label>
                    <select wire:model.live="filterLokasi"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;background:white;">
                        <option value="">Semua Lokasi</option>
                        @foreach ($lokasiList as $l)
                            <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Tgl Penerbitan --}}
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Tgl. Penerbitan</label>
                    <div style="display:flex;align-items:center;gap:0.375rem;">
                        <input type="date" wire:model.live="filterDariInput"
                            class="flex-1 min-w-0 px-2.5 py-2 rounded-xl text-xs border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        <span style="font-size:0.625rem;color:#94A3B8;flex-shrink:0;">—</span>
                        <input type="date" wire:model.live="filterSampaiInput"
                            class="flex-1 min-w-0 px-2.5 py-2 rounded-xl text-xs border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>
                {{-- Tgl Expire --}}
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Tgl. Expire</label>
                    <div style="display:flex;align-items:center;gap:0.375rem;">
                        <input type="date" wire:model.live="filterDariExpire"
                            class="flex-1 min-w-0 px-2.5 py-2 rounded-xl text-xs border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        <span style="font-size:0.625rem;color:#94A3B8;flex-shrink:0;">—</span>
                        <input type="date" wire:model.live="filterSampaiExpire"
                            class="flex-1 min-w-0 px-2.5 py-2 rounded-xl text-xs border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;">
        <div wire:loading.flex class="w-full items-center justify-center gap-2 py-2.5"
            style="background:#EFF6FF;border-bottom:1px solid #DBEAFE;">
            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24" style="color:#1E3A8A;">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <span class="text-xs font-medium" style="color:#1E3A8A;">Memuat data...</span>
        </div>
        <div class="overflow-x-auto" wire:loading.class="opacity-50">
            <table class="w-full">
                <thead>
                    <tr style="background:#1E3A8A;">
                        <th class="px-4 py-3 text-left text-xs font-bold text-white w-10">No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white">Nama WNA</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white">Jenis Layanan</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white">Permit Number</th>
                        <th wire:click="sort('tanggal_penerbitan')"
                            class="px-4 py-3 text-left text-xs font-bold text-white cursor-pointer">
                            <span style="display:flex;align-items:center;gap:0.375rem;">Tgl. Penerbitan
                                @if ($sortColumn === 'tanggal_penerbitan')
                                    <span
                                    style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                        class="opacity-30">↕</span>
                                @endif
                            </span>
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $i => $item)
                        @php
                            $sisaHari = $item->sisa_hari;
                            $isEarly = $item->isEarlyWarning();
                            $isExpired = $sisaHari !== null && $sisaHari < 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2.5 text-xs" style="color:#94A3B8;">{{ $data->firstItem() + $i }}</td>
                            <td class="px-4 py-2.5">
                                <p class="text-xs font-semibold" style="color:#1E293B;">
                                    {{ $item->wna?->nama_lengkap ?? '-' }}</p>
                                <p class="text-xs" style="color:#94a3b8;">
                                    {{ $item->wna?->kewarganegaraan?->nama_negara ?? '-' }} ·
                                    {{ $item->wna?->nomor_paspor ?? '-' }}
                                </p>
                            </td>
                            <td class="px-4 py-2.5">
                                @php
                                    $namaJenis = $item->jenisLayanan?->nama_layanan ?? '-';
                                    $badgeBg = '#EFF6FF';
                                    $badgeColor = '#1E3A8A';
                                    if (str_contains($namaJenis, 'ITK')) {
                                        $badgeBg = '#F5F3FF';
                                        $badgeColor = '#7C3AED';
                                    } elseif (str_contains($namaJenis, 'ITAS')) {
                                        $badgeBg = '#E0F2FE';
                                        $badgeColor = '#0369A1';
                                    } elseif (str_contains($namaJenis, 'ITAP')) {
                                        $badgeBg = '#F0FDF4';
                                        $badgeColor = '#16a34a';
                                    }
                                @endphp
                                <span
                                    style="display:inline-block;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.625rem;font-weight:600;background:{{ $badgeBg }};color:{{ $badgeColor }};">
                                    {{ $namaJenis }}
                                </span>
                            </td>
                            <td class="px-4 py-2.5">
                                <p class="text-xs font-mono font-semibold" style="color:#374151;">
                                    {{ $item->permit_number ?? '-' }}</p>
                                <p class="text-xs" style="color:#94a3b8;">
                                    {{ $item->lokasiLayanan?->nama_lokasi ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-2.5">
                                <p class="text-xs font-medium" style="color:#374151;">
                                    {{ $item->tanggal_penerbitan->translatedFormat('d M Y') }}</p>
                                @if ($item->stay_permit_expire)
                                    <div class="flex items-center gap-1 mt-0.5">
                                        <div
                                            style="width:0.375rem;height:0.375rem;border-radius:9999px;background:{{ $isExpired ? '#dc2626' : ($isEarly ? '#d97706' : '#16a34a') }};flex-shrink:0;">
                                        </div>
                                        <p class="text-xs"
                                            style="color:{{ $isExpired ? '#dc2626' : ($isEarly ? '#d97706' : '#94a3b8') }};">
                                            Expire: {{ $item->stay_permit_expire->translatedFormat('d M Y') }}
                                            @if ($isExpired)
                                                (Expired)
                                            @elseif($isEarly)
                                                ({{ $sisaHari }} hari)
                                            @endif
                                        </p>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('operator.doklan.izin-tinggal.detail', $item->id) }}"
                                        title="Lihat Detail"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg transition-all"
                                        style="background:#EFF6FF;color:#1E3A8A;"
                                        onmouseover="this.style.background='#1e3a8a';this.querySelector('svg').style.color='white'"
                                        onmouseout="this.style.background='#EFF6FF';this.querySelector('svg').style.color='#1E3A8A'">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @if ($item->status === 'disubmit')
                                        <a href="{{ route('operator.doklan.izin-tinggal.edit', $item->id) }}"
                                            title="Edit"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg transition-all"
                                            style="background:#fffbeb;color:#d97706;"
                                            onmouseover="this.style.background='#d97706';this.querySelector('svg').style.color='white'"
                                            onmouseout="this.style.background='#fffbeb';this.querySelector('svg').style.color='#d97706'">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                                        style="background:#F8FAFC;border:1px solid #E2E8F0;">
                                        <svg class="w-7 h-7" fill="none" stroke="#CBD5E1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-medium" style="color:#94A3B8;">Belum ada data izin tinggal
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-between px-5 py-3.5 flex-wrap gap-3"
            style="border-top:1px solid #F1F5F9;background:#fafafa;">
            <span class="text-xs font-medium" style="color:#64748b;">{{ $data->total() }} data ditemukan</span>
            @if ($data->hasPages())
                <div class="flex items-center gap-1.5">
                    @if ($data->onFirstPage())
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg"
                            style="background:#F8FAFC;color:#CBD5E1;border:1px solid #E2E8F0;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    @else
                        <button wire:click="previousPage"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all"
                            style="background:white;color:#1E3A8A;border:1px solid #E2E8F0;"
                            onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='white'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                    @endif
                    @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                        @if ($page == $data->currentPage())
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-bold text-white"
                                style="background:#1E3A8A;border:1px solid #1E3A8A;">{{ $page }}</span>
                        @elseif(abs($page - $data->currentPage()) <= 2)
                            <button wire:click="gotoPage({{ $page }})"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-medium transition-all"
                                style="background:white;color:#475569;border:1px solid #E2E8F0;"
                                onmouseover="this.style.background='#EFF6FF';this.style.color='#1E3A8A'"
                                onmouseout="this.style.background='white';this.style.color='#475569'">{{ $page }}</button>
                        @elseif(abs($page - $data->currentPage()) == 3)
                            <span class="inline-flex items-center justify-center w-8 h-8 text-xs"
                                style="color:#94A3B8;">…</span>
                        @endif
                    @endforeach
                    @if ($data->hasMorePages())
                        <button wire:click="nextPage"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all"
                            style="background:white;color:#1E3A8A;border:1px solid #E2E8F0;"
                            onmouseover="this.style.background='#EFF6FF'" onmouseout="this.style.background='white'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @else
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg"
                            style="background:#F8FAFC;color:#CBD5E1;border:1px solid #E2E8F0;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Modal View Detail --}}
    @if ($showView && $viewData)
        <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);padding:1rem;"
            wire:click.self="closeView">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:34rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;max-height:90vh;display:flex;flex-direction:column;">
                <div
                    style="background:linear-gradient(135deg,#1E3A8A,#1a3270);padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
                    <div style="display:flex;align-items:center;gap:0.625rem;">
                        <div
                            style="width:2rem;height:2rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:1rem;height:1rem;" fill="none" stroke="white" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">Detail Layanan Izin
                                Tinggal</p>
                            <p style="font-size:0.625rem;color:rgba(255,255,255,0.5);margin:0.1rem 0 0;">ID
                                #{{ $viewData->id }}</p>
                        </div>
                    </div>
                    <button wire:click="closeView"
                        style="background:rgba(255,255,255,0.1);border:none;cursor:pointer;width:1.75rem;height:1.75rem;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:white;">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div style="padding:1.25rem;overflow-y:auto;display:flex;flex-direction:column;gap:0.875rem;">
                    <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:0.875rem;padding:1rem;">
                        <p
                            style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#1E3A8A;opacity:0.6;margin:0 0 0.375rem;">
                            Data WNA</p>
                        <p style="font-size:0.9375rem;font-weight:800;color:#1E3A8A;margin:0;">
                            {{ $viewData->wna?->nama_lengkap ?? '-' }}</p>
                        <p style="font-size:0.75rem;color:#3B82F6;margin:0.25rem 0 0;">
                            {{ $viewData->wna?->kewarganegaraan?->nama_negara ?? '-' }} · Paspor:
                            {{ $viewData->wna?->nomor_paspor ?? '-' }}
                        </p>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.625rem;">
                        @foreach ([['label' => 'Jenis Layanan', 'value' => $viewData->jenisLayanan?->nama_layanan ?? '-'], ['label' => 'Lokasi Layanan', 'value' => $viewData->lokasiLayanan?->nama_lokasi ?? '-'], ['label' => 'Tgl Penerbitan', 'value' => $viewData->tanggal_penerbitan->translatedFormat('d F Y')], ['label' => 'Stay Permit Expire', 'value' => $viewData->stay_permit_expire?->translatedFormat('d F Y') ?? '-'], ['label' => 'Permit Number', 'value' => $viewData->permit_number ?? '-'], ['label' => 'Status', 'value' => $viewData->status_label]] as $info)
                            <div style="background:#F8FAFC;border-radius:0.625rem;padding:0.75rem;">
                                <p
                                    style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                                    {{ $info['label'] }}</p>
                                <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                                    {{ $info['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                    @if ($viewData->keterangan)
                        <div
                            style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:0.75rem;padding:0.875rem;">
                            <p
                                style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                                Keterangan</p>
                            <p style="font-size:0.8125rem;color:#475569;margin:0;">{{ $viewData->keterangan }}</p>
                        </div>
                    @endif
                    @if ($viewData->catatan_verifikasi)
                        <div
                            style="background:#fffbeb;border:1px solid #fde68a;border-radius:0.75rem;padding:0.875rem;">
                            <p
                                style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#d97706;margin:0 0 0.25rem;">
                                Catatan Verifikasi</p>
                            <p style="font-size:0.8125rem;color:#92400e;margin:0;">{{ $viewData->catatan_verifikasi }}
                            </p>
                        </div>
                    @endif
                </div>
                <div
                    style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;flex-shrink:0;">
                    <button wire:click="closeView"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#1e3a8a;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Confirm Submit --}}
    @if ($showConfirmSubmit)
        <div
            style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);padding:1rem;">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:24rem;padding:1.5rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
                <p class="text-sm font-bold mb-2" style="color:#1E293B;">Submit untuk Verifikasi?</p>
                <p class="text-xs mb-5" style="color:#64748B;">Data akan dikirim ke Admin Kabid. Setelah disubmit
                    tidak bisa diedit.</p>
                <div class="flex gap-2 justify-end">
                    <button wire:click="cancelSubmit"
                        style="padding:0.5rem 1.25rem;border-radius:0.625rem;background:#f8fafc;color:#64748b;font-size:0.8125rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;">Batal</button>
                    <button wire:click="doSubmit"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#1e3a8a;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">Ya,
                        Submit</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Confirm Batal --}}
    @if ($showConfirmBatal)
        <div
            style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);padding:1rem;">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:24rem;padding:1.5rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
                <p class="text-sm font-bold mb-2" style="color:#1E293B;">Batal Submit?</p>
                <p class="text-xs mb-5" style="color:#64748B;">Data akan dikembalikan ke status Draft dan bisa diedit
                    kembali.</p>
                <div class="flex gap-2 justify-end">
                    <button wire:click="cancelBatal"
                        style="padding:0.5rem 1.25rem;border-radius:0.625rem;background:#f8fafc;color:#64748b;font-size:0.8125rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;">Tidak</button>
                    <button wire:click="doBatal"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#dc2626;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">Ya,
                        Batal Submit</button>
                </div>
            </div>
        </div>
    @endif

</div>
