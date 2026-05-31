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
                        d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
            </div>
            <div>
                <h2 style="font-size:0.9375rem;font-weight:800;color:white;margin:0;letter-spacing:-0.01em;">Edit User
                </h2>
                <p style="font-size:0.6875rem;color:rgba(255,255,255,0.55);margin:0.2rem 0 0;">Perbarui data user di
                    bawah ini</p>
            </div>
        </div>
        <a href="{{ route('admin.users.index') }}"
            style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;border-radius:0.625rem;background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.85);font-size:0.8125rem;font-weight:600;border:1px solid rgba(255,255,255,0.15);text-decoration:none;transition:all 0.15s;"
            onmouseover="this.style.background='rgba(255,255,255,0.2)'"
            onmouseout="this.style.background='rgba(255,255,255,0.1)'">
            <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </a>
        <script>
            function togglePw(inputId, eyeShowId, eyeHideId) {
                const input = document.getElementById(inputId);
                const eyeShow = document.getElementById(eyeShowId);
                const eyeHide = document.getElementById(eyeHideId);
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeShow.style.display = 'none';
                    eyeHide.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeShow.style.display = 'block';
                    eyeHide.style.display = 'none';
                }
            }
        </script>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;">

        {{-- Kolom Kiri --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Section: Data Pribadi --}}
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
                <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">

                    {{-- NIP --}}
                    <div>
                        <label
                            style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">NIP
                            <span style="color:#ef4444;">*</span></label>
                        <input wire:model="nip" type="text" maxlength="18" placeholder="Masukkan 18 digit NIP"
                            style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('nip') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;box-sizing:border-box;font-family:monospace;letter-spacing:0.05em;"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        @error('nip')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label
                            style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Nama
                            Lengkap <span style="color:#ef4444;">*</span></label>
                        <input wire:model="nama_lengkap" type="text" placeholder="Sesuai dokumen resmi"
                            style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('nama_lengkap') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;box-sizing:border-box;">
                        @error('nama_lengkap')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label
                            style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Jabatan
                            <span style="color:#ef4444;">*</span></label>
                        <input wire:model="jabatan" type="text" placeholder="Jabatan di kantor"
                            style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('jabatan') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;box-sizing:border-box;">
                        @error('jabatan')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No HP + Email --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div>
                            <label
                                style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">No.
                                HP <span style="color:#ef4444;">*</span></label>
                            <input wire:model="no_hp" type="text" maxlength="15" placeholder="08xxxxxxxxxx"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('no_hp') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;box-sizing:border-box;">
                            @error('no_hp')
                                <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Email
                                <span
                                    style="color:#94a3b8;font-weight:400;font-size:0.5625rem;">(opsional)</span></label>
                            <input wire:model="email" type="email" placeholder="email@contoh.com"
                                style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('email') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;box-sizing:border-box;">
                            @error('email')
                                <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- Section: Kata Sandi --}}
            <div style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;overflow:hidden;">
                <div
                    style="padding:0.875rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.625rem;">
                    <div
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:0.875rem;height:0.875rem;color:#1e3a8a;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <p style="font-size:0.8125rem;font-weight:700;color:#1e293b;margin:0;">Kata Sandi</p>
                        <p style="font-size:0.6875rem;color:#94a3b8;margin:0;">Kosongkan jika tidak ingin mengubah</p>
                    </div>
                </div>
                <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">
                    <div>
                        <label
                            style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Kata
                            Sandi <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <input id="pw1" wire:model="password" type="password" placeholder="Min. 8 karakter"
                                style="width:100%;padding:0.5rem 2.25rem 0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('password') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;box-sizing:border-box;">
                            <button type="button" onclick="togglePw('pw1','eye1a','eye1b')"
                                style="position:absolute;right:0.625rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:0;">
                                <svg id="eye1a" style="width:0.875rem;height:0.875rem;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg id="eye1b" style="width:0.875rem;height:0.875rem;display:none;"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Konfirmasi
                            Sandi <span style="color:#ef4444;">*</span></label>
                        <div style="position:relative;">
                            <input id="pw2" wire:model="password_confirmation" type="password"
                                placeholder="Ulangi kata sandi"
                                style="width:100%;padding:0.5rem 2.25rem 0.5rem 0.875rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;box-sizing:border-box;">
                            <button type="button" onclick="togglePw('pw2','eye2a','eye2b')"
                                style="position:absolute;right:0.625rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8;padding:0;">
                                <svg id="eye2a" style="width:0.875rem;height:0.875rem;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg id="eye2b" style="width:0.875rem;height:0.875rem;display:none;"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Kolom Kanan --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Section: Role & Akses --}}
            <div style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;overflow:hidden;">
                <div
                    style="padding:0.875rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.625rem;">
                    <div
                        style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:0.875rem;height:0.875rem;color:#1e3a8a;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <p style="font-size:0.8125rem;font-weight:700;color:#1e293b;margin:0;">Role & Akses</p>
                </div>
                <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">

                    {{-- Role --}}
                    <div>
                        <label
                            style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Role
                            <span style="color:#ef4444;">*</span></label>
                        <select wire:model.live="role"
                            style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('role') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;">
                            <option value="">-- Pilih Role --</option>
                            @foreach ($allowedRoles as $r)
                                <option value="{{ $r }}">
                                    {{ match ($r) {
                                        'admin_kakanwil' => 'Admin Kakanwil',
                                        'admin_kabid_doklan' => 'Kabid Doklan',
                                        'admin_kabid_wasdakim' => 'Kabid Wasdakim',
                                        'admin_kabag_tu' => 'Kabag TU',
                                        'admin_kanwil_doklan' => 'Admin Kanwil Doklan',
                                        'admin_kanwil_wasdakim' => 'Admin Kanwil Wasdakim',
                                        'admin_kanwil_tu' => 'Admin Kanwil TU',
                                        'admin_kanim' => 'Admin Kanim',
                                        'operator_kanim' => 'Operator Kanim',
                                        'operator_tu' => 'Operator TU',
                                        default => $r,
                                    } }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label
                            style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Status
                            Akun</label>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;">
                            @foreach ([
        'aktif' => ['label' => 'Aktif', 'icon' => 'M5 13l4 4L19 7'],
        'nonaktif' => ['label' => 'Nonaktif', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
    ] as $val => $item)
                                <label style="cursor:pointer;">
                                    <input type="radio" wire:model="status" value="{{ $val }}"
                                        style="display:none;">
                                    <div
                                        style="padding:0.5rem;border-radius:0.625rem;text-align:center;font-size:0.75rem;font-weight:600;border:1px solid {{ $status === $val ? '#1e3a8a' : '#e2e8f0' }};background:{{ $status === $val ? '#eff6ff' : 'white' }};color:{{ $status === $val ? '#1e3a8a' : '#64748b' }};transition:all 0.15s;display:flex;align-items:center;justify-content:center;gap:0.375rem;">
                                        <svg style="width:0.875rem;height:0.875rem;flex-shrink:0;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="{{ $item['icon'] }}" />
                                        </svg>
                                        {{ $item['label'] }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            {{-- Section: Penempatan --}}
            @if ($role)
                <div style="background:white;border-radius:0.875rem;border:1px solid #e2e8f0;overflow:hidden;">
                    <div
                        style="padding:0.875rem 1.25rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.625rem;">
                        <div
                            style="width:1.75rem;height:1.75rem;border-radius:0.5rem;background:#eff6ff;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:0.875rem;height:0.875rem;color:#1e3a8a;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </div>
                        <p style="font-size:0.8125rem;font-weight:700;color:#1e293b;margin:0;">Penempatan</p>
                    </div>
                    <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">

                        {{-- Kantor Imigrasi --}}
                        @if (in_array($role, ['operator_kanim', 'admin_kanim']))
                            <div>
                                <label
                                    style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Kantor
                                    Imigrasi <span style="color:#ef4444;">*</span></label>
                                <select wire:model="kanim_id"
                                    style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('kanim_id') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;">
                                    <option value="">-- Pilih Kantor Imigrasi --</option>
                                    @foreach ($kanimList as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kanim }}</option>
                                    @endforeach
                                </select>
                                @error('kanim_id')
                                    <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        @endif

                        {{-- Kantor Wilayah --}}
                        @if (in_array($role, ['admin_kanwil_doklan', 'admin_kanwil_wasdakim', 'admin_kanwil_tu']))
                            <div>
                                <label
                                    style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Kantor
                                    Wilayah <span style="color:#ef4444;">*</span></label>
                                <select wire:model="kanwil_id"
                                    style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('kanwil_id') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;">
                                    <option value="">-- Pilih Kantor Wilayah --</option>
                                    @foreach ($kanwilList as $kw)
                                        <option value="{{ $kw->id }}">{{ $kw->nama_kanwil }}</option>
                                    @endforeach
                                </select>
                                @error('kanwil_id')
                                    <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        @endif

                        {{-- Bidang --}}
                        @if (in_array($role, ['operator_kanim', 'admin_kanwil_doklan', 'admin_kanwil_wasdakim', 'admin_kanwil_tu']))
                            <div>
                                <label
                                    style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Bidang
                                    <span style="color:#ef4444;">*</span></label>
                                @php
                                    $bidangOptions = match ($role) {
                                        'operator_kanim' => ['doklan' => 'Doklan', 'wasdakim' => 'Wasdakim'],
                                        'admin_kanwil_doklan' => ['doklan' => 'Doklan'],
                                        'admin_kanwil_wasdakim' => ['wasdakim' => 'Wasdakim'],
                                        'admin_kanwil_tu' => ['tu' => 'TU'],
                                        default => [],
                                    };
                                @endphp
                                <select wire:model.live="bidang"
                                    style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('bidang') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;">
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach ($bidangOptions as $val => $label)
                                        <option value="{{ $val }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('bidang')
                                    <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        @endif

                        {{-- Jenis Layanan --}}
                        @if ($role === 'operator_kanim' && $bidang && $bidang !== 'tu')
                            <div>
                                <label
                                    style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">Jenis
                                    Layanan <span style="color:#ef4444;">*</span></label>
                                @php
                                    $jenisOptions = match ($bidang) {
                                        'doklan' => ['paspor' => 'Paspor', 'izin_tinggal' => 'Izin Tinggal'],
                                        'wasdakim' => ['pengawasan' => 'Pengawasan', 'penindakan' => 'Penindakan'],
                                        default => [],
                                    };
                                @endphp
                                <select wire:model="jenis_layanan"
                                    style="width:100%;padding:0.5rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('jenis_layanan') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;">
                                    <option value="">-- Pilih Jenis Layanan --</option>
                                    @foreach ($jenisOptions as $val => $label)
                                        <option value="{{ $val }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_layanan')
                                    <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        @endif

                        {{-- Surat Pengajuan --}}
                        <div>
                            <label
                                style="display:block;font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#64748b;margin-bottom:0.375rem;">
                                Surat Pengajuan <span
                                    style="color:#94a3b8;font-weight:400;font-size:0.5625rem;">(opsional, PDF maks.
                                    2MB)</span>
                            </label>
                            <input wire:model="surat_pengajuan" type="file" accept=".pdf"
                                style="width:100%;padding:0.375rem 0.875rem;border-radius:0.625rem;border:1px solid {{ $errors->has('surat_pengajuan') ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;">
                            @error('surat_pengajuan')
                                <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                            @enderror
                            <div wire:loading wire:target="surat_pengajuan"
                                style="font-size:0.625rem;color:#94a3b8;margin:0.25rem 0 0;">Mengupload...</div>
                        </div>

                    </div>
                </div>
            @endif

            {{-- Actions --}}
            <div style="display:flex;gap:0.75rem;">
                <a href="{{ route('admin.users.index') }}"
                    style="flex:1;padding:0.75rem;border-radius:0.75rem;background:white;color:#64748b;font-size:0.875rem;font-weight:600;border:1px solid #e2e8f0;text-decoration:none;text-align:center;display:flex;align-items:center;justify-content:center;gap:0.5rem;">
                    <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </a>
                <button wire:click="simpan"
                    style="flex:2;padding:0.75rem;border-radius:0.75rem;background:#1e3a8a;color:white;font-size:0.875rem;font-weight:700;border:none;cursor:pointer;transition:all 0.15s;display:flex;align-items:center;justify-content:center;gap:0.5rem;"
                    onmouseover="this.style.background='#1a3270'" onmouseout="this.style.background='#1e3a8a'">
                    <span wire:loading.remove wire:target="simpan"
                        style="display:flex;align-items:center;gap:0.5rem;">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Perbarui Data
                    </span>
                    <span wire:loading wire:target="simpan">Menyimpan...</span>
                </button>
            </div>

        </div>
    </div>

</div>
