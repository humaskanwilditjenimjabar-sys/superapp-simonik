 {{-- Modal View Detail + History --}}
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
                                 d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                             <path stroke-linecap="round" stroke-linejoin="round"
                                 d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                         </svg>
                     </div>
                     <div>
                         <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">Detail Data Paspor</p>
                         <p style="font-size:0.625rem;color:rgba(255,255,255,0.55);margin:0.1rem 0 0;">ID
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
             <div style="padding:1.25rem;overflow-y:auto;display:flex;flex-direction:column;gap:0.75rem;">
                 <div
                     style="background:#eff6ff;border-radius:0.875rem;padding:1.25rem;text-align:center;border:1px solid #bfdbfe;">
                     <p
                         style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#1e3a8a;opacity:0.6;margin:0 0 0.25rem;">
                         Jumlah Paspor</p>
                     <p style="font-size:2.5rem;font-weight:800;color:#1e3a8a;margin:0;line-height:1;">
                         {{ number_format($viewData->jumlah) }}</p>
                     <p style="font-size:0.75rem;color:#1e3a8a;opacity:0.5;margin:0.25rem 0 0;">layanan</p>
                 </div>
                 <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.625rem;">
                     @foreach ([['label' => 'Tanggal', 'value' => $viewData->tanggal->translatedFormat('l, d F Y')], ['label' => 'Kanim', 'value' => $viewData->kanim?->nama_kanim ?? '-'], ['label' => 'Lokasi Layanan', 'value' => $viewData->lokasiLayanan?->nama_lokasi ?? '-'], ['label' => 'Jenis Layanan', 'value' => $viewData->jenisLayanan?->nama_layanan ?? '-'], ['label' => 'Diinput Oleh', 'value' => $viewData->operator?->nama_lengkap ?? '(Kanwil)'], ['label' => 'Waktu Input', 'value' => $viewData->created_at->translatedFormat('d M Y, H:i')]] as $info)
                         <div style="background:#f8fafc;border-radius:0.75rem;padding:0.875rem;">
                             <p
                                 style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#94a3b8;margin:0 0 0.25rem;">
                                 {{ $info['label'] }}</p>
                             <p style="font-size:0.8125rem;font-weight:600;color:#1e293b;margin:0;">
                                 {{ $info['value'] }}</p>
                         </div>
                     @endforeach
                 </div>
                 {{-- Status --}}
                 <div
                     style="display:flex;align-items:center;justify-content:space-between;padding:0.875rem 1rem;border-radius:0.75rem;border:1px solid #e2e8f0;background:#f8fafc;">
                     <span style="font-size:0.75rem;font-weight:600;color:#475569;">Status Saat Ini</span>
                     @php
                         $stStyle = match ($viewData->status) {
                             'terverifikasi' => 'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;',
                             'disubmit' => 'background:#fffbeb;color:#d97706;border:1px solid #fde68a;',
                             'ditolak' => 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;',
                             default => 'background:#f8fafc;color:#64748b;border:1px solid #e2e8f0;',
                         };
                         $stLabel = match ($viewData->status) {
                             'terverifikasi' => 'Terverifikasi',
                             'disubmit' => 'Menunggu Verifikasi',
                             'ditolak' => 'Ditolak',
                             default => $viewData->status,
                         };
                     @endphp
                     <span
                         style="padding:0.3125rem 0.875rem;border-radius:9999px;font-size:0.75rem;font-weight:700;{{ $stStyle }}">{{ $stLabel }}</span>
                 </div>
                 {{-- Keterangan --}}
                 @if ($viewData->keterangan)
                     <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:0.75rem;padding:0.875rem;">
                         <p
                             style="font-size:0.625rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#d97706;margin:0 0 0.25rem;">
                             Keterangan</p>
                         <p style="font-size:0.8125rem;color:#92400e;margin:0;">{{ $viewData->keterangan }}</p>
                     </div>
                 @endif
                 {{-- Riwayat verifikasi --}}
                 @if ($viewData->riwayat_verifikasi && count($viewData->riwayat_verifikasi) > 0)
                     <div>
                         <p
                             style="font-size:0.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#64748b;margin:0 0 0.75rem;">
                             Riwayat Verifikasi ({{ count($viewData->riwayat_verifikasi) }})
                         </p>
                         <div style="display:flex;flex-direction:column;gap:0.5rem;">
                             @foreach (array_reverse($viewData->riwayat_verifikasi) as $riwayat)
                                 <div style="display:flex;gap:0.75rem;align-items:flex-start;">
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
                                     <div
                                         style="flex:1;background:#f8fafc;border-radius:0.625rem;padding:0.625rem 0.875rem;border:1px solid #f1f5f9;">
                                         <div
                                             style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.2rem;">
                                             <span
                                                 style="font-size:0.75rem;font-weight:700;color:{{ $riwayat['aksi'] === 'terverifikasi' ? '#16a34a' : '#dc2626' }};">
                                                 {{ $riwayat['aksi'] === 'terverifikasi' ? 'Diverifikasi' : 'Ditolak' }}
                                             </span>
                                             <span
                                                 style="font-size:0.625rem;color:#94a3b8;">{{ \Carbon\Carbon::parse($riwayat['at'])->translatedFormat('d M Y, H:i') }}</span>
                                         </div>
                                         <p style="font-size:0.6875rem;color:#64748b;margin:0;">oleh
                                             <strong>{{ $riwayat['nama'] }}</strong>
                                         </p>
                                         @if ($riwayat['catatan'])
                                             <p
                                                 style="font-size:0.75rem;color:#475569;margin:0.375rem 0 0;padding:0.375rem 0.625rem;background:white;border-radius:0.375rem;border:1px solid #e2e8f0;font-style:italic;">
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
             <div
                 style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;flex-shrink:0;">
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
