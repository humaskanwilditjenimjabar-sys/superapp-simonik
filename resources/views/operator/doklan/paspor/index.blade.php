<div class="space-y-5">

    {{-- Header Card --}}
    <div class="rounded-2xl p-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        style="background:#1E3A8A;">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
                style="background:rgba(255,255,255,0.15);">
                <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-white">Layanan Paspor</p>
                <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">
                    {{ auth()->user()->kanim?->nama_kanim ?? 'Kantor Imigrasi' }} ·
                    {{ today()->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
        {{-- @if (!$sudahInputHariIni || !$sudahInputKemarin) --}}
        @if (true)
            <button wire:click="openForm"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold w-full sm:w-auto shrink-0 cursor-pointer"
                style="background:#D4AF37;color:#1E3A8A;" onmouseover="this.style.opacity='0.9'"
                onmouseout="this.style.opacity='1'">
                <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </button>
        @else
            <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl"
                style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);">
                <svg class="w-4 h-4" fill="none" stroke="#d4af37" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm" style="color:rgba(255,255,255,0.8);">Data sudah lengkap</span>
            </div>
        @endif
    </div>

    {{-- Info Input Status --}}
    {{-- <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
        <div
            style="background:white;border-radius:0.75rem;border:1px solid #e2e8f0;padding:0.875rem 1.125rem;display:flex;align-items:center;gap:0.75rem;">
            @if ($sudahInputHariIni)
                <div
                    style="width:2rem;height:2rem;border-radius:0.5rem;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:1rem;height:1rem;color:#16a34a;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p style="font-size:0.75rem;font-weight:600;color:#16a34a;margin:0;">Hari ini sudah diinput</p>
                    <p style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;">
                        {{ today()->translatedFormat('d F Y') }}</p>
                </div>
            @else
                <div
                    style="width:2rem;height:2rem;border-radius:0.5rem;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:1rem;height:1rem;color:#dc2626;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size:0.75rem;font-weight:600;color:#dc2626;margin:0;">Hari ini belum diinput</p>
                    <p style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;">
                        {{ today()->translatedFormat('d F Y') }}</p>
                </div>
            @endif
        </div>
        <div
            style="background:white;border-radius:0.75rem;border:1px solid #e2e8f0;padding:0.875rem 1.125rem;display:flex;align-items:center;gap:0.75rem;">
            @if ($sudahInputKemarin)
                <div
                    style="width:2rem;height:2rem;border-radius:0.5rem;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:1rem;height:1rem;color:#16a34a;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p style="font-size:0.75rem;font-weight:600;color:#16a34a;margin:0;">Kemarin sudah diinput</p>
                    <p style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;">
                        {{ today()->subDay()->translatedFormat('d F Y') }}</p>
                </div>
            @else
                <div
                    style="width:2rem;height:2rem;border-radius:0.5rem;background:#fffbeb;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:1rem;height:1rem;color:#d97706;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size:0.75rem;font-weight:600;color:#d97706;margin:0;">Kemarin belum diinput</p>
                    <p style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;">
                        {{ today()->subDay()->translatedFormat('d F Y') }}</p>
                </div>
            @endif
        </div>
    </div> --}}

    {{-- Lokasi Filter Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        <button wire:click="setFilterLokasi(null)"
            class="rounded-2xl p-4 text-left w-full transition-all cursor-pointer"
            style="{{ $filterLokasi === null ? 'background:#1E3A8A;border:2px solid #1E3A8A;' : 'background:white;border:1px solid #E2E8F0;' }}">
            <div class="flex items-start justify-between mb-3">
                <p class="text-xs font-semibold leading-snug"
                    style="{{ $filterLokasi === null ? 'color:rgba(255,255,255,0.7)' : 'color:#94A3B8' }}">Semua Lokasi
                </p>
                <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                    style="{{ $filterLokasi === null ? 'background:rgba(255,255,255,0.15)' : 'background:#EFF6FF' }}">
                    <svg class="w-4 h-4" fill="none" stroke="{{ $filterLokasi === null ? 'white' : '#1E3A8A' }}"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold leading-none"
                style="{{ $filterLokasi === null ? 'color:white' : 'color:#1E3A8A' }}">
                {{ formatAngka($stats['total']) }}
            </p>
            <p class="text-xs mt-1.5"
                style="{{ $filterLokasi === null ? 'color:rgba(255,255,255,0.6)' : 'color:#94A3B8' }}">
                total paspor
            </p>
        </button>

        @foreach ($statsPerLokasi as $ls)
            <button wire:click="setFilterLokasi({{ $ls['id'] }})"
                class="rounded-2xl p-4 text-left w-full transition-all cursor-pointer"
                style="{{ $filterLokasi === $ls['id'] ? 'background:#1E3A8A;border:2px solid #1E3A8A;' : 'background:white;border:1px solid #E2E8F0;' }}">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-xs font-semibold leading-snug flex-1 pr-2 line-clamp-2"
                        style="{{ $filterLokasi === $ls['id'] ? 'color:rgba(255,255,255,0.7)' : 'color:#94A3B8' }}">
                        {{ $ls['nama'] }}
                    </p>
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0"
                        style="{{ $filterLokasi === $ls['id'] ? 'background:rgba(255,255,255,0.15)' : 'background:#EFF6FF' }}">
                        <svg class="w-4 h-4" fill="none"
                            stroke="{{ $filterLokasi === $ls['id'] ? 'white' : '#1E3A8A' }}" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold leading-none"
                    style="{{ $filterLokasi === $ls['id'] ? 'color:white' : 'color:#1E3A8A' }}">
                    {{ formatAngka($ls['total']) }}
                </p>
                <div class="flex items-center justify-between mt-1.5">
                    <p class="text-xs"
                        style="{{ $filterLokasi === $ls['id'] ? 'color:rgba(255,255,255,0.6)' : 'color:#94A3B8' }}">
                        total paspor
                    </p>
                    @if ($filterLokasi === $ls['id'])
                        <span
                            style="font-size:9px;font-weight:600;background:rgba(255,255,255,0.2);color:white;padding:1px 6px;border-radius:4px;">aktif</span>
                    @endif
                </div>
            </button>
        @endforeach
    </div>

    {{-- Filter Bar (collapsible) --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;" x-data="{ filterOpen: false }">
        <div class="flex items-center justify-between px-4 py-3 cursor-pointer"
            style="background:#F8FAFC;border-bottom:1px solid #F1F5F9;" @click="filterOpen = !filterOpen">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                <span class="text-xs font-semibold" style="color:#1E3A8A;">Filter & Pencarian</span>
                @if ($filterDari || $filterSampai || $filterJenis || $search)
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
                @if ($filterDari || $filterSampai || $filterJenis || $search)
                    <button wire:click="resetFilter" @click.stop
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold"
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
            <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Cari</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="#94A3B8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Cari semua kolom..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Jenis Layanan</label>
                    <select wire:model.live="filterJenis"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisList as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Dari Tanggal</label>
                    <input type="date" wire:model.live="filterDari"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                        onblur="this.style.borderColor='#E2E8F0'">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Sampai Tanggal</label>
                    <input type="date" wire:model.live="filterSampai"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                        onblur="this.style.borderColor='#E2E8F0'">
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
                        <th wire:click="sort('tanggal')"
                            class="px-4 py-3 text-left text-xs font-bold text-white cursor-pointer">
                            Tanggal @if ($sortColumn === 'tanggal')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    class="opacity-30">↕</span>
                            @endif
                        </th>
                        <th wire:click="sort('jenis_layanan_id')"
                            class="px-4 py-3 text-left text-xs font-bold text-white cursor-pointer">
                            Jenis Layanan @if ($sortColumn === 'jenis_layanan_id')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    class="opacity-30">↕</span>
                            @endif
                        </th>
                        <th wire:click="sort('lokasi_layanan_id')"
                            class="px-4 py-3 text-left text-xs font-bold text-white cursor-pointer">
                            Lokasi @if ($sortColumn === 'lokasi_layanan_id')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    class="opacity-30">↕</span>
                            @endif
                        </th>
                        <th wire:click="sort('jumlah')"
                            class="px-4 py-3 text-center text-xs font-bold text-white cursor-pointer">
                            Jumlah @if ($sortColumn === 'jumlah')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    class="opacity-30">↕</span>
                            @endif
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white">Keterangan</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $i => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2.5 text-xs" style="color:#94A3B8;">{{ $data->firstItem() + $i }}</td>
                            <td class="px-4 py-2.5 whitespace-nowrap">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full"
                                    style="background:#F8FAFC;color:#475569;border:1px solid #E2E8F0;">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td class="px-4 py-2.5">
                                <p class="text-xs font-semibold" style="color:#1E293B;">
                                    {{ $item->jenisLayanan?->nama_layanan ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-2.5">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="#94A3B8"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p class="text-xs" style="color:#475569;">
                                        {{ $item->lokasiLayanan?->nama_lokasi ?? '-' }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold rounded-xl"
                                    style="background:#EFF6FF;color:#1E3A8A;">
                                    {{ formatAngka($item->jumlah) }}
                                </span>
                            </td>
                            <td class="px-4 py-2.5 text-xs max-w-xs truncate" style="color:#94A3B8;">
                                {{ $item->keterangan ?? '-' }}
                            </td>
                            <td class="px-4 py-2.5 text-center">
                                <button wire:click="viewDetail({{ $item->id }})"
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-lg transition-all cursor-pointer"
                                    style="background:#EFF6FF;color:#1E3A8A;"
                                    onmouseover="this.style.background='#DBEAFE'"
                                    onmouseout="this.style.background='#EFF6FF'">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                                        style="background:#F8FAFC;border:1px solid #E2E8F0;">
                                        <svg class="w-7 h-7" fill="none" stroke="#CBD5E1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-medium" style="color:#94A3B8;">Belum ada data layanan
                                        paspor</p>
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
            <div class="flex items-center gap-3 flex-wrap">
                {{-- @if ($data->total() > 0)
                    <span class="text-xs font-medium px-3 py-1 rounded-full"
                        style="background:#EFF6FF;color:#1E3A8A;">
                        {{ $data->firstItem() }}–{{ $data->lastItem() }} dari <strong>{{ $data->total() }}</strong>
                        record
                    </span>
                @endif --}}
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium" style="color:#64748b;">Total Paspor:</span>
                    <span class="text-sm font-bold px-3 py-1 rounded-full" style="background:#1E3A8A;color:white;">
                        {{ number_format($sumFiltered) }}
                    </span>
                    @if ($filterLokasi || $filterDari || $filterSampai || $filterJenis || $search)
                        <span class="text-xs" style="color:#94a3b8;">(filter aktif)</span>
                    @endif
                </div>
            </div>
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

    {{-- Modal Form Input --}}
    @include('operator.doklan.paspor._modal_input')

    {{-- Modal view --}}
    @include('operator.doklan.paspor._modal_view')

</div>
