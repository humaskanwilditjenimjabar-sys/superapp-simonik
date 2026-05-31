{{-- Modal Form Input --}}
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:0.875rem;font-weight:700;color:white;margin:0;">Input Layanan Paspor
                        </p>
                        <p style="font-size:0.625rem;color:rgba(255,255,255,0.55);margin:0.1rem 0 0;">
                            {{ auth()->user()->kanim?->nama_kanim }}</p>
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
                {{-- Tanggal --}}
                <div>
                    <label
                        style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">
                        Tanggal <span style="color:#ef4444;">*</span>
                        <span style="color:#94a3b8;font-weight:400;">(hari ini atau kemarin)</span>
                    </label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;">
                        @php
                            $tanggalOptions = [
                                today()->toDateString() => [
                                    'label' => 'Hari Ini',
                                    'sub' => today()->translatedFormat('d M Y'),
                                    'sudah' => $sudahInputHariIni,
                                ],
                                today()->subDay()->toDateString() => [
                                    'label' => 'Kemarin',
                                    'sub' => today()->subDay()->translatedFormat('d M Y'),
                                    'sudah' => $sudahInputKemarin,
                                ],
                            ];
                        @endphp
                        {{-- @php
                            $tanggalOptions = [
                                today()->toDateString() => [
                                    'label' => 'Hari Ini',
                                    'sub' => today()->translatedFormat('d M Y'),
                                    'sudah' => false,
                                ],
                                today()->subDay()->toDateString() => [
                                    'label' => 'Kemarin',
                                    'sub' => today()->subDay()->translatedFormat('d M Y'),
                                    'sudah' => false,
                                ],
                            ];
                        @endphp --}}
                        @foreach ($tanggalOptions as $val => $opt)
                            <button type="button"
                                @if (!$opt['sudah']) wire:click="setFormTanggal('{{ $val }}')" @endif
                                style="padding:0.625rem;border-radius:0.625rem;text-align:center;font-size:0.75rem;font-weight:600;border:1.5px solid {{ $formTanggal === $val ? '#1e3a8a' : '#e2e8f0' }};background:{{ $opt['sudah'] ? '#f8fafc' : ($formTanggal === $val ? '#eff6ff' : 'white') }};color:{{ $opt['sudah'] ? '#94a3b8' : ($formTanggal === $val ? '#1e3a8a' : '#64748b') }};cursor:{{ $opt['sudah'] ? 'not-allowed' : 'pointer' }};transition:all 0.15s;width:100%;">
                                <p style="margin:0;font-weight:700;">{{ $opt['label'] }}</p>
                                <p style="margin:0.125rem 0 0;font-size:0.625rem;font-weight:400;opacity:0.7;">
                                    {{ $opt['sub'] }}</p>
                                @if ($opt['sudah'])
                                    <p style="margin:0.125rem 0 0;font-size:0.5625rem;color:#16a34a;">✓ Sudah
                                        diinput</p>
                                @endif
                            </button>
                        @endforeach
                    </div>
                    @if (isset($formErrors['tanggal']))
                        <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">
                            {{ $formErrors['tanggal'] }}</p>
                    @endif
                </div>
                {{-- Lokasi --}}
                <div>
                    <label
                        style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">Lokasi
                        Layanan <span style="color:#ef4444;">*</span></label>
                    <select wire:model="formLokasi"
                        style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid {{ isset($formErrors['lokasi']) ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach ($lokasiList as $l)
                            <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                        @endforeach
                    </select>
                    @if (isset($formErrors['lokasi']))
                        <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">
                            {{ $formErrors['lokasi'] }}</p>
                    @endif
                </div>
                {{-- Jenis --}}
                <div>
                    <label
                        style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">Jenis
                        Layanan <span style="color:#ef4444;">*</span></label>
                    <select wire:model="formJenis"
                        style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid {{ isset($formErrors['jenis']) ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;">
                        <option value="">-- Pilih Jenis Layanan --</option>
                        @foreach ($jenisList as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_layanan }}</option>
                        @endforeach
                    </select>
                    @if (isset($formErrors['jenis']))
                        <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">{{ $formErrors['jenis'] }}
                        </p>
                    @endif
                </div>
                {{-- Jumlah --}}
                <div>
                    <label
                        style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">Jumlah
                        <span style="color:#ef4444;">*</span></label>
                    <input type="number" wire:model="formJumlah" min="1" max="9999"
                        oninput="if(this.value>9999)this.value=9999;if(this.value<1&&this.value!=='')this.value=1;"
                        placeholder="Masukkan jumlah (1-9999)"
                        style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid {{ isset($formErrors['jumlah']) ? '#fca5a5' : '#e2e8f0' }};font-size:0.8125rem;outline:none;box-sizing:border-box;">
                    @if (isset($formErrors['jumlah']))
                        <p style="font-size:0.625rem;color:#dc2626;margin:0.25rem 0 0;">
                            {{ $formErrors['jumlah'] }}</p>
                    @endif
                </div>
                {{-- Keterangan --}}
                <div>
                    <label
                        style="font-size:0.6875rem;font-weight:600;color:#374151;display:block;margin-bottom:0.375rem;">Keterangan
                        <span style="color:#94a3b8;font-weight:400;">(opsional)</span></label>
                    <textarea wire:model="formKeterangan" rows="2"
                        style="width:100%;padding:0.5rem 0.75rem;border-radius:0.625rem;border:1px solid #e2e8f0;font-size:0.8125rem;outline:none;background:white;box-sizing:border-box;resize:none;"
                        placeholder="Catatan tambahan..."></textarea>
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
                    <span wire:loading.remove wire:target="simpan" style="display:flex;align-items:center;gap:0.5rem;">
                        <svg style="width:0.875rem;height:0.875rem;" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Simpan
                    </span>
                    <span wire:loading wire:target="simpan">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
@endif
