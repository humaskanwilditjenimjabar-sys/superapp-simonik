@if ($showView && $viewData)
    <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);"
        wire:click.self="closeView">
        <div
            style="background:white;border-radius:1rem;width:100%;max-width:32rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;">

            {{-- Header --}}
            <div
                style="background:linear-gradient(135deg,#1E3A8A,#1a3270);padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <div
                        style="width:2rem;height:2rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                        <svg style="width:1rem;height:1rem;" fill="none" stroke="white" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">Detail Layanan Paspor</p>
                        <p style="font-size:0.625rem;color:rgba(255,255,255,0.55);margin:0.1rem 0 0;">
                            {{ $viewData->created_at->translatedFormat('d F Y, H:i') }} WIB
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

            {{-- Body --}}
            <div style="padding:1.25rem;display:flex;flex-direction:column;gap:0.75rem;">

                {{-- Jumlah besar di atas --}}
                <div
                    style="background:#eff6ff;border-radius:0.875rem;padding:1.25rem;text-align:center;border:1px solid #bfdbfe;">
                    <p
                        style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#1e3a8a;opacity:0.6;margin:0 0 0.25rem;">
                        Jumlah Paspor</p>
                    <p style="font-size:2.5rem;font-weight:800;color:#1e3a8a;margin:0;line-height:1;">
                        {{ number_format($viewData->jumlah) }}</p>
                    <p style="font-size:0.75rem;color:#1e3a8a;opacity:0.5;margin:0.25rem 0 0;">layanan</p>
                </div>

                {{-- Detail grid --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.625rem;">
                    <div style="background:#f8fafc;border-radius:0.75rem;padding:0.875rem;">
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                            Tanggal Layanan</p>
                        <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                            {{ \Carbon\Carbon::parse($viewData->tanggal)->translatedFormat('d F Y') }}
                        </p>
                        <p style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;">
                            {{ \Carbon\Carbon::parse($viewData->tanggal)->translatedFormat('l') }}
                        </p>
                    </div>
                    <div style="background:#f8fafc;border-radius:0.75rem;padding:0.875rem;">
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                            Jenis Layanan</p>
                        <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                            {{ $viewData->jenisLayanan?->nama_layanan ?? '-' }}
                        </p>
                    </div>
                    <div style="background:#f8fafc;border-radius:0.75rem;padding:0.875rem;">
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                            Lokasi Layanan</p>
                        <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                            {{ $viewData->lokasiLayanan?->nama_lokasi ?? '-' }}
                        </p>
                    </div>
                    <div style="background:#f8fafc;border-radius:0.75rem;padding:0.875rem;">
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                            Diinput Oleh</p>
                        <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                            {{ $viewData->operator?->nama_lengkap ?? '-' }}
                        </p>
                        <p style="font-size:0.6875rem;color:#94a3b8;margin:0.125rem 0 0;">
                            {{ $viewData->created_at->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>
                </div>

                {{-- Keterangan --}}
                @if ($viewData->keterangan)
                    <div style="background:#f8fafc;border-radius:0.75rem;padding:0.875rem;">
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.375rem;">
                            Keterangan</p>
                        <p style="font-size:0.8125rem;color:#475569;margin:0;line-height:1.5;">
                            {{ $viewData->keterangan }}</p>
                    </div>
                @endif

                {{-- Info tambahan --}}
                <div
                    style="background:#f8fafc;border-radius:0.75rem;padding:0.875rem;display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                            Terakhir Diperbarui</p>
                        <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                            {{ $viewData->updated_at->translatedFormat('d F Y, H:i') }} WIB
                        </p>
                    </div>
                    {{-- <div style="text-align:right;">
                        <p
                            style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                            ID Record</p>
                        <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;font-family:monospace;">
                            #{{ str_pad($viewData->id, 6, '0', STR_PAD_LEFT) }}
                        </p>
                    </div> --}}
                </div>

                {{-- Notif tidak bisa edit --}}
                <div
                    style="background:#fffbeb;border-radius:0.75rem;padding:0.75rem 1rem;display:flex;align-items:center;gap:0.625rem;border:1px solid #fde68a;">
                    <svg style="width:1rem;height:1rem;color:#d97706;flex-shrink:0;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <p style="font-size:0.75rem;color:#92400e;margin:0;">Data tidak dapat diedit. Hubungi Admin Kanwil
                        jika perlu perubahan.</p>
                </div>

            </div>

            {{-- Footer --}}
            <div style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;">
                <button wire:click="closeView"
                    style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#1e3a8a;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;display:flex;align-items:center;gap:0.5rem;">
                    <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tutup
                </button>
            </div>

        </div>
    </div>
@endif
