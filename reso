<div class="space-y-4">

    {{-- ══════════════════════════════════════════════
         HEADER CARD
    ══════════════════════════════════════════════ --}}
    <div class="rounded-2xl overflow-hidden"
        style="background:linear-gradient(135deg,#1e3a8a 0%,#1a3270 60%,#0f2557 100%);">
        <div
            style="padding:1.25rem 1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <div style="display:flex;align-items:center;gap:0.875rem;">
                <div
                    style="width:2.75rem;height:2.75rem;border-radius:0.875rem;background:rgba(212,175,55,0.15);border:1px solid rgba(212,175,55,0.3);display:flex;align-items:center;justify-content:center;">
                    <svg style="width:1.25rem;height:1.25rem;color:#d4af37;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size:1.0625rem;font-weight:800;color:white;margin:0;line-height:1.2;">Layanan Paspor
                    </p>
                    <p style="font-size:0.75rem;color:rgba(255,255,255,0.5);margin:0.2rem 0 0;">Monitoring & Verifikasi
                        Data Paspor Seluruh Kanim</p>
                </div>
            </div>
            {{-- Tombol Tambah — kabid + kanwil_doklan --}}
            @if (in_array(auth()->user()->role, ['superadmin', 'admin_kabid_doklan', 'admin_kanwil_doklan']))
                <button wire:click="openTambah"
                    style="display:flex;align-items:center;gap:0.5rem;padding:0.625rem 1.125rem;border-radius:0.75rem;background:linear-gradient(135deg,#d4af37,#b8860b);color:#0f172a;font-size:0.8125rem;font-weight:700;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(212,175,55,0.3);transition:all 0.18s;"
                    onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 16px rgba(212,175,55,0.4)'"
                    onmouseout="this.style.transform='';this.style.boxShadow='0 4px 12px rgba(212,175,55,0.3)'">
                    <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Data
                </button>
            @endif
        </div>

        {{-- Stats strip --}}
        <div style="padding:0 1.5rem 1.25rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
            @foreach ([['label' => 'Total Paspor', 'value' => formatAngka($stats['total']), 'color' => 'rgba(255,255,255,0.9)'], ['label' => 'Bulan Ini', 'value' => formatAngka($stats['bulan_ini']), 'color' => '#d4af37'], ['label' => 'Menunggu', 'value' => $stats['disubmit'], 'color' => '#fbbf24'], ['label' => 'Terverifikasi', 'value' => formatAngka($stats['terverifikasi']), 'color' => '#4ade80'], ['label' => 'Ditolak', 'value' => $stats['ditolak'], 'color' => '#f87171']] as $s)
                <div
                    style="display:flex;align-items:center;gap:0.625rem;padding:0.5rem 1rem;border-radius:0.625rem;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.1);">
                    <span style="font-size:1rem;font-weight:900;color:{{ $s['color'] }};">{{ $s['value'] }}</span>
                    <span
                        style="font-size:0.625rem;font-weight:600;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.4);">{{ $s['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         FILTER BAR
    ══════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl" style="border:1px solid #e2e8f0;">
        <div style="padding:0.875rem 1.25rem;display:flex;align-items:center;flex-wrap:wrap;gap:0.625rem;">

            {{-- Search --}}
            <div style="position:relative;flex:1;min-width:12rem;">
                <svg style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);width:0.875rem;height:0.875rem;color:#94a3b8;"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari operator, kanim..."
                    style="width:100%;padding:0.5rem 0.75rem 0.5rem 2.25rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;color:#1e293b;font-family:inherit;"
                    onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
            </div>

            {{-- Filter Kanim --}}
            <select wire:model.live="filterKanim"
                style="padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#475569;outline:none;font-family:inherit;background:white;"
                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                <option value="">Semua Kanim</option>
                @foreach ($kanims as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kanim }}</option>
                @endforeach
            </select>

            {{-- Filter Status --}}
            <select wire:model.live="filterStatus"
                style="padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#475569;outline:none;font-family:inherit;background:white;"
                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                <option value="">Semua Status</option>
                <option value="disubmit">Disubmit</option>
                <option value="terverifikasi">Terverifikasi</option>
                <option value="ditolak">Ditolak</option>
            </select>

            {{-- Filter Dari --}}
            <input type="date" wire:model.live="filterDari"
                style="padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#475569;outline:none;font-family:inherit;"
                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
            <span style="font-size:0.75rem;color:#94a3b8;">—</span>
            <input type="date" wire:model.live="filterSampai"
                style="padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#475569;outline:none;font-family:inherit;"
                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">

            {{-- Reset --}}
            <button wire:click="resetFilter"
                style="display:flex;align-items:center;gap:0.375rem;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid #e2e8f0;background:white;font-size:0.8125rem;color:#64748b;cursor:pointer;font-family:inherit;transition:all 0.15s;"
                onmouseover="this.style.borderColor='#1e3a8a';this.style.color='#1e3a8a'"
                onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#64748b'">
                <svg style="width:0.75rem;height:0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </button>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════
         TABEL DATA
    ══════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #e2e8f0;">

        {{-- Loading bar --}}
        <div wire:loading.delay
            wire:target="search,filterKanim,filterStatus,filterLokasi,filterDari,filterSampai,sort,gotoPage,previousPage,nextPage"
            style="height:2px;background:linear-gradient(90deg,#1e3a8a,#d4af37);animation:pulse 1s infinite;">
        </div>

        <div wire:loading.class="opacity-50"
            wire:target="search,filterKanim,filterStatus,filterLokasi,filterDari,filterSampai,sort,gotoPage,previousPage,nextPage"
            style="overflow-x:auto;transition:opacity 0.2s;">
            <table style="width:100%;border-collapse:collapse;min-width:900px;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#1e3a8a,#1a3270);">
                        <th
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.7);white-space:nowrap;">
                            No</th>
                        {{-- Sortable headers --}}
                        @foreach ([['col' => 'tanggal', 'label' => 'Tanggal'], ['col' => 'kanim_id', 'label' => 'Kanim']] as $h)
                            <th wire:click="sort('{{ $h['col'] }}')"
                                style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.7);cursor:pointer;white-space:nowrap;user-select:none;"
                                onmouseover="this.style.color='#d4af37'"
                                onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                                <span style="display:flex;align-items:center;gap:0.375rem;">
                                    {{ $h['label'] }}
                                    @if ($sortColumn === $h['col'])
                                        <span style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </span>
                            </th>
                        @endforeach
                        <th
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.7);white-space:nowrap;">
                            Lokasi</th>
                        <th
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.7);white-space:nowrap;">
                            Jenis Layanan</th>
                        <th wire:click="sort('jumlah')"
                            style="padding:0.75rem 1rem;text-align:right;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.7);cursor:pointer;white-space:nowrap;user-select:none;"
                            onmouseover="this.style.color='#d4af37'"
                            onmouseout="this.style.color='rgba(255,255,255,0.7)'">
                            <span style="display:flex;align-items:center;justify-content:flex-end;gap:0.375rem;">
                                Jumlah
                                @if ($sortColumn === 'jumlah')
                                    <span style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </span>
                        </th>
                        <th
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.7);white-space:nowrap;">
                            Operator</th>
                        <th
                            style="padding:0.75rem 1rem;text-align:center;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.7);white-space:nowrap;">
                            Status</th>
                        <th
                            style="padding:0.75rem 1rem;text-align:center;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:rgba(255,255,255,0.7);white-space:nowrap;">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $row)
                        <tr style="border-bottom:1px solid {{ $loop->last ? 'transparent' : '#f1f5f9' }};background:{{ $i % 2 === 0 ? 'white' : '#fafbfc' }};transition:background 0.15s;"
                            onmouseover="this.style.background='#f0f5ff'"
                            onmouseout="this.style.background='{{ $i % 2 === 0 ? 'white' : '#fafbfc' }}'">

                            {{-- No --}}
                            <td style="padding:0.75rem 1rem;">
                                <span style="font-size:0.75rem;color:#94a3b8;">{{ $data->firstItem() + $i }}</span>
                            </td>

                            {{-- Tanggal --}}
                            <td style="padding:0.75rem 1rem;white-space:nowrap;">
                                <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                                    {{ $row->tanggal->translatedFormat('d M Y') }}</p>
                                <p style="font-size:0.625rem;color:#94a3b8;margin:0.1rem 0 0;">
                                    {{ $row->tanggal->translatedFormat('l') }}</p>
                            </td>

                            {{-- Kanim --}}
                            <td style="padding:0.75rem 1rem;">
                                <span
                                    style="font-size:0.8125rem;font-weight:500;color:#374151;">{{ $row->kanim?->nama_kanim ?? '-' }}</span>
                            </td>

                            {{-- Lokasi --}}
                            <td style="padding:0.75rem 1rem;">
                                <span
                                    style="font-size:0.8125rem;color:#475569;">{{ $row->lokasiLayanan?->nama_lokasi ?? '-' }}</span>
                            </td>

                            {{-- Jenis --}}
                            <td style="padding:0.75rem 1rem;">
                                <span
                                    style="font-size:0.8125rem;color:#475569;">{{ $row->jenisLayanan?->nama_layanan ?? '-' }}</span>
                            </td>

                            {{-- Jumlah --}}
                            <td style="padding:0.75rem 1rem;text-align:right;">
                                <span
                                    style="font-size:0.9375rem;font-weight:800;color:#1e3a8a;">{{ number_format($row->jumlah) }}</span>
                            </td>

                            {{-- Operator --}}
                            <td style="padding:0.75rem 1rem;">
                                <p style="font-size:0.75rem;font-weight:500;color:#374151;margin:0;">
                                    {{ $row->operator?->nama_lengkap ?? '(Kanwil)' }}</p>
                                <p style="font-size:0.625rem;color:#94a3b8;margin:0.1rem 0 0;">
                                    {{ $row->operator?->nip ?? '' }}</p>
                            </td>

                            {{-- Status badge --}}
                            <td style="padding:0.75rem 1rem;text-align:center;">
                                @php
                                    $statusStyle = match ($row->status) {
                                        'terverifikasi' => 'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;',
                                        'disubmit' => 'background:#fffbeb;color:#d97706;border:1px solid #fde68a;',
                                        'ditolak' => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                                        default => 'background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;',
                                    };
                                    $statusLabel = match ($row->status) {
                                        'terverifikasi' => 'Terverifikasi',
                                        'disubmit' => 'Disubmit',
                                        'ditolak' => 'Ditolak',
                                        default => $row->status,
                                    };
                                @endphp
                                <span
                                    style="display:inline-block;padding:0.25rem 0.625rem;border-radius:9999px;font-size:0.6875rem;font-weight:600;{{ $statusStyle }}white-space:nowrap;">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:0.75rem 1rem;text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:0.375rem;">

                                    {{-- Lihat --}}
                                    <button wire:click="viewDetail({{ $row->id }})" title="Lihat Detail"
                                        style="width:1.875rem;height:1.875rem;border-radius:0.5rem;background:#eff6ff;border:1px solid #bfdbfe;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.15s;"
                                        onmouseover="this.style.background='#1e3a8a';this.querySelector('svg').style.color='white'"
                                        onmouseout="this.style.background='#eff6ff';this.querySelector('svg').style.color='#1e3a8a'">
                                        <svg style="width:0.875rem;height:0.875rem;color:#1e3a8a;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    {{-- Edit — kabid + kanwil --}}
                                    @if (in_array(auth()->user()->role, ['superadmin', 'admin_kabid_doklan', 'admin_kanwil_doklan']))
                                        <button wire:click="openEdit({{ $row->id }})" title="Edit"
                                            style="width:1.875rem;height:1.875rem;border-radius:0.5rem;background:#fffbeb;border:1px solid #fde68a;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.15s;"
                                            onmouseover="this.style.background='#d97706';this.querySelector('svg').style.color='white'"
                                            onmouseout="this.style.background='#fffbeb';this.querySelector('svg').style.color='#d97706'">
                                            <svg style="width:0.875rem;height:0.875rem;color:#d97706;" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    @endif

                                    {{-- Verifikasi: Approve — kabid saja --}}
                                    @if (in_array(auth()->user()->role, ['superadmin', 'admin_kabid_doklan']) && $row->status === 'disubmit')
                                        <button wire:click="openVerif({{ $row->id }}, 'terverifikasi')"
                                            title="Verifikasi"
                                            style="width:1.875rem;height:1.875rem;border-radius:0.5rem;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.15s;"
                                            onmouseover="this.style.background='#16a34a';this.querySelector('svg').style.color='white'"
                                            onmouseout="this.style.background='#f0fdf4';this.querySelector('svg').style.color='#16a34a'">
                                            <svg style="width:0.875rem;height:0.875rem;color:#16a34a;" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>

                                        {{-- Tolak — kabid saja --}}
                                        <button wire:click="openVerif({{ $row->id }}, 'ditolak')" title="Tolak"
                                            style="width:1.875rem;height:1.875rem;border-radius:0.5rem;background:#fef2f2;border:1px solid #fecaca;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all 0.15s;"
                                            onmouseover="this.style.background='#dc2626';this.querySelector('svg').style.color='white'"
                                            onmouseout="this.style.background='#fef2f2';this.querySelector('svg').style.color='#dc2626'">
                                            <svg style="width:0.875rem;height:0.875rem;color:#dc2626;" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="padding:3rem;text-align:center;">
                                <div style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;">
                                    <div
                                        style="width:3rem;height:3rem;border-radius:1rem;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                        <svg style="width:1.5rem;height:1.5rem;color:#cbd5e1;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p style="font-size:0.875rem;font-weight:600;color:#94a3b8;margin:0;">Tidak ada
                                        data</p>
                                    <p style="font-size:0.75rem;color:#cbd5e1;margin:0;">Coba ubah filter atau tambah
                                        data baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer tabel: total + pagination --}}
        @if ($data->hasPages() || $data->total() > 0)
            <div
                style="padding:0.75rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;background:#fafbfc;">
                <p style="font-size:0.75rem;color:#64748b;margin:0;">
                    Menampilkan <strong>{{ $data->firstItem() }}–{{ $data->lastItem() }}</strong> dari
                    <strong>{{ $data->total() }}</strong> data
                </p>
                @if ($data->hasPages())
                    <div style="display:flex;align-items:center;gap:0.375rem;">
                        {{-- Prev --}}
                        <button wire:click="previousPage"
                            @if (!$data->onFirstPage()) wire:click="previousPage" @endif
                            @disabled($data->onFirstPage())
                            style="width:2rem;height:2rem;border-radius:0.5rem;border:1px solid #e2e8f0;background:white;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.75rem;color:#475569;transition:all 0.15s;{{ $data->onFirstPage() ? 'opacity:0.4;cursor:not-allowed;' : '' }}"
                            onmouseover="if(!this.disabled)this.style.borderColor='#1e3a8a';this.style.color='#1e3a8a'"
                            onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#475569'">
                            <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        {{-- Page numbers --}}
                        @foreach ($data->getUrlRange(max(1, $data->currentPage() - 2), min($data->lastPage(), $data->currentPage() + 2)) as $page => $url)
                            <button wire:click="gotoPage({{ $page }})"
                                style="width:2rem;height:2rem;border-radius:0.5rem;border:1px solid {{ $page == $data->currentPage() ? '#1e3a8a' : '#e2e8f0' }};background:{{ $page == $data->currentPage() ? '#1e3a8a' : 'white' }};color:{{ $page == $data->currentPage() ? 'white' : '#475569' }};font-size:0.75rem;font-weight:{{ $page == $data->currentPage() ? '700' : '400' }};cursor:pointer;transition:all 0.15s;display:flex;align-items:center;justify-content:center;font-family:inherit;">
                                {{ $page }}
                            </button>
                        @endforeach

                        {{-- Next --}}
                        <button @if ($data->hasMorePages()) wire:click="nextPage" @endif
                            @disabled(!$data->hasMorePages())
                            style="width:2rem;height:2rem;border-radius:0.5rem;border:1px solid #e2e8f0;background:white;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.75rem;color:#475569;transition:all 0.15s;{{ !$data->hasMorePages() ? 'opacity:0.4;cursor:not-allowed;' : '' }}"
                            onmouseover="if(!this.disabled)this.style.borderColor='#1e3a8a';this.style.color='#1e3a8a'"
                            onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#475569'">
                            <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════
         MODAL: TAMBAH / EDIT
    ══════════════════════════════════════════════ --}}
    @if ($showForm)
        <div style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;"
            wire:click.self="closeForm">
            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);backdrop-filter:blur(4px);"></div>
            <div
                style="position:relative;z-index:1;background:white;border-radius:1.25rem;width:100%;max-width:30rem;box-shadow:0 25px 60px rgba(0,0,0,0.2);overflow:hidden;">

                {{-- Header modal --}}
                <div
                    style="padding:1.125rem 1.375rem;background:linear-gradient(135deg,#1e3a8a,#1a3270);display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:0.625rem;">
                        <div
                            style="width:2rem;height:2rem;border-radius:0.625rem;background:rgba(212,175,55,0.2);border:1px solid rgba(212,175,55,0.3);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:0.9375rem;height:0.9375rem;color:#d4af37;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                @if ($formId)
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                @endif
                            </svg>
                        </div>
                        <p style="font-size:0.9375rem;font-weight:700;color:white;margin:0;">
                            {{ $formId ? 'Edit Data Paspor' : 'Tambah Data Paspor' }}</p>
                    </div>
                    <button wire:click="closeForm"
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;color:rgba(255,255,255,0.7);transition:all 0.15s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body modal --}}
                <div style="padding:1.375rem;display:flex;flex-direction:column;gap:1rem;">

                    {{-- Kanim --}}
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                            Kantor Imigrasi <span style="color:#dc2626;">*</span>
                        </label>
                        <select wire:model.live="formKanim"
                            style="width:100%;padding:0.5625rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#1e293b;outline:none;font-family:inherit;background:white;"
                            onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                            <option value="">— Pilih Kanim —</option>
                            @foreach ($kanims as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kanim }}</option>
                            @endforeach
                        </select>
                        @error('formKanim')
                            <p style="font-size:0.6875rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                            Tanggal <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="date" wire:model="formTanggal"
                            style="width:100%;padding:0.5625rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#1e293b;outline:none;font-family:inherit;"
                            onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                        @error('formTanggal')
                            <p style="font-size:0.6875rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lokasi + Jenis (2 kolom) --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.875rem;">
                        <div>
                            <label
                                style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                                Lokasi Layanan <span style="color:#dc2626;">*</span>
                            </label>
                            <select wire:model="formLokasi"
                                style="width:100%;padding:0.5625rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#1e293b;outline:none;font-family:inherit;background:white;"
                                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                                <option value="">— Pilih —</option>
                                @foreach ($lokasis as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                                @endforeach
                            </select>
                            @error('formLokasi')
                                <p style="font-size:0.6875rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                                Jenis Layanan <span style="color:#dc2626;">*</span>
                            </label>
                            <select wire:model="formJenis"
                                style="width:100%;padding:0.5625rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#1e293b;outline:none;font-family:inherit;background:white;"
                                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                                <option value="">— Pilih —</option>
                                @foreach ($jenisLayanan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_layanan }}</option>
                                @endforeach
                            </select>
                            @error('formJenis')
                                <p style="font-size:0.6875rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Jumlah --}}
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                            Jumlah <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="number" wire:model="formJumlah" min="1" max="9999"
                            style="width:100%;padding:0.5625rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#1e293b;outline:none;font-family:inherit;"
                            onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                        @error('formJumlah')
                            <p style="font-size:0.6875rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                            Keterangan <span
                                style="font-size:0.625rem;font-weight:400;color:#94a3b8;">(opsional)</span>
                        </label>
                        <textarea wire:model="formKeterangan" rows="2" placeholder="Catatan tambahan..."
                            style="width:100%;padding:0.5625rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#1e293b;outline:none;font-family:inherit;resize:vertical;"
                            onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                    </div>
                </div>

                {{-- Footer modal --}}
                <div
                    style="padding:1rem 1.375rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:flex-end;gap:0.625rem;background:#fafbfc;">
                    <button wire:click="closeForm"
                        style="padding:0.5625rem 1.125rem;border-radius:0.625rem;border:1px solid #e2e8f0;background:white;font-size:0.8125rem;font-weight:600;color:#64748b;cursor:pointer;font-family:inherit;transition:all 0.15s;"
                        onmouseover="this.style.borderColor='#94a3b8'" onmouseout="this.style.borderColor='#e2e8f0'">
                        Batal
                    </button>
                    <button wire:click="simpan" wire:loading.attr="disabled" wire:target="simpan"
                        style="padding:0.5625rem 1.25rem;border-radius:0.625rem;background:linear-gradient(135deg,#1e3a8a,#1a3270);color:white;font-size:0.8125rem;font-weight:700;border:none;cursor:pointer;font-family:inherit;transition:all 0.15s;display:flex;align-items:center;gap:0.5rem;"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        <span wire:loading.remove
                            wire:target="simpan">{{ $formId ? 'Simpan Perubahan' : 'Tambah Data' }}</span>
                        <span wire:loading wire:target="simpan" style="display:flex;align-items:center;gap:0.5rem;">
                            <svg style="width:0.875rem;height:0.875rem;animation:spin 1s linear infinite;"
                                fill="none" viewBox="0 0 24 24">
                                <circle style="opacity:.25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
                                <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════
         MODAL: VIEW DETAIL + HISTORY VERIFIKASI
    ══════════════════════════════════════════════ --}}
    @if ($showView && $viewData)
        <div style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;"
            wire:click.self="closeView">
            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);backdrop-filter:blur(4px);"></div>
            <div
                style="position:relative;z-index:1;background:white;border-radius:1.25rem;width:100%;max-width:34rem;box-shadow:0 25px 60px rgba(0,0,0,0.2);overflow:hidden;max-height:90vh;display:flex;flex-direction:column;">

                {{-- Header --}}
                <div
                    style="padding:1.125rem 1.375rem;background:linear-gradient(135deg,#1e3a8a,#1a3270);display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
                    <div style="display:flex;align-items:center;gap:0.625rem;">
                        <div
                            style="width:2rem;height:2rem;border-radius:0.625rem;background:rgba(212,175,55,0.2);border:1px solid rgba(212,175,55,0.3);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:0.9375rem;height:0.9375rem;color:#d4af37;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:0.9375rem;font-weight:700;color:white;margin:0;">Detail Data Paspor</p>
                            <p style="font-size:0.625rem;color:rgba(255,255,255,0.5);margin:0.1rem 0 0;">ID
                                #{{ $viewData->id }}</p>
                        </div>
                    </div>
                    <button wire:click="closeView"
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;color:rgba(255,255,255,0.7);">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body scrollable --}}
                <div style="padding:1.375rem;overflow-y:auto;display:flex;flex-direction:column;gap:1.25rem;">

                    {{-- Info utama --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        @foreach ([['label' => 'Tanggal', 'value' => $viewData->tanggal->translatedFormat('l, d F Y')], ['label' => 'Kanim', 'value' => $viewData->kanim?->nama_kanim ?? '-'], ['label' => 'Lokasi Layanan', 'value' => $viewData->lokasiLayanan?->nama_lokasi ?? '-'], ['label' => 'Jenis Layanan', 'value' => $viewData->jenisLayanan?->nama_layanan ?? '-'], ['label' => 'Jumlah', 'value' => number_format($viewData->jumlah) . ' orang'], ['label' => 'Operator', 'value' => ($viewData->operator?->nama_lengkap ?? '(Kanwil)') . ($viewData->operator ? ' — ' . $viewData->operator->nip : '')]] as $info)
                            <div style="background:#f8fafc;border-radius:0.625rem;padding:0.75rem;">
                                <p
                                    style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                                    {{ $info['label'] }}</p>
                                <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                                    {{ $info['value'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Keterangan --}}
                    @if ($viewData->keterangan)
                        <div
                            style="background:#fffbeb;border:1px solid #fde68a;border-radius:0.625rem;padding:0.75rem;">
                            <p
                                style="font-size:0.5625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#d97706;margin:0 0 0.25rem;">
                                Keterangan</p>
                            <p style="font-size:0.8125rem;color:#92400e;margin:0;">{{ $viewData->keterangan }}</p>
                        </div>
                    @endif

                    {{-- Status sekarang --}}
                    <div
                        style="display:flex;align-items:center;justify-content:space-between;padding:0.875rem 1rem;border-radius:0.75rem;border:1px solid #e2e8f0;background:#f8fafc;">
                        <span style="font-size:0.75rem;font-weight:600;color:#475569;">Status Saat Ini</span>
                        @php
                            $st = $viewData->status;
                            $stStyle = match ($st) {
                                'terverifikasi' => 'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;',
                                'disubmit' => 'background:#fffbeb;color:#d97706;border:1px solid #fde68a;',
                                'ditolak' => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                                default => 'background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;',
                            };
                            $stLabel = match ($st) {
                                'terverifikasi' => 'Terverifikasi',
                                'disubmit' => 'Menunggu Verifikasi',
                                'ditolak' => 'Ditolak',
                                default => $st,
                            };
                        @endphp
                        <span
                            style="padding:0.3125rem 0.875rem;border-radius:9999px;font-size:0.75rem;font-weight:700;{{ $stStyle }}">{{ $stLabel }}</span>
                    </div>

                    {{-- History Verifikasi --}}
                    @if ($viewData->riwayat_verifikasi && count($viewData->riwayat_verifikasi) > 0)
                        <div>
                            <p
                                style="font-size:0.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748b;margin:0 0 0.75rem;">
                                Riwayat Verifikasi</p>
                            <div style="display:flex;flex-direction:column;gap:0.5rem;">
                                @foreach (array_reverse($viewData->riwayat_verifikasi) as $idx => $riwayat)
                                    <div style="display:flex;gap:0.75rem;align-items:flex-start;">
                                        {{-- Icon aksi --}}
                                        <div
                                            style="width:2rem;height:2rem;border-radius:9999px;flex-shrink:0;display:flex;align-items:center;justify-content:center;{{ $riwayat['aksi'] === 'terverifikasi' ? 'background:#f0fdf4;border:1px solid #bbf7d0;' : 'background:#fef2f2;border:1px solid #fecaca;' }}">
                                            <svg style="width:0.8125rem;height:0.8125rem;color:{{ $riwayat['aksi'] === 'terverifikasi' ? '#16a34a' : '#dc2626' }};"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2.5">
                                                @if ($riwayat['aksi'] === 'terverifikasi')
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                @endif
                                            </svg>
                                        </div>
                                        {{-- Konten --}}
                                        <div
                                            style="flex:1;background:#f8fafc;border-radius:0.625rem;padding:0.625rem 0.875rem;border:1px solid #f1f5f9;">
                                            <div
                                                style="display:flex;align-items:center;justify-content:space-between;margin-bottom:{{ $riwayat['catatan'] ? '0.375rem' : '0' }};">
                                                <span
                                                    style="font-size:0.75rem;font-weight:700;color:{{ $riwayat['aksi'] === 'terverifikasi' ? '#16a34a' : '#dc2626' }};">
                                                    {{ $riwayat['aksi'] === 'terverifikasi' ? 'Diverifikasi' : 'Ditolak' }}
                                                </span>
                                                <span
                                                    style="font-size:0.625rem;color:#94a3b8;">{{ \Carbon\Carbon::parse($riwayat['at'])->translatedFormat('d M Y, H:i') }}</span>
                                            </div>
                                            <p style="font-size:0.6875rem;color:#64748b;margin:0 0 0.25rem;">oleh
                                                <strong>{{ $riwayat['nama'] }}</strong></p>
                                            @if ($riwayat['catatan'])
                                                <p
                                                    style="font-size:0.75rem;color:#475569;margin:0.25rem 0 0;padding:0.375rem 0.625rem;background:white;border-radius:0.375rem;border:1px solid #e2e8f0;font-style:italic;">
                                                    "{{ $riwayat['catatan'] }}"
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Footer --}}
                <div
                    style="padding:1rem 1.375rem;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;background:#fafbfc;flex-shrink:0;">
                    <button wire:click="closeView"
                        style="padding:0.5625rem 1.25rem;border-radius:0.625rem;border:1px solid #e2e8f0;background:white;font-size:0.8125rem;font-weight:600;color:#64748b;cursor:pointer;font-family:inherit;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════
         MODAL: VERIFIKASI (kabid only)
    ══════════════════════════════════════════════ --}}
    @if ($showVerif)
        <div style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;"
            wire:click.self="closeVerif">
            <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);backdrop-filter:blur(4px);"></div>
            <div
                style="position:relative;z-index:1;background:white;border-radius:1.25rem;width:100%;max-width:28rem;box-shadow:0 25px 60px rgba(0,0,0,0.2);overflow:hidden;">

                {{-- Header --}}
                @php $isApprove = $verifAksi === 'terverifikasi'; @endphp
                <div
                    style="padding:1.125rem 1.375rem;background:{{ $isApprove ? 'linear-gradient(135deg,#15803d,#166534)' : 'linear-gradient(135deg,#dc2626,#b91c1c)' }};display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:0.625rem;">
                        <div
                            style="width:2rem;height:2rem;border-radius:0.625rem;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:0.9375rem;height:0.9375rem;color:white;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                @if ($isApprove)
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                @endif
                            </svg>
                        </div>
                        <p style="font-size:0.9375rem;font-weight:700;color:white;margin:0;">
                            {{ $isApprove ? 'Verifikasi Data' : 'Tolak Data' }}</p>
                    </div>
                    <button wire:click="closeVerif"
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:rgba(255,255,255,0.15);border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;color:white;">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div style="padding:1.375rem;display:flex;flex-direction:column;gap:1rem;">
                    <p style="font-size:0.875rem;color:#475569;margin:0;">
                        @if ($isApprove)
                            Apakah Anda yakin ingin <strong style="color:#16a34a;">memverifikasi</strong> data ini?
                            Catatan opsional.
                        @else
                            Masukkan alasan penolakan. Data akan dikembalikan ke operator untuk diperbaiki.
                        @endif
                    </p>

                    <div>
                        <label
                            style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                            {{ $isApprove ? 'Catatan' : 'Alasan Penolakan' }}
                            @if (!$isApprove)
                                <span style="color:#dc2626;">*</span>
                            @endif
                            @if ($isApprove)
                                <span style="font-size:0.625rem;font-weight:400;color:#94a3b8;">(opsional)</span>
                            @endif
                        </label>
                        <textarea wire:model="verifCatatan" rows="3"
                            placeholder="{{ $isApprove ? 'Catatan verifikasi...' : 'Tulis alasan penolakan...' }}"
                            style="width:100%;padding:0.5625rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#1e293b;outline:none;font-family:inherit;resize:vertical;"
                            onfocus="this.style.borderColor='{{ $isApprove ? '#16a34a' : '#dc2626' }}'"
                            onblur="this.style.borderColor='#e2e8f0'"></textarea>
                        @error('verifCatatan')
                            <p style="font-size:0.6875rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Footer --}}
                <div
                    style="padding:1rem 1.375rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:flex-end;gap:0.625rem;background:#fafbfc;">
                    <button wire:click="closeVerif"
                        style="padding:0.5625rem 1.125rem;border-radius:0.625rem;border:1px solid #e2e8f0;background:white;font-size:0.8125rem;font-weight:600;color:#64748b;cursor:pointer;font-family:inherit;">
                        Batal
                    </button>
                    <button wire:click="simpanVerif" wire:loading.attr="disabled" wire:target="simpanVerif"
                        style="padding:0.5625rem 1.25rem;border-radius:0.625rem;background:{{ $isApprove ? 'linear-gradient(135deg,#16a34a,#15803d)' : 'linear-gradient(135deg,#dc2626,#b91c1c)' }};color:white;font-size:0.8125rem;font-weight:700;border:none;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:0.5rem;">
                        <span wire:loading.remove
                            wire:target="simpanVerif">{{ $isApprove ? 'Ya, Verifikasi' : 'Ya, Tolak' }}</span>
                        <span wire:loading wire:target="simpanVerif"
                            style="display:flex;align-items:center;gap:0.5rem;">
                            <svg style="width:0.875rem;height:0.875rem;animation:spin 1s linear infinite;"
                                fill="none" viewBox="0 0 24 24">
                                <circle style="opacity:.25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" />
                                <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>

<style>
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }
</style>
