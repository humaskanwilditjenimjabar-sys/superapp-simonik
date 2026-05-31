    {{-- Modal Tambah/Edit --}}
    @if ($showForm)
        <div style="position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.45);"
            wire:click.self="closeForm">
            <div
                style="background:white;border-radius:1rem;width:100%;max-width:30rem;box-shadow:0 20px 60px rgba(0,0,0,0.2);overflow:hidden;">
                <div
                    style="background:linear-gradient(135deg,#1E3A8A,#1a3270);padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;">
                    <div style="display:flex;align-items:center;gap:0.625rem;">
                        <div
                            style="width:2rem;height:2rem;border-radius:0.5rem;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;">
                            <svg style="width:1rem;height:1rem;" fill="none" stroke="white" viewBox="0 0 24 24"
                                stroke-width="2">
                                @if ($formId)
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                @endif
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">
                                {{ $formId ? 'Edit Data Paspor' : 'Tambah Data Paspor' }}</p>
                            <p style="font-size:0.625rem;color:rgba(255,255,255,0.55);margin:0.1rem 0 0;">Kanwil
                                Ditjenim Jabar</p>
                        </div>
                    </div>
                    <button wire:click="closeForm"
                        style="background:rgba(255,255,255,0.1);border:none;cursor:pointer;width:1.75rem;height:1.75rem;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;color:white;">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div style="padding:1.25rem;display:flex;flex-direction:column;gap:1rem;">
                    {{-- Kanim --}}
                    <div>
                        <label
                            style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">
                            Kantor Imigrasi <span style="color:#ef4444;">*</span>
                        </label>
                        @if ($formId)
                            {{-- Edit: tampilkan nama kanim, tidak bisa diubah --}}
                            <div
                                style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;color:#64748b;background:#f8fafc;">
                                {{ $kanims->firstWhere('id', $formKanim)?->nama_kanim ?? '-' }}
                            </div>
                            <input type="hidden" wire:model="formKanim">
                        @else
                            {{-- Tambah: dropdown pilih kanim --}}
                            <select wire:model.live="formKanim"
                                style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                                <option value="">-- Pilih Kanim --</option>
                                @foreach ($kanims as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kanim }}</option>
                                @endforeach
                            </select>
                        @endif
                        @error('formKanim')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Tanggal --}}
                    <div>
                        <label
                            style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">
                            Tanggal <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="date" wire:model="formTanggal"
                            style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                        @error('formTanggal')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Lokasi + Jenis --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.875rem;">
                        <div>
                            <label
                                style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">
                                Lokasi Layanan <span style="color:#ef4444;">*</span>
                            </label>
                            <select wire:model="formLokasi"
                                style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                                <option value="">-- Pilih --</option>
                                @foreach ($lokasis as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                                @endforeach
                            </select>
                            @error('formLokasi')
                                <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">
                                Jenis Layanan <span style="color:#ef4444;">*</span>
                            </label>
                            <select wire:model="formJenis"
                                style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;"
                                onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                                <option value="">-- Pilih --</option>
                                @foreach ($jenisLayanan as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_layanan }}</option>
                                @endforeach
                            </select>
                            @error('formJenis')
                                <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- Jumlah --}}
                    <div>
                        <label
                            style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">
                            Jumlah <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="number" wire:model="formJumlah" min="1" max="9999"
                            oninput="if(this.value>9999)this.value=9999;if(this.value<1&&this.value!=='')this.value=1;"
                            placeholder="Masukkan jumlah (1-9999)"
                            style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'">
                        @error('formJumlah')
                            <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Keterangan --}}
                    <div>
                        <label
                            style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">
                            Keterangan <span style="color:#94a3b8;font-weight:400;">(opsional)</span>
                        </label>
                        <textarea wire:model="formKeterangan" rows="2" placeholder="Catatan tambahan..."
                            style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;resize:none;"
                            onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                    </div>
                </div>
                <div
                    style="padding:0.875rem 1.25rem;border-top:1px solid #f1f5f9;display:flex;gap:0.625rem;justify-content:flex-end;">
                    <button wire:click="closeForm"
                        style="padding:0.5rem 1.25rem;border-radius:0.625rem;background:#f8fafc;color:#64748b;font-size:0.8125rem;font-weight:600;border:1px solid #e2e8f0;cursor:pointer;display:flex;align-items:center;gap:0.375rem;">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </button>
                    <button wire:click="simpan"
                        style="padding:0.5rem 1.5rem;border-radius:0.625rem;background:#1e3a8a;color:white;font-size:0.8125rem;font-weight:600;border:none;cursor:pointer;">
                        <span wire:loading.remove wire:target="simpan"
                            style="display:flex;align-items:center;gap:0.5rem;">
                            <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $formId ? 'Simpan Perubahan' : 'Tambah Data' }}
                        </span>
                        <span wire:loading wire:target="simpan">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
