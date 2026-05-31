<div>

    {{-- Header Card --}}
    <div class="rounded-2xl px-6 py-5 flex items-center justify-between mb-5"
        style="background:linear-gradient(135deg,#1E3A8A,#1a3270);">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(255,255,255,0.1);">
                <svg class="w-5 h-5" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-white">Manajemen User</h2>
                <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.6);">Kantor Wilayah Direktorat Jenderal
                    Imigrasi Jawa Barat</p>
            </div>
        </div>
        <a href="{{ route('admin.users.create') }}"
            style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1.25rem;border-radius:0.75rem;background:#D4AF37;color:#0F172A;font-size:0.875rem;font-weight:700;text-decoration:none;"
            onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='brightness(1)'">
            <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User
        </a>
    </div>

    {{-- Stats Cards --}}
    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:0.75rem;margin-bottom:1.25rem;">
        @foreach ([['label' => 'Total User', 'value' => $stats['total'], 'color' => '#1e3a8a', 'bg' => '#eff6ff', 'border' => '#bfdbfe'], ['label' => 'Aktif', 'value' => $stats['aktif'], 'color' => '#16a34a', 'bg' => '#f0fdf4', 'border' => '#bbf7d0'], ['label' => 'Pending', 'value' => $stats['pending'], 'color' => '#d97706', 'bg' => '#fffbeb', 'border' => '#fde68a'], ['label' => 'Nonaktif', 'value' => $stats['nonaktif'], 'color' => '#64748b', 'bg' => '#f8fafc', 'border' => '#e2e8f0'], ['label' => 'Ditolak', 'value' => $stats['ditolak'], 'color' => '#dc2626', 'bg' => '#fef2f2', 'border' => '#fecaca']] as $stat)
            <div
                style="background:{{ $stat['bg'] }};border-radius:0.875rem;padding:1rem 1.25rem;border:1px solid {{ $stat['border'] }};display:flex;flex-direction:column;gap:0.25rem;">
                <p
                    style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:{{ $stat['color'] }};opacity:0.7;margin:0;">
                    {{ $stat['label'] }}</p>
                <p style="font-size:1.75rem;font-weight:800;color:{{ $stat['color'] }};margin:0;line-height:1;">
                    {{ $stat['value'] }}</p>
                <p style="font-size:0.625rem;color:{{ $stat['color'] }};opacity:0.5;margin:0;">user</p>
            </div>
        @endforeach
    </div>

    {{-- Filter & Search --}}
    <div
        style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;padding:1rem 1.25rem;margin-bottom:1rem;">
        <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
            {{-- Search --}}
            <div style="position:relative;flex:1;min-width:200px;">
                <svg style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);width:0.875rem;height:0.875rem;color:#94a3b8;"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama, NIP, jabatan..."
                    style="width:100%;padding:0.5rem 0.75rem 0.5rem 2.25rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:#f8fafc;box-sizing:border-box;">
            </div>
            {{-- Filter Status --}}
            <select wire:model.live="filterStatus"
                style="padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:#f8fafc;color:#475569;">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="pending">Pending</option>
                <option value="nonaktif">Nonaktif</option>
                <option value="ditolak">Ditolak</option>
            </select>

            {{-- Filter Role --}}
            <select wire:model.live="filterRole"
                style="padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:#f8fafc;color:#475569;">
                <option value="">Semua Role</option>
                @foreach ($manageableRoles as $r)
                    <option value="{{ $r }}">
                        {{ match ($r) {
                            'admin_kakanwil' => 'Admin Kakanwil',
                            'admin_kabid_doklan' => 'Kabid Doklan',
                            'admin_kanwil_doklan' => 'Admin Kanwil Doklan',
                            'admin_kabid_wasdakim' => 'Kabid Wasdakim',
                            'admin_kanwil_wasdakim' => 'Admin Kanwil Wasdakim',
                            'admin_kabag_tu' => 'Kabag TU',
                            'admin_kanwil_tu' => 'Admin Kanwil TU',
                            'admin_kanim' => 'Admin Kanim',
                            'operator_kanim' => 'Operator Kanim',
                            'operator_tu' => 'Operator TU',
                            default => $r,
                        } }}
                    </option>
                @endforeach
            </select>
            {{-- NB: filter role otomatis sesuai hierarki login --}}

            {{-- Filter Kanim --}}
            <select wire:model.live="filterKanim"
                style="padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:#f8fafc;color:#475569;max-width:200px;">
                <option value="">Semua Kanim</option>
                @foreach ($kanimList as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kanim }}</option>
                @endforeach
            </select>

            {{-- Reset Filter --}}
            @if ($search || $filterStatus || $filterRole || $filterKanim)
                <button wire:click="resetFilter"
                    style="display:flex;align-items:center;gap:0.375rem;padding:0.5rem 0.875rem;border-radius:0.625rem;background:#fef2f2;color:#dc2626;font-size:0.75rem;font-weight:600;border:1px solid #fecaca;cursor:pointer;white-space:nowrap;">
                    <svg style="width:0.75rem;height:0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reset Filter
                </button>
            @endif
        </div>
    </div>

    {{-- Tabel --}}
    <div style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#1e3a8a,#1a3270);">
                        <th
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.7);white-space:nowrap;">
                            No</th>
                        <th wire:click="sort('nama_lengkap')"
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.7);white-space:nowrap;cursor:pointer;">
                            Nama / NIP @if ($sortColumn === 'nama_lengkap')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    style="opacity:0.3;">↕</span>
                            @endif
                        </th>
                        <th wire:click="sort('role')"
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.7);white-space:nowrap;cursor:pointer;">
                            Role @if ($sortColumn === 'role')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    style="opacity:0.3;">↕</span>
                            @endif
                        </th>
                        <th wire:click="sort('kanim_id')"
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.7);white-space:nowrap;cursor:pointer;">
                            Satuan Kerja @if ($sortColumn === 'kanim_id')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    style="opacity:0.3;">↕</span>
                            @endif
                        </th>
                        <th wire:click="sort('status')"
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.7);white-space:nowrap;cursor:pointer;">
                            Status @if ($sortColumn === 'status')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    style="opacity:0.3;">↕</span>
                            @endif
                        </th>
                        <th wire:click="sort('created_at')"
                            style="padding:0.75rem 1rem;text-align:left;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.7);white-space:nowrap;cursor:pointer;">
                            Terdaftar @if ($sortColumn === 'created_at')
                                <span
                                style="color:#d4af37;">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>@else<span
                                    style="opacity:0.3;">↕</span>
                            @endif
                        </th>
                        <th
                            style="padding:0.75rem 1rem;text-align:center;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:rgba(255,255,255,0.7);white-space:nowrap;">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                        <tr style="border-bottom:1px solid #f1f5f9;transition:background 0.15s;"
                            onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                            <td style="padding:0.875rem 1rem;font-size:0.75rem;color:#94a3b8;">
                                {{ $users->firstItem() + $i }}</td>
                            <td style="padding:0.875rem 1rem;">
                                <div style="display:flex;align-items:center;gap:0.625rem;">
                                    <div
                                        style="width:2.125rem;height:2.125rem;border-radius:0.625rem;background:linear-gradient(135deg,#1e3a8a,#1a3270);display:flex;align-items:center;justify-content:center;font-size:0.6875rem;font-weight:800;color:white;flex-shrink:0;">
                                        {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->nama_lengkap)[1] ?? 'X', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p
                                            style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;line-height:1.3;">
                                            {{ $user->nama_lengkap }}</p>
                                        <p
                                            style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;font-family:monospace;">
                                            {{ $user->nip }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:0.875rem 1rem;">
                                <p style="font-size:0.75rem;font-weight:500;color:#475569;margin:0;">
                                    {{ $user->role_label }}</p>
                                @if ($user->bidang)
                                    <p style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;">
                                        {{ ucfirst($user->bidang) }}</p>
                                @endif
                            </td>
                            <td style="padding:0.875rem 1rem;">
                                <p style="font-size:0.75rem;color:#475569;margin:0;">
                                    {{ $user->kanim?->nama_kanim ?? ($user->kanwil?->nama_kanwil ?? '-') }}</p>
                            </td>
                            <td style="padding:0.875rem 1rem;">
                                @php
                                    $sc = [
                                        'aktif' => ['#f0fdf4', '#16a34a', 'Aktif'],
                                        'pending' => ['#fffbeb', '#d97706', 'Pending'],
                                        'nonaktif' => ['#f8fafc', '#64748b', 'Nonaktif'],
                                        'ditolak' => ['#fef2f2', '#dc2626', 'Ditolak'],
                                    ];
                                    $s = $sc[$user->status] ?? ['#f8fafc', '#64748b', ucfirst($user->status)];
                                @endphp
                                <span
                                    style="display:inline-flex;align-items:center;padding:0.25rem 0.75rem;border-radius:9999px;font-size:0.625rem;font-weight:700;background:{{ $s[0] }};color:{{ $s[1] }};">
                                    {{ $s[2] }}
                                </span>
                            </td>
                            <td style="padding:0.875rem 1rem;">
                                <p style="font-size:0.75rem;color:#475569;margin:0;">
                                    {{ $user->created_at->format('d M Y') }}</p>
                                <p style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;">
                                    {{ $user->created_at->format('H:i') }}</p>
                            </td>
                            <td style="padding:0.875rem 1rem;text-align:center;">
                                <div style="display:flex;align-items:center;justify-content:center;gap:0.375rem;">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        style="padding:0.375rem;border-radius:0.5rem;background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;display:inline-flex;align-items:center;justify-content:center;">
                                        <svg style="width:0.875rem;height:0.875rem;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        style="padding:0.375rem;border-radius:0.5rem;background:#fffbeb;color:#d97706;border:1px solid #fde68a;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;">
                                        <svg style="width:0.875rem;height:0.875rem;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>

                                    @if ($user->status === 'pending')
                                        <button
                                            wire:click="openApprove({{ $user->id }},'{{ addslashes($user->nama_lengkap) }}')"
                                            style="padding:0.375rem 0.625rem;border-radius:0.5rem;background:#f0fdf4;color:#16a34a;font-size:0.625rem;font-weight:700;border:1px solid #bbf7d0;cursor:pointer;">Setujui</button>
                                        <button
                                            wire:click="openTolak({{ $user->id }},'{{ addslashes($user->nama_lengkap) }}')"
                                            style="padding:0.375rem 0.625rem;border-radius:0.5rem;background:#fef2f2;color:#dc2626;font-size:0.625rem;font-weight:700;border:1px solid #fecaca;cursor:pointer;">Tolak</button>
                                    @elseif($user->status === 'aktif')
                                        <button
                                            wire:click="openNonaktif({{ $user->id }},'{{ addslashes($user->nama_lengkap) }}')"
                                            style="padding:0.375rem 0.625rem;border-radius:0.5rem;background:#f8fafc;color:#64748b;font-size:0.625rem;font-weight:700;border:1px solid #e2e8f0;cursor:pointer;">Nonaktifkan</button>
                                    @elseif($user->status === 'nonaktif')
                                        <button
                                            wire:click="openAktifkan({{ $user->id }},'{{ addslashes($user->nama_lengkap) }}')"
                                            style="padding:0.375rem 0.625rem;border-radius:0.5rem;background:#eff6ff;color:#1e3a8a;font-size:0.625rem;font-weight:700;border:1px solid #bfdbfe;cursor:pointer;">Aktifkan</button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:3rem;text-align:center;">
                                <div style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;">
                                    <div
                                        style="width:3rem;height:3rem;border-radius:0.875rem;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                        <svg style="width:1.5rem;height:1.5rem;color:#cbd5e1;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                    </div>
                                    <p style="font-size:0.875rem;color:#94a3b8;margin:0;">Tidak ada data user</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer tabel --}}
        <div
            style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;background:#fafafa;">
            {{-- Kiri: tampilkan + info --}}
            <div style="display:flex;align-items:center;gap:0.625rem;">
                <span style="font-size:0.75rem;color:#94a3b8;">Tampilkan</span>
                <select wire:model.live="perPage"
                    style="padding:0.25rem 0.625rem;border-radius:0.5rem;border:1px solid #e2e8f0;font-size:0.75rem;outline:none;background:white;color:#475569;">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span style="font-size:0.75rem;color:#94a3b8;">data</span>
                @if ($users->total() > 0)
                    <span
                        style="font-size:0.75rem;color:#64748b;padding:0.25rem 0.625rem;background:#eff6ff;border-radius:9999px;font-weight:500;">
                        {{ $users->firstItem() }}–{{ $users->lastItem() }} dari
                        <strong>{{ $users->total() }}</strong> user
                    </span>
                @endif
            </div>
            {{-- Kanan: pagination --}}
            @if ($users->hasPages())
                <div style="display:flex;align-items:center;gap:0.375rem;">
                    {{-- Prev --}}
                    @if ($users->onFirstPage())
                        <span
                            style="padding:0.375rem 0.625rem;border-radius:0.5rem;background:#f1f5f9;color:#cbd5e1;font-size:0.75rem;font-weight:600;cursor:not-allowed;">‹</span>
                    @else
                        <button wire:click="previousPage"
                            style="padding:0.375rem 0.625rem;border-radius:0.5rem;background:white;color:#475569;font-size:0.75rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;"
                            onmouseover="this.style.background='#eff6ff'"
                            onmouseout="this.style.background='white'">‹</button>
                    @endif

                    {{-- Pages --}}
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if ($page == $users->currentPage())
                            <span
                                style="padding:0.375rem 0.75rem;border-radius:0.5rem;background:#1e3a8a;color:white;font-size:0.75rem;font-weight:700;min-width:2rem;text-align:center;">{{ $page }}</span>
                        @elseif(abs($page - $users->currentPage()) <= 2)
                            <button wire:click="gotoPage({{ $page }})"
                                style="padding:0.375rem 0.75rem;border-radius:0.5rem;background:white;color:#475569;font-size:0.75rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;min-width:2rem;text-align:center;"
                                onmouseover="this.style.background='#eff6ff'"
                                onmouseout="this.style.background='white'">{{ $page }}</button>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($users->hasMorePages())
                        <button wire:click="nextPage"
                            style="padding:0.375rem 0.625rem;border-radius:0.5rem;background:white;color:#475569;font-size:0.75rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;"
                            onmouseover="this.style.background='#eff6ff'"
                            onmouseout="this.style.background='white'">›</button>
                    @else
                        <span
                            style="padding:0.375rem 0.625rem;border-radius:0.5rem;background:#f1f5f9;color:#cbd5e1;font-size:0.75rem;font-weight:600;cursor:not-allowed;">›</span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Modal Approve --}}
    @if ($showModalApprove)
        <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.4);"
            wire:click.self="closeModal">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:24rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;">
                <div style="background:linear-gradient(135deg,#16a34a,#15803d);padding:1rem 1.25rem;">
                    <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">Setujui Akun</p>
                </div>
                <div style="padding:1.25rem;">
                    <p style="font-size:0.875rem;color:#475569;margin:0;">Setujui akun
                        <strong>{{ $selectedUserName }}</strong>?
                    </p>
                    <p style="font-size:0.75rem;color:#94a3b8;margin:0.5rem 0 0;">User akan bisa login setelah
                        disetujui.</p>
                </div>
                <div
                    style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;gap:0.625rem;justify-content:flex-end;">
                    <button wire:click="closeModal"
                        style="padding:0.5rem 1.25rem;border-radius:0.625rem;background:#f8fafc;color:#64748b;font-size:0.8125rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;">Batal</button>
                    <button wire:click="approve"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#16a34a;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">
                        <span wire:loading.remove wire:target="approve">Ya, Setujui</span>
                        <span wire:loading wire:target="approve">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Tolak --}}
    @if ($showModalTolak)
        <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.4);"
            wire:click.self="closeModal">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:24rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;">
                <div style="background:linear-gradient(135deg,#dc2626,#b91c1c);padding:1rem 1.25rem;">
                    <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">Tolak Pendaftaran</p>
                </div>
                <div style="padding:1.25rem;display:flex;flex-direction:column;gap:0.875rem;">
                    <p style="font-size:0.875rem;color:#475569;margin:0;">Tolak akun
                        <strong>{{ $selectedUserName }}</strong>?
                    </p>
                    <div>
                        <label
                            style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">Alasan
                            Penolakan <span style="color:#ef4444;">*</span></label>
                        <textarea wire:model="alasanPenolakan" rows="3"
                            style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;resize:none;box-sizing:border-box;"
                            placeholder="Jelaskan alasan penolakan..."></textarea>
                        @error('alasanPenolakan')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div
                    style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;gap:0.625rem;justify-content:flex-end;">
                    <button wire:click="closeModal"
                        style="padding:0.5rem 1.25rem;border-radius:0.625rem;background:#f8fafc;color:#64748b;font-size:0.8125rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;">Batal</button>
                    <button wire:click="tolak"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#dc2626;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">
                        <span wire:loading.remove wire:target="tolak">Ya, Tolak</span>
                        <span wire:loading wire:target="tolak">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Nonaktif --}}
    @if ($showModalNonaktif)
        <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.4);"
            wire:click.self="closeModal">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:24rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;">
                <div style="background:linear-gradient(135deg,#64748b,#475569);padding:1rem 1.25rem;">
                    <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">Nonaktifkan Akun</p>
                </div>
                <div style="padding:1.25rem;">
                    <p style="font-size:0.875rem;color:#475569;margin:0;">Nonaktifkan akun
                        <strong>{{ $selectedUserName }}</strong>? User tidak bisa login.
                    </p>
                </div>
                <div
                    style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;gap:0.625rem;justify-content:flex-end;">
                    <button wire:click="closeModal"
                        style="padding:0.5rem 1.25rem;border-radius:0.625rem;background:#f8fafc;color:#64748b;font-size:0.8125rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;">Batal</button>
                    <button wire:click="nonaktifkan"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#64748b;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">
                        <span wire:loading.remove wire:target="nonaktifkan">Ya, Nonaktifkan</span>
                        <span wire:loading wire:target="nonaktifkan">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Aktifkan --}}
    @if ($showModalAktifkan)
        <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.4);"
            wire:click.self="closeModal">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:24rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;">
                <div style="background:linear-gradient(135deg,#1e3a8a,#1a3270);padding:1rem 1.25rem;">
                    <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">Aktifkan Kembali</p>
                </div>
                <div style="padding:1.25rem;">
                    <p style="font-size:0.875rem;color:#475569;margin:0;">Aktifkan kembali akun
                        <strong>{{ $selectedUserName }}</strong>?
                    </p>
                </div>
                <div
                    style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;gap:0.625rem;justify-content:flex-end;">
                    <button wire:click="closeModal"
                        style="padding:0.5rem 1.25rem;border-radius:0.625rem;background:#f8fafc;color:#64748b;font-size:0.8125rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;">Batal</button>
                    <button wire:click="aktifkan"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#1e3a8a;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">
                        <span wire:loading.remove wire:target="aktifkan">Ya, Aktifkan</span>
                        <span wire:loading wire:target="aktifkan">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
