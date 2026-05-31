<div class="space-y-4">

    {{-- Header --}}
    <div class="rounded-2xl overflow-hidden" style="background:#1E3A8A;">
        <div class="p-5 flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 text-2xl font-black"
                    style="background:#D4AF37;color:#1E3A8A;">
                    {{ strtoupper(substr($layanan->wna?->nama_lengkap ?? 'W', 0, 1)) }}
                </div>
                <div>
                    <p class="text-xl font-black text-white">{{ $layanan->wna?->nama_lengkap ?? '-' }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs"
                            style="color:rgba(255,255,255,0.5);">{{ $layanan->wna?->kewarganegaraan?->nama_negara ?? '-' }}</span>
                        <span style="color:rgba(255,255,255,0.2);">·</span>
                        <span class="text-xs font-mono"
                            style="color:rgba(255,255,255,0.5);">{{ $layanan->wna?->nomor_paspor ?? '-' }}</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('operator.doklan.izin-tinggal.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold shrink-0"
                style="background:rgba(255,255,255,0.12);color:rgba(255,255,255,0.8);"
                onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                onmouseout="this.style.background='rgba(255,255,255,0.12)'">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
        {{-- Quick stats --}}
        <div class="grid grid-cols-3" style="border-top:1px solid rgba(255,255,255,0.1);">
            <div class="px-5 py-3" style="border-right:1px solid rgba(255,255,255,0.1);">
                <p class="text-xs mb-1" style="color:rgba(255,255,255,0.4);">Jenis Layanan</p>
                <p class="text-sm font-bold text-white">{{ $layanan->jenisLayanan?->nama_layanan ?? '-' }}</p>
            </div>
            <div class="px-5 py-3" style="border-right:1px solid rgba(255,255,255,0.1);">
                <p class="text-xs mb-1" style="color:rgba(255,255,255,0.4);">Tanggal Penerbitan</p>
                <p class="text-sm font-bold text-white">
                    {{ $layanan->tanggal_penerbitan?->translatedFormat('d M Y') ?? '-' }}</p>
            </div>
            <div class="px-5 py-3">
                <p class="text-xs mb-1" style="color:rgba(255,255,255,0.4);">Stay Permit Expire</p>
                @php
                    $sisaHari = $layanan->sisa_hari;
                    $isExpired = $sisaHari !== null && $sisaHari < 0;
                    $isEarly = $layanan->isEarlyWarning();
                @endphp
                <p class="text-sm font-bold"
                    style="color:{{ $isExpired ? '#fca5a5' : ($isEarly ? '#fde68a' : 'white') }};">
                    {{ $layanan->stay_permit_expire?->translatedFormat('d M Y') ?? '-' }}
                    @if ($isExpired)
                        <span class="text-xs font-normal">(Expired)</span>
                    @elseif($isEarly)
                        <span class="text-xs font-normal">({{ $sisaHari }} hari)</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Kiri --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Identitas WNA --}}
            <div class="bg-white rounded-2xl" style="border:1px solid #E2E8F0;">
                <div class="px-5 py-3.5 flex items-center gap-2" style="border-bottom:1px solid #F1F5F9;">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background:#1E3A8A;">
                        <svg class="w-3 h-3" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-wider" style="color:#1E3A8A;">Identitas WNA</p>
                </div>
                <div class="p-5 space-y-5">
                    {{-- Nama Lengkap --}}
                    <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                        <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">Nama
                            Lengkap</p>
                        <p class="text-base font-black" style="color:#0F172A;">
                            {{ $layanan->wna?->nama_lengkap ?? '-' }}</p>
                    </div>
                    {{-- Row 1 --}}
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ([['Tempat Lahir', $layanan->wna?->tempat_lahir ?? '-'], ['Tanggal Lahir', $layanan->wna?->tanggal_lahir?->translatedFormat('d F Y') ?? '-'], ['Jenis Kelamin', $layanan->wna?->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan']] as [$label, $val])
                            <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                                <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">
                                    {{ $label }}</p>
                                <p class="text-sm font-bold" style="color:#0F172A;">{{ $val }}</p>
                            </div>
                        @endforeach
                    </div>
                    {{-- Row 2 --}}
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ([['Kewarganegaraan', $layanan->wna?->kewarganegaraan?->nama_negara ?? '-'], ['Nomor Paspor', $layanan->wna?->nomor_paspor ?? '-'], ['Habis Berlaku', $layanan->wna?->paspor_expire?->translatedFormat('d F Y') ?? '-']] as [$label, $val])
                            <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                                <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">
                                    {{ $label }}</p>
                                <p class="text-sm font-bold" style="color:#0F172A;">{{ $val }}</p>
                            </div>
                        @endforeach
                    </div>
                    {{-- Row 3 --}}
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ([['Jabatan', $layanan->wna?->jabatan ?? '-'], ['Aktivitas', $layanan->wna?->aktivitas ?? '-']] as [$label, $val])
                            <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                                <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">
                                    {{ $label }}</p>
                                <p class="text-sm font-bold" style="color:#0F172A;">{{ $val }}</p>
                            </div>
                        @endforeach
                        <div class="col-span-1"></div>
                    </div>
                    {{-- Alamat --}}
                    <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                        <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">Alamat di
                            Indonesia</p>
                        <p class="text-sm font-bold" style="color:#0F172A;">
                            {{ $layanan->wna?->alamat_di_indonesia ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Data Layanan --}}
            <div class="bg-white rounded-2xl" style="border:1px solid #E2E8F0;">
                <div class="px-5 py-3.5 flex items-center gap-2" style="border-bottom:1px solid #F1F5F9;">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background:#D4AF37;">
                        <svg class="w-3 h-3" fill="none" stroke="#1E3A8A" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-wider" style="color:#1E3A8A;">Data Layanan</p>
                </div>
                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2 p-4 rounded-xl" style="background:#F8FAFC;">
                            <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">Jenis
                                Layanan</p>
                            <p class="text-sm font-bold" style="color:#0F172A;">
                                {{ $layanan->jenisLayanan?->nama_layanan ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                            <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">
                                Lokasi</p>
                            <p class="text-sm font-bold" style="color:#0F172A;">
                                {{ $layanan->lokasiLayanan?->nama_lokasi ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                            <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">
                                Permit Number</p>
                            <p class="text-sm font-bold font-mono" style="color:#0F172A;">
                                {{ $layanan->permit_number ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                            <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">Tgl.
                                Penerbitan</p>
                            <p class="text-sm font-bold" style="color:#0F172A;">
                                {{ $layanan->tanggal_penerbitan?->translatedFormat('d F Y') ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-xl"
                            style="background:{{ $isExpired ? '#FEF2F2' : ($isEarly ? '#FFFBEB' : '#F8FAFC') }};">
                            <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">Stay
                                Permit Expire</p>
                            <p class="text-sm font-bold"
                                style="color:{{ $isExpired ? '#DC2626' : ($isEarly ? '#D97706' : '#0F172A') }};">
                                {{ $layanan->stay_permit_expire?->translatedFormat('d F Y') ?? '-' }}
                            </p>
                            @if ($isExpired)
                                <p class="text-xs mt-0.5" style="color:#DC2626;">Sudah expired</p>
                            @elseif($isEarly)
                                <p class="text-xs mt-0.5" style="color:#D97706;">{{ $sisaHari }} hari lagi</p>
                            @endif
                        </div>
                    </div>
                    @if ($layanan->keterangan)
                        <div class="p-4 rounded-xl" style="background:#F8FAFC;">
                            <p class="text-xs font-bold uppercase tracking-widest mb-1.5" style="color:#94A3B8;">
                                Catatan</p>
                            <p class="text-sm" style="color:#475569;">{{ $layanan->keterangan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan --}}
        <div class="space-y-4">

            {{-- Sponsor --}}
            <div class="bg-white rounded-2xl" style="border:1px solid #E2E8F0;">
                <div class="px-5 py-3.5 flex items-center justify-between" style="border-bottom:1px solid #F1F5F9;">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background:#F1F5F9;">
                            <svg class="w-3 h-3" fill="none" stroke="#64748B" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-wider" style="color:#64748B;">Kontak & Sponsor
                        </p>
                    </div>
                    <span class="text-xs italic" style="color:#CBD5E1;">opsional</span>
                </div>
                <div class="p-5 space-y-3">
                    @foreach ([['Nama Sponsor', $layanan->nama_sponsor ?? '-'], ['Nomor Kontak', $layanan->kontak_sponsor ?? '-'], ['Alamat Sponsor', $layanan->alamat_sponsor ?? '-']] as [$label, $val])
                        <div class="p-3.5 rounded-xl" style="background:#F8FAFC;">
                            <p class="text-xs font-bold uppercase tracking-widest mb-1" style="color:#94A3B8;">
                                {{ $label }}</p>
                            <p class="text-sm font-semibold" style="color:#0F172A;">{{ $val }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Info Input --}}
            <div class="bg-white rounded-2xl" style="border:1px solid #E2E8F0;">
                <div class="px-5 py-3.5 flex items-center gap-2" style="border-bottom:1px solid #F1F5F9;">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center" style="background:#F1F5F9;">
                        <svg class="w-3 h-3" fill="none" stroke="#64748B" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-wider" style="color:#64748B;">Info Input</p>
                </div>
                <div class="p-5 space-y-3">
                    <div class="p-3.5 rounded-xl" style="background:#F8FAFC;">
                        <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color:#94A3B8;">Diinput
                            Oleh</p>
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-black shrink-0"
                                style="background:#1E3A8A;color:white;">
                                {{ strtoupper(substr($layanan->operator?->nama_lengkap ?? 'O', 0, 1)) }}
                            </div>
                            <p class="text-sm font-semibold" style="color:#0F172A;">
                                {{ $layanan->operator?->nama_lengkap ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="p-3.5 rounded-xl" style="background:#F8FAFC;">
                        <p class="text-xs font-bold uppercase tracking-widest mb-1" style="color:#94A3B8;">Tanggal
                            Input</p>
                        <p class="text-sm font-semibold" style="color:#0F172A;">
                            {{ $layanan->created_at?->translatedFormat('d F Y') ?? '-' }}</p>
                        <p class="text-xs mt-0.5" style="color:#94A3B8;">{{ $layanan->created_at?->format('H:i') }}
                            WIB</p>
                    </div>
                </div>
            </div>

            {{-- Tombol Edit --}}
            @if ($layanan->status === 'disubmit')
                <a href="{{ route('operator.doklan.izin-tinggal.edit', $layanan->id) }}"
                    class="flex items-center justify-center gap-2 w-full py-3 rounded-xl text-sm font-bold"
                    style="background:#D4AF37;color:#1E3A8A;" onmouseover="this.style.opacity='0.9'"
                    onmouseout="this.style.opacity='1'">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Data
                </a>
            @endif

        </div>
    </div>

</div>
