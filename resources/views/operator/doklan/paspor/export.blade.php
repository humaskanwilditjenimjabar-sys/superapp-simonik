<div class="space-y-5">

    {{-- Header --}}
    <div class="rounded-2xl p-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        style="background:#1E3A8A;">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
                style="background:rgba(255,255,255,0.15);">
                <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </div>
            <div>
                <p class="text-lg font-bold text-white">Export Layanan Paspor</p>
                <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">
                    {{ auth()->user()->kanim?->nama_kanim ?? 'Kantor Imigrasi' }} ·
                    {{ today()->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('operator.doklan.paspor.export.excel', [
                'filter_lokasi' => $filterLokasi,
                'filter_dari' => $filterDari,
                'filter_sampai' => $filterSampai,
                'filter_jenis' => $filterJenis,
            ]) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold cursor-pointer"
                style="background:#16a34a;color:white;" onmouseover="this.style.opacity='0.9'"
                onmouseout="this.style.opacity='1'">
                <svg class="w-4 h-4" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Excel
            </a>
            <a href="{{ route('operator.doklan.paspor.export.pdf', [
                'filter_lokasi' => $filterLokasi,
                'filter_dari' => $filterDari,
                'filter_sampai' => $filterSampai,
                'filter_jenis' => $filterJenis,
            ]) }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold cursor-pointer"
                style="background:#dc2626;color:white;" onmouseover="this.style.opacity='0.9'"
                onmouseout="this.style.opacity='1'">
                <svg class="w-4 h-4" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                PDF
            </a>
        </div>
    </div>

    {{-- Filter Bar (selalu tampil) --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;">
        <div class="px-4 py-3 flex items-center justify-between"
            style="background:#F8FAFC;border-bottom:1px solid #F1F5F9;">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                </svg>
                <span class="text-xs font-semibold" style="color:#1E3A8A;">Filter Data</span>
                @if ($filterLokasi || $filterDari || $filterSampai || $filterJenis)
                    <span class="text-xs px-2 py-0.5 rounded-full font-semibold"
                        style="background:#1E3A8A;color:white;">Aktif</span>
                @endif
            </div>
            @if ($filterLokasi || $filterDari || $filterSampai || $filterJenis)
                <button wire:click="resetFilter"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold"
                    style="background:#FEF2F2;color:#DC2626;border:1px solid #FECACA;">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reset Filter
                </button>
            @endif

        </div>
        <div class="p-4 grid grid-cols-1 sm:grid-cols-4 gap-3">
            {{-- Lokasi --}}
            <div>
                <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Lokasi Layanan</label>
                <select wire:model.live="filterLokasi" class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                    style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                    onblur="this.style.borderColor='#E2E8F0'">
                    <option value="">Semua Lokasi</option>
                    @foreach ($lokasiList as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Dari --}}
            <div>
                <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Dari Tanggal</label>
                <input type="date" wire:model.live="filterDari"
                    class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                    style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                    onblur="this.style.borderColor='#E2E8F0'">
            </div>
            {{-- Sampai --}}
            <div>
                <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Sampai Tanggal</label>
                <input type="date" wire:model.live="filterSampai"
                    class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                    style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                    onblur="this.style.borderColor='#E2E8F0'">
            </div>
            {{-- Jenis --}}
            <div>
                <label class="block text-xs font-medium mb-1.5" style="color:#64748B;">Jenis Layanan</label>
                <select wire:model.live="filterJenis" class="w-full px-3 py-2.5 rounded-xl text-sm border outline-none"
                    style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                    onblur="this.style.borderColor='#E2E8F0'">
                    <option value="">Semua Jenis</option>
                    @foreach ($jenisList as $j)
                        <option value="{{ $j->id }}">{{ $j->nama_layanan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Per Lokasi --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;">
            <div class="px-4 py-3 flex items-center gap-2"
                style="background:#F8FAFC;border-bottom:1px solid #F1F5F9;">
                <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-xs font-semibold" style="color:#1E3A8A;">Ringkasan Per Lokasi</p>
            </div>

            <table class="w-full">
                <thead>
                    <tr style="background:#1e3a8a;">
                        <th class="px-4 py-2.5 text-left text-xs font-bold text-white">Lokasi</th>
                        <th class="px-4 py-2.5 text-right text-xs font-bold text-white">Jumlah</th>
                        <th class="px-4 py-2.5 text-right text-xs font-bold text-white">%</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($summaryLokasi as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2.5 text-xs" style="color:#475569;">{{ $row['nama'] }}</td>
                            <td class="px-4 py-2.5 text-xs text-right font-semibold" style="color:#1e3a8a;">
                                {{ number_format($row['total']) }}</td>
                            <td class="px-4 py-2.5 text-xs text-right" style="color:#94a3b8;">
                                {{ $total > 0 ? round(($row['total'] / $total) * 100, 1) : 0 }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-xs" style="color:#94a3b8;">Tidak ada
                                data</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($summaryLokasi->count() > 0)
                    <tfoot>
                        <tr style="background:#eff6ff;border-top:1px solid #bfdbfe;">
                            <td class="px-4 py-2.5 text-xs font-bold" style="color:#1e3a8a;">Total</td>
                            <td class="px-4 py-2.5 text-xs text-right font-bold" style="color:#1e3a8a;">
                                {{ number_format($total) }}</td>
                            <td class="px-4 py-2.5 text-xs text-right font-bold" style="color:#1e3a8a;">100%</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        {{-- Per Jenis --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;">
            <div class="px-4 py-3 flex items-center gap-2"
                style="background:#F8FAFC;border-bottom:1px solid #F1F5F9;">
                <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-xs font-semibold" style="color:#1E3A8A;">Ringkasan Per Jenis Layanan</p>
            </div>
            <table class="w-full">
                <thead>
                    <tr style="background:#1e3a8a;">
                        <th class="px-4 py-2.5 text-left text-xs font-bold text-white">Jenis Layanan</th>
                        <th class="px-4 py-2.5 text-right text-xs font-bold text-white">Jumlah</th>
                        <th class="px-4 py-2.5 text-right text-xs font-bold text-white">%</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($summaryJenis as $row)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2.5 text-xs" style="color:#475569;">{{ $row['nama'] }}</td>
                            <td class="px-4 py-2.5 text-xs text-right font-semibold" style="color:#1e3a8a;">
                                {{ number_format($row['total']) }}</td>
                            <td class="px-4 py-2.5 text-xs text-right" style="color:#94a3b8;">
                                {{ $total > 0 ? round(($row['total'] / $total) * 100, 1) : 0 }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-xs" style="color:#94a3b8;">Tidak ada
                                data</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($summaryJenis->count() > 0)
                    <tfoot>
                        <tr style="background:#eff6ff;border-top:1px solid #bfdbfe;">
                            <td class="px-4 py-2.5 text-xs font-bold" style="color:#1e3a8a;">Total</td>
                            <td class="px-4 py-2.5 text-xs text-right font-bold" style="color:#1e3a8a;">
                                {{ number_format($total) }}</td>
                            <td class="px-4 py-2.5 text-xs text-right font-bold" style="color:#1e3a8a;">100%</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- Tabel --}}
    {{-- Tabel --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;">
        {{-- Table Header --}}
        <div class="flex items-center justify-between px-4 py-3"
            style="background:#F8FAFC;border-bottom:1px solid #F1F5F9;">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-xs font-semibold" style="color:#1E3A8A;">Data Layanan Paspor</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs" style="color:#94A3B8;">Tampilkan</span>
                <select wire:model.live="perPage"
                    class="pl-3 pr-7 py-1.5 rounded-lg text-xs font-bold border outline-none cursor-pointer appearance-none"
                    style="border-color:#E2E8F0;color:#1E3A8A;background:#EFF6FF;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-xs" style="color:#94A3B8;">data</span>
            </div>
        </div>
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
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($data as $i => $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3.5 text-sm" style="color:#94A3B8;">{{ $data->firstItem() + $i }}</td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full"
                                    style="background:#F8FAFC;color:#475569;border:1px solid #E2E8F0;">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="text-sm font-semibold" style="color:#1E293B;">
                                    {{ $item->jenisLayanan?->nama_layanan ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="#94A3B8"
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
                            <td class="px-4 py-3.5 text-center">
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 text-sm font-bold rounded-xl"
                                    style="background:#EFF6FF;color:#1E3A8A;">{{ number_format($item->jumlah) }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-xs max-w-xs truncate" style="color:#94A3B8;">
                                {{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-16 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                                        style="background:#F8FAFC;border:1px solid #E2E8F0;">
                                        <svg class="w-7 h-7" fill="none" stroke="#CBD5E1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium" style="color:#94A3B8;">Belum ada data</p>
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
                @if ($data->total() > 0)
                    <span class="text-xs font-medium px-3 py-1 rounded-full"
                        style="background:#EFF6FF;color:#1E3A8A;">
                        {{ $data->firstItem() }}–{{ $data->lastItem() }} dari <strong>{{ $data->total() }}</strong>
                        record
                    </span>
                @endif
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium" style="color:#64748b;">Total Paspor:</span>
                    <span class="text-sm font-bold px-3 py-1 rounded-full" style="background:#1E3A8A;color:white;">
                        {{ number_format($total) }}
                    </span>
                </div>
                {{-- <div class="flex items-center gap-2">
                    <span class="text-xs" style="color:#94A3B8;">Tampilkan</span>
                    <select wire:model.live="perPage"
                        class="pl-3 pr-7 py-1.5 rounded-lg text-xs font-bold border outline-none cursor-pointer appearance-none"
                        style="border-color:#E2E8F0;color:#1E3A8A;background:#EFF6FF;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div> --}}
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

</div>
