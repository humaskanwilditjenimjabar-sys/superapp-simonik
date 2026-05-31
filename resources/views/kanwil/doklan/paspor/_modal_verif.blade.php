 {{-- Modal Verifikasi (kabid only) --}}
 @if ($showVerif)
     @php $isApprove = $verifAksi === 'terverifikasi'; @endphp
     <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);padding:1rem;"
         wire:click.self="closeVerif">
         <div
             style="background:white;border-radius:1rem;width:100%;max-width:28rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;">
             <div
                 style="background:{{ $isApprove ? 'linear-gradient(135deg,#15803d,#166534)' : 'linear-gradient(135deg,#dc2626,#b91c1c)' }};padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;">
                 <div style="display:flex;align-items:center;gap:0.625rem;">
                     <div
                         style="width:2rem;height:2rem;border-radius:0.5rem;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                         <svg style="width:1rem;height:1rem;" fill="none" stroke="white" viewBox="0 0 24 24"
                             stroke-width="2.5">
                             @if ($isApprove)
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                             @else
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                             @endif
                         </svg>
                     </div>
                     <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">
                         {{ $isApprove ? 'Verifikasi Data' : 'Tolak Data' }}</p>
                 </div>
                 <button wire:click="closeVerif"
                     style="background:rgba(255,255,255,0.15);border:none;cursor:pointer;width:1.75rem;height:1.75rem;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:white;">
                     <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2.5">
                         <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>
             <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">
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
                         style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">
                         {{ $isApprove ? 'Catatan' : 'Alasan Penolakan' }}
                         @if (!$isApprove)
                             <span style="color:#ef4444;">*</span>
                         @endif
                         @if ($isApprove)
                             <span style="color:#94a3b8;font-weight:400;">(opsional)</span>
                         @endif
                     </label>
                     <textarea wire:model="verifCatatan" rows="3"
                         placeholder="{{ $isApprove ? 'Catatan verifikasi...' : 'Tulis alasan penolakan...' }}"
                         style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;resize:vertical;"
                         onfocus="this.style.borderColor='{{ $isApprove ? '#16a34a' : '#dc2626' }}'"
                         onblur="this.style.borderColor='#e2e8f0'"></textarea>
                     @error('verifCatatan')
                         <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                     @enderror
                 </div>
             </div>
             <div
                 style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;gap:0.625rem;justify-content:flex-end;">
                 <button wire:click="closeVerif"
                     style="padding:0.5rem 1.25rem;border-radius:0.625rem;background:#f8fafc;color:#64748b;font-size:0.8125rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;">
                     Batal
                 </button>
                 <button wire:click="simpanVerif"
                     style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:{{ $isApprove ? '#16a34a' : '#dc2626' }};color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">
                     <span wire:loading.remove wire:target="simpanVerif"
                         style="display:flex;align-items:center;gap:0.5rem;">
                         <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2.5">
                             @if ($isApprove)
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                             @else
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                             @endif
                         </svg>
                         {{ $isApprove ? 'Ya, Verifikasi' : 'Ya, Tolak' }}
                     </span>
                     <span wire:loading wire:target="simpanVerif">Memproses...</span>
                 </button>
             </div>
         </div>
     </div>
 @endif
