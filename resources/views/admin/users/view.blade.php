<div>

    {{-- Header --}}
    <div
        style="background:linear-gradient(135deg,#1E3A8A,#1a3270);border-radius:1rem;padding:1.25rem 1.5rem;display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
        <div style="display:flex;align-items:center;gap:0.875rem;">
            <div
                style="width:2.5rem;height:2.5rem;border-radius:0.75rem;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="white" viewBox="0 0 24 24"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
            <div>
                <h2 style="font-size:0.9375rem;font-weight:800;color:white;margin:0;">Detail User</h2>
                <p style="font-size:0.6875rem;color:rgba(255,255,255,0.55);margin:0.2rem 0 0;">Informasi lengkap akun
                    pengguna</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:0.625rem;">
            <a href="{{ route('admin.users.edit', $user->id) }}"
                style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;border-radius:0.625rem;background:rgba(212,175,55,0.15);color:#d4af37;font-size:0.8125rem;font-weight:600;border:1px solid rgba(212,175,55,0.3);text-decoration:none;"
                onmouseover="this.style.background='rgba(212,175,55,0.25)'"
                onmouseout="this.style.background='rgba(212,175,55,0.15)'">
                <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.users.index') }}"
                style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;border-radius:0.625rem;background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.85);font-size:0.8125rem;font-weight:600;border:1px solid rgba(255,255,255,0.15);text-decoration:none;"
                onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 2fr;gap:1.25rem;align-items:start;">

        {{-- Kolom Kiri: Avatar + Status --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Avatar Card --}}
            <div
                style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;padding:1.5rem;text-align:center;">
                <div
                    style="width:5rem;height:5rem;border-radius:1.25rem;background:linear-gradient(135deg,#1e3a8a,#1a3270);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.5rem;font-weight:800;color:white;">
                    {{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}{{ strtoupper(substr(explode(' ', $user->nama_lengkap)[1] ?? 'X', 0, 1)) }}
                </div>
                <p style="font-size:0.9375rem;font-weight:700;color:#1e293b;margin:0;">{{ $user->nama_lengkap }}</p>
                <p style="font-size:0.75rem;color:#94a3b8;margin:0.25rem 0 0.875rem;">{{ $user->jabatan ?? '-' }}</p>

                {{-- Status Badge --}}
                @php
                    $sc = [
                        'aktif' => ['#f0fdf4', '#16a34a', '#bbf7d0', 'Aktif'],
                        'pending' => ['#fffbeb', '#d97706', '#fde68a', 'Pending'],
                        'nonaktif' => ['#f8fafc', '#64748b', '#e2e8f0', 'Nonaktif'],
                        'ditolak' => ['#fef2f2', '#dc2626', '#fecaca', 'Ditolak'],
                    ];
                    $s = $sc[$user->status] ?? ['#f8fafc', '#64748b', '#e2e8f0', ucfirst($user->status)];
                @endphp
                <span
                    style="display:inline-flex;align-items:center;padding:0.375rem 1rem;border-radius:9999px;font-size:0.75rem;font-weight:700;background:{{ $s[0] }};color:{{ $s[1] }};border:1px solid {{ $s[2] }};">
                    {{ $s[3] }}
                </span>

                <div style="margin:1rem 0;height:1px;background:#f1f5f9;"></div>

                {{-- Role --}}
                <div style="background:#f8fafc;border-radius:0.625rem;padding:0.625rem 0.875rem;">
                    <p
                        style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#94a3b8;margin:0 0 0.25rem;">
                        Role</p>
                    <p style="font-size:0.8125rem;font-weight:600;color:#1e3a8a;margin:0;">{{ $user->role_label }}</p>
                </div>

                @if ($user->bidang)
                    <div style="background:#f8fafc;border-radius:0.625rem;padding:0.625rem 0.875rem;margin-top:0.5rem;">
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#94a3b8;margin:0 0 0.25rem;">
                            Bidang</p>
                        <p style="font-size:0.8125rem;font-weight:600;color:#1e3a8a;margin:0;">
                            {{ ucfirst($user->bidang) }}</p>
                    </div>
                @endif

                @if ($user->jenis_layanan)
                    <div style="background:#f8fafc;border-radius:0.625rem;padding:0.625rem 0.875rem;margin-top:0.5rem;">
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#94a3b8;margin:0 0 0.25rem;">
                            Jenis Layanan</p>
                        <p style="font-size:0.8125rem;font-weight:600;color:#1e3a8a;margin:0;">
                            {{ ucfirst(str_replace('_', ' ', $user->jenis_layanan)) }}</p>
                    </div>
                @endif
            </div>

            {{-- Surat Pengajuan --}}
            @if ($user->surat_pengajuan)
                <div style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;padding:1.25rem;">
                    <p
                        style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#94a3b8;margin:0 0 0.75rem;">
                        Surat Pengajuan</p>
                    <a href="{{ Storage::url($user->surat_pengajuan) }}" target="_blank"
                        style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem;border-radius:0.625rem;background:#f8fafc;border:1px solid #e2e8f0;text-decoration:none;">
                        <div
                            style="width:2.25rem;height:2.25rem;border-radius:0.5rem;background:#fef2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:1rem;height:1rem;color:#dc2626;" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:0.75rem;font-weight:600;color:#1e293b;margin:0;">Lihat Surat PDF</p>
                            <p style="font-size:0.625rem;color:#94a3b8;margin:0.125rem 0 0;">Klik untuk membuka</p>
                        </div>
                        <svg style="width:0.875rem;height:0.875rem;color:#94a3b8;margin-left:auto;" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                        </svg>
                    </a>
                </div>
            @endif

        </div>

        {{-- Kolom Kanan: Detail Info --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Data Pribadi --}}
            <div style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;overflow:hidden;">
                <div
                    style="padding:0.875rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.625rem;">
                    <div
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:0.875rem;height:0.875rem;color:#1e3a8a;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <p style="font-size:0.8125rem;font-weight:700;color:#1e293b;margin:0;">Data Pribadi</p>
                </div>
                <div style="padding:1.25rem;">
                    <table style="width:100%;border-collapse:collapse;">
                        @foreach ([['NIP', $user->nip, true], ['Nama Lengkap', $user->nama_lengkap, false], ['Jabatan', $user->jabatan ?? '-', false], ['No. HP', $user->no_hp ?? '-', false], ['Email', $user->email ?? '-', false]] as [$label, $value, $mono])
                            <tr style="border-bottom:1px solid #f8fafc;">
                                <td
                                    style="padding:0.625rem 0;font-size:0.75rem;color:#94a3b8;font-weight:500;width:40%;">
                                    {{ $label }}</td>
                                <td
                                    style="padding:0.625rem 0;font-size:0.8125rem;color:#1e293b;font-weight:500;{{ $mono ? 'font-family:monospace;letter-spacing:0.05em;' : '' }}">
                                    {{ $value }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            {{-- Penempatan --}}
            <div style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;overflow:hidden;">
                <div
                    style="padding:0.875rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.625rem;">
                    <div
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:0.875rem;height:0.875rem;color:#1e3a8a;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                    <p style="font-size:0.8125rem;font-weight:700;color:#1e293b;margin:0;">Penempatan</p>
                </div>
                <div style="padding:1.25rem;">
                    <table style="width:100%;border-collapse:collapse;">
                        <tr style="border-bottom:1px solid #f8fafc;">
                            <td style="padding:0.625rem 0;font-size:0.75rem;color:#94a3b8;font-weight:500;width:40%;">
                                Kantor Wilayah</td>
                            <td style="padding:0.625rem 0;font-size:0.8125rem;color:#1e293b;font-weight:500;">
                                {{ $user->kanwil?->nama_kanwil ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f8fafc;">
                            <td style="padding:0.625rem 0;font-size:0.75rem;color:#94a3b8;font-weight:500;">Kantor
                                Imigrasi</td>
                            <td style="padding:0.625rem 0;font-size:0.8125rem;color:#1e293b;font-weight:500;">
                                {{ $user->kanim?->nama_kanim ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Info Akun --}}
            <div style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;overflow:hidden;">
                <div
                    style="padding:0.875rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.625rem;">
                    <div
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:0.875rem;height:0.875rem;color:#1e3a8a;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <p style="font-size:0.8125rem;font-weight:700;color:#1e293b;margin:0;">Info Akun</p>
                </div>
                <div style="padding:1.25rem;">
                    <table style="width:100%;border-collapse:collapse;">
                        <tr style="border-bottom:1px solid #f8fafc;">
                            <td style="padding:0.625rem 0;font-size:0.75rem;color:#94a3b8;font-weight:500;width:40%;">
                                Terdaftar</td>
                            <td style="padding:0.625rem 0;font-size:0.8125rem;color:#1e293b;font-weight:500;">
                                {{ $user->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f8fafc;">
                            <td style="padding:0.625rem 0;font-size:0.75rem;color:#94a3b8;font-weight:500;">Diperbarui
                            </td>
                            <td style="padding:0.625rem 0;font-size:0.8125rem;color:#1e293b;font-weight:500;">
                                {{ $user->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @if ($user->alasan_penolakan)
                            <tr>
                                <td style="padding:0.625rem 0;font-size:0.75rem;color:#94a3b8;font-weight:500;">Alasan
                                    Penolakan</td>
                                <td style="padding:0.625rem 0;font-size:0.8125rem;color:#dc2626;font-weight:500;">
                                    {{ $user->alasan_penolakan }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>
