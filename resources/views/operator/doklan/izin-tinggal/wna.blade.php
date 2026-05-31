<div class="space-y-5">

    {{-- Header --}}
    <div class="rounded-2xl p-5 flex items-center gap-4" style="background:#1E3A8A;">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
            style="background:rgba(255,255,255,0.15);">
            <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
            </svg>
        </div>
        <div>
            <p class="text-lg font-bold text-white">Data WNA</p>
            <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">
                {{ auth()->user()->kanim?->nama_kanim ?? 'Kantor Imigrasi' }} · {{ today()->translatedFormat('d F Y') }}
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;" x-data="{ filterOpen: false }">
        <div class="flex items-center justify-between px-4 py-3 cursor-pointer"
            style="background:#F8FAFC;border-bottom:1px solid #F1F5F9;" @click="filterOpen = !filterOpen">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                <span class="text-xs font-semibold" style="color:#1E3A8A;">Filter & Pencarian</span>
                @if ($search || $filterNegara || $filterEarly)
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
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-xs" style="color:#94A3B8;">data</span>
                </div>
                @if ($search || $filterNegara || $filterEarly)
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
                            placeholder="Nama atau nomor paspor..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Kewarganegaraan</label>
                    <select wire:model.live="filterNegara"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;background:white;">
                        <option value="">Semua Negara</option>
                        @foreach ($negaraList as $n)
                            <option value="{{ $n->id }}">{{ $n->nama_negara }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Status Izin</label>
                    <select wire:model.live="filterEarly"
                        class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                        style="border-color:#E2E8F0;color:#1E293B;background:white;">
                        <option value="">Semua</option>
                        <option value="early">Early Warning (≤7 hari)</option>
                        <option value="expired">Sudah Expired</option>
                    </select>
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
                        <th class="px-4 py-3 text-left text-xs font-bold text-white">Kewarganegaraan</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white">Nomor Paspor</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white">Layanan Terakhir</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-white">Stay Permit Expire</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $i => $wna)
                        @php
                            $layanan = $layananTerbaru[$wna->id] ?? null;
                            $sisaHari = $layanan?->sisa_hari;
                            $isEarly = $layanan?->isEarlyWarning();
                            $isExpired = $sisaHari !== null && $sisaHari < 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3.5 text-sm" style="color:#94A3B8;">{{ $data->firstItem() + $i }}</td>
                            <td class="px-4 py-3.5">
                                <p class="text-sm font-semibold" style="color:#1E293B;">{{ $wna->nama_lengkap }}</p>
                                <p class="text-xs" style="color:#94a3b8;">
                                    {{ $wna->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} ·
                                    {{ $wna->tanggal_lahir?->translatedFormat('d M Y') ?? '-' }}
                                </p>
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="text-xs" style="color:#475569;">
                                    {{ $wna->kewarganegaraan?->nama_negara ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="text-xs font-mono" style="color:#475569;">{{ $wna->nomor_paspor ?? '-' }}
                                </p>
                                @if ($wna->paspor_expire)
                                    <p class="text-xs" style="color:#94a3b8;">s/d
                                        {{ $wna->paspor_expire->translatedFormat('d M Y') }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="text-sm" style="color:#374151;">
                                    {{ $layanan?->jenisLayanan?->nama_layanan ?? '-' }}</p>
                                <p class="text-xs" style="color:#94a3b8;">
                                    {{ $layanan?->tanggal_penerbitan?->translatedFormat('d M Y') ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3.5">
                                @if ($layanan?->stay_permit_expire)
                                    <div class="flex items-center gap-1.5">
                                        <div
                                            style="width:0.5rem;height:0.5rem;border-radius:9999px;flex-shrink:0;background:{{ $isExpired ? '#dc2626' : ($isEarly ? '#d97706' : '#16a34a') }};">
                                        </div>
                                        <span class="text-xs font-medium"
                                            style="color:{{ $isExpired ? '#dc2626' : ($isEarly ? '#d97706' : '#374151') }};">
                                            {{ $layanan->stay_permit_expire->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    @if ($isExpired)
                                        <p class="text-xs mt-0.5" style="color:#dc2626;">Expired {{ abs($sisaHari) }}
                                            hari lalu</p>
                                    @elseif($isEarly)
                                        <p class="text-xs mt-0.5" style="color:#d97706;">{{ $sisaHari }} hari
                                            lagi</p>
                                    @endif
                                @else
                                    <span class="text-xs" style="color:#94a3b8;">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <button wire:click="viewDetail({{ $wna->id }})" title="Lihat Detail & History"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-all cursor-pointer"
                                    style="background:#EFF6FF;color:#1E3A8A;"
                                    onmouseover="this.style.background='#1e3a8a';this.querySelector('svg').style.color='white'"
                                    onmouseout="this.style.background='#EFF6FF';this.querySelector('svg').style.color='#1E3A8A'">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
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
                                                d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium" style="color:#94A3B8;">Belum ada data WNA</p>
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
            <span class="text-xs font-medium" style="color:#64748b;">{{ $data->total() }} WNA aktif</span>
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

    {{-- Modal View Detail WNA + History --}}
    @if ($showView && $viewWna)
        <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);padding:1rem;"
            wire:click.self="closeView">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:38rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;max-height:90vh;display:flex;flex-direction:column;">
                <div
                    style="background:linear-gradient(135deg,#1E3A8A,#1a3270);padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
                    <div style="display:flex;align-items:center;gap:0.625rem;">
                        <div
                            style="width:2rem;height:2rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:1rem;height:1rem;" fill="none" stroke="white" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">
                                {{ $viewWna->nama_lengkap }}</p>
                            <p style="font-size:0.625rem;color:rgba(255,255,255,0.5);margin:0.1rem 0 0;">
                                {{ $viewWna->kewarganegaraan?->nama_negara ?? '-' }} · {{ $viewHistory->count() }}
                                record layanan
                            </p>
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

                <div style="padding:1.25rem;overflow-y:auto;display:flex;flex-direction:column;gap:1rem;">
                    {{-- Identitas WNA --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.625rem;">
                        @foreach ([['label' => 'Tempat Lahir', 'value' => $viewWna->tempat_lahir ?? '-'], ['label' => 'Tanggal Lahir', 'value' => $viewWna->tanggal_lahir?->translatedFormat('d F Y') ?? '-'], ['label' => 'Jenis Kelamin', 'value' => $viewWna->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'], ['label' => 'Nomor Paspor', 'value' => $viewWna->nomor_paspor ?? '-'], ['label' => 'Paspor Expire', 'value' => $viewWna->paspor_expire?->translatedFormat('d F Y') ?? '-'], ['label' => 'Kewarganegaraan', 'value' => $viewWna->kewarganegaraan?->nama_negara ?? '-']] as $info)
                            <div style="background:#f8fafc;border-radius:0.625rem;padding:0.75rem;">
                                <p
                                    style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                                    {{ $info['label'] }}</p>
                                <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                                    {{ $info['value'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- History Layanan --}}
                    <div>
                        <p
                            style="font-size:0.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748b;margin:0 0 0.75rem;">
                            Riwayat Layanan ({{ $viewHistory->count() }})
                        </p>
                        <div style="display:flex;flex-direction:column;gap:0.5rem;">
                            @foreach ($viewHistory as $idx => $h)
                                @php
                                    $isAktif = $idx === 0;
                                    $sisaH = $h->sisa_hari;
                                    $isExp = $sisaH !== null && $sisaH < 0;
                                    $isEW = $h->isEarlyWarning();
                                @endphp
                                <div
                                    style="background:{{ $isAktif ? '#eff6ff' : '#f8fafc' }};border:1px solid {{ $isAktif ? '#bfdbfe' : '#e2e8f0' }};border-radius:0.75rem;padding:0.875rem 1rem;">
                                    <div
                                        style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                                        <div style="display:flex;align-items:center;gap:0.5rem;">
                                            <span
                                                style="font-size:0.625rem;font-weight:700;padding:1px 8px;border-radius:9999px;{{ $isAktif ? 'background:#1e3a8a;color:white;' : 'background:#e2e8f0;color:#64748b;' }}">
                                                {{ $isAktif ? 'AKTIF' : 'Tidak Aktif' }}
                                            </span>
                                            <span
                                                style="font-size:0.75rem;font-weight:600;color:#1e293b;">{{ $h->jenisLayanan?->nama_layanan ?? '-' }}</span>
                                        </div>
                                        @php
                                            $stStyle = match ($h->status) {
                                                'terverifikasi'
                                                    => 'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;',
                                                'disubmit'
                                                    => 'background:#fffbeb;color:#d97706;border:1px solid #fde68a;',
                                                'ditolak'
                                                    => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                                                default
                                                    => 'background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;',
                                            };
                                        @endphp
                                        <span
                                            style="font-size:0.625rem;font-weight:600;padding:2px 8px;border-radius:9999px;{{ $stStyle }}">{{ $h->status_label }}</span>
                                    </div>
                                    <div style="display:flex;gap:1.25rem;flex-wrap:wrap;">
                                        <div>
                                            <p style="font-size:0.5625rem;color:#94a3b8;margin:0;">Tgl Penerbitan</p>
                                            <p
                                                style="font-size:0.75rem;font-weight:600;color:#374151;margin:0.1rem 0 0;">
                                                {{ $h->tanggal_penerbitan->translatedFormat('d M Y') }}</p>
                                        </div>
                                        @if ($h->stay_permit_expire)
                                            <div>
                                                <p style="font-size:0.5625rem;color:#94a3b8;margin:0;">Stay Permit
                                                    Expire</p>
                                                <p
                                                    style="font-size:0.75rem;font-weight:600;margin:0.1rem 0 0;color:{{ $isExp ? '#dc2626' : ($isEW ? '#d97706' : '#374151') }};">
                                                    {{ $h->stay_permit_expire->translatedFormat('d M Y') }}
                                                    @if ($isExp)
                                                        <span style="font-size:0.625rem;">(Expired)</span>
                                                    @elseif($isEW)
                                                        <span style="font-size:0.625rem;">({{ $sisaH }} hari
                                                            lagi)</span>
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                        @if ($h->permit_number)
                                            <div>
                                                <p style="font-size:0.5625rem;color:#94a3b8;margin:0;">Permit Number
                                                </p>
                                                <p
                                                    style="font-size:0.75rem;font-weight:600;color:#374151;margin:0.1rem 0 0;">
                                                    {{ $h->permit_number }}</p>
                                            </div>
                                        @endif
                                        <div>
                                            <p style="font-size:0.5625rem;color:#94a3b8;margin:0;">Lokasi</p>
                                            <p
                                                style="font-size:0.75rem;font-weight:600;color:#374151;margin:0.1rem 0 0;">
                                                {{ $h->lokasiLayanan?->nama_lokasi ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
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

</div>
