<div class="space-y-5">

    {{-- Header --}}
    <div class="rounded-2xl p-5 flex items-center gap-4" style="background:#1E3A8A;">
        <a href="{{ route('operator.doklan.izin-tinggal.index') }}"
            class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 cursor-pointer"
            style="background:rgba(255,255,255,0.15);" onmouseover="this.style.background='rgba(255,255,255,0.25)'"
            onmouseout="this.style.background='rgba(255,255,255,0.15)'">
            <svg class="w-4 h-4" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <p class="text-lg font-bold text-white">
                {{ $editId ? 'Edit Layanan Izin Tinggal' : 'Input Layanan Izin Tinggal' }}
            </p>
            <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.55);">
                {{ auth()->user()->kanim?->nama_kanim ?? 'Kantor Imigrasi' }} · {{ today()->translatedFormat('d F Y') }}
            </p>
        </div>
    </div>

    {{-- Section 1: Identitas WNA — open by default --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;" x-data="{ open: true }">
        <div class="px-5 py-4 flex items-center gap-3 cursor-pointer select-none" style="background:#1E3A8A;"
            @click="open = !open">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background:#D4AF37;">
                <span style="font-size:0.875rem;font-weight:800;color:#1E3A8A;">1</span>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-white">Identitas WNA</p>
                <p class="text-xs" style="color:rgba(255,255,255,0.55);">Nama lengkap, paspor, kewarganegaraan, dan data
                    diri</p>
            </div>
            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none"
                stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2">
            <div class="p-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    {{-- Nama Lengkap --}}
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Nama Lengkap <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" wire:model="wNamaLengkap" placeholder="Nama lengkap sesuai paspor"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        @error('wNamaLengkap')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Tempat Lahir <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" wire:model="wTempatLahir" placeholder="Tempat lahir"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        @error('wTempatLahir')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Tanggal Lahir <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="date" wire:model="wTanggalLahir"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        @error('wTanggalLahir')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Jenis Kelamin <span style="color:#ef4444;">*</span>
                        </label>
                        <div style="position:relative;">
                            <select wire:model="wJenisKelamin"
                                class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none appearance-none"
                                style="border-color:#E2E8F0;color:#1E293B;background:white;padding-right:2.5rem;"
                                onfocus="this.style.borderColor='#1E3A8A'" onblur="this.style.borderColor='#E2E8F0'">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div
                                style="position:absolute;right:0.875rem;top:50%;transform:translateY(-50%);pointer-events:none;">
                                <svg style="width:0.875rem;height:0.875rem;color:#94A3B8;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('wJenisKelamin')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kewarganegaraan (Alpine dropdown search) --}}
                    <div x-data="{
                        open: false,
                        search: '',
                        selected: '{{ $wKewarganegaraan }}',
                        selectedLabel: '{{ $negaraList->firstWhere('id', $wKewarganegaraan)?->nama_negara ?? '' }}',
                        options: {{ Js::from($negaraList->map(fn($n) => ['id' => (string) $n->id, 'label' => $n->nama_negara])) }},
                        get filtered() {
                            if (!this.search) return this.options;
                            const q = this.search.toLowerCase();
                            return this.options.filter(o => o.label.toLowerCase().includes(q));
                        },
                        choose(id, label) {
                            this.selected = id;
                            this.selectedLabel = label;
                            this.open = false;
                            this.search = '';
                            $wire.set('wKewarganegaraan', id);
                        }
                    }" style="position:relative;" @click.stop>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Kewarganegaraan <span style="color:#ef4444;">*</span>
                        </label>
                        <button type="button" @click.stop="open = !open"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none text-left flex items-center justify-between"
                            style="background:white;" :style="open ? 'border-color:#1E3A8A' : 'border-color:#E2E8F0'">
                            <span x-text="selectedLabel || '-- Pilih Negara --'"
                                :style="!selectedLabel ? 'color:#94A3B8' : 'color:#1E293B'"></span>
                            <svg style="width:0.875rem;height:0.875rem;color:#94A3B8;flex-shrink:0;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.outside="open = false; search = ''"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            style="position:absolute;z-index:9999;width:100%;background:white;border:1px solid #E2E8F0;border-radius:0.75rem;box-shadow:0 10px 30px rgba(0,0,0,0.1);margin-top:0.25rem;overflow:hidden;">
                            <div style="padding:0.5rem;border-bottom:1px solid #F1F5F9;">
                                <div style="position:relative;">
                                    <div
                                        style="position:absolute;left:0.625rem;top:50%;transform:translateY(-50%);pointer-events:none;">
                                        <svg style="width:0.875rem;height:0.875rem;color:#94A3B8;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" x-model="search" @click.stop placeholder="Cari negara..."
                                        style="width:100%;padding:0.375rem 0.625rem 0.375rem 2rem;border:1px solid #E2E8F0;border-radius:0.5rem;font-size:0.8125rem;outline:none;box-sizing:border-box;"
                                        onfocus="this.style.borderColor='#1E3A8A'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                            </div>
                            <div style="max-height:200px;overflow-y:auto;">
                                <template x-if="filtered.length === 0">
                                    <div
                                        style="padding:0.75rem 1rem;font-size:0.8125rem;color:#94A3B8;text-align:center;">
                                        Tidak ditemukan</div>
                                </template>
                                <template x-for="opt in filtered" :key="opt.id">
                                    <div style="border-bottom:1px solid #F8FAFC;">
                                        <button type="button" @click="choose(opt.id, opt.label)" x-text="opt.label"
                                            :style="opt.id === selected ?
                                                'width:100%;display:block;text-align:left;padding:0.625rem 1rem;font-size:0.8125rem;font-weight:600;color:#1E3A8A;background:#EFF6FF;border:none;cursor:pointer;' :
                                                'width:100%;display:block;text-align:left;padding:0.625rem 1rem;font-size:0.8125rem;color:#374151;background:white;border:none;cursor:pointer;'"
                                            @mouseover="$el.style.background = opt.id === selected ? '#EFF6FF' : '#F8FAFC'"
                                            @mouseout="$el.style.background = opt.id === selected ? '#EFF6FF' : 'white'">
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        @error('wKewarganegaraan')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nomor Paspor (auto uppercase) --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Nomor Paspor <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" wire:model="wNomorPaspor" placeholder="AB 123456"
                            oninput="this.value = this.value.toUpperCase(); $wire.set('wNomorPaspor', this.value)"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        <p class="text-xs mt-1" style="color:#94A3B8;">Format: 1-2 huruf diikuti 6-7 angka</p>
                        @error('wNomorPaspor')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Habis Berlaku Paspor --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Habis Berlaku Paspor <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="date" wire:model="wPasporExpire"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        @error('wPasporExpire')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Jabatan <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" wire:model="wJabatan" placeholder="Jabatan / posisi"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        @error('wJabatan')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Aktivitas --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Aktivitas <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" wire:model="wAktivitas" placeholder="Kegiatan / aktivitas"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        @error('wAktivitas')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Alamat di Indonesia --}}
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Alamat di Indonesia <span style="color:#ef4444;">*</span>
                        </label>
                        <textarea wire:model="wAlamat" rows="2" placeholder="Alamat WNA selama di Indonesia"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none resize-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'"></textarea>
                        @error('wAlamat')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Section 2: Data Layanan — open by default --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;" x-data="{ open: true }">
        <div class="px-5 py-4 flex items-center gap-3 cursor-pointer select-none" style="background:#1E3A8A;"
            @click="open = !open">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background:#D4AF37;">
                <span style="font-size:0.875rem;font-weight:800;color:#1E3A8A;">2</span>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-white">Izin Tinggal</p>
                <p class="text-xs" style="color:rgba(255,255,255,0.55);">Jenis layanan, permit number, tanggal
                    penerbitan & expire</p>
            </div>
            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none"
                stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2">
            <div class="p-5">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    {{-- Jenis Layanan (Alpine dropdown search) --}}
                    <div x-data="{
                        open: false,
                        search: '',
                        selected: '{{ $formJenis }}',
                        selectedLabel: '{{ $jenisList->firstWhere('id', $formJenis)?->nama_layanan ?? '' }}',
                        options: {{ Js::from($jenisList->map(fn($j) => ['id' => (string) $j->id, 'label' => $j->nama_layanan])) }},
                        get filtered() {
                            if (!this.search) return this.options;
                            const q = this.search.toLowerCase();
                            return this.options.filter(o => o.label.toLowerCase().includes(q));
                        },
                        choose(id, label) {
                            this.selected = id;
                            this.selectedLabel = label;
                            this.open = false;
                            this.search = '';
                            $wire.set('formJenis', id);
                        }
                    }" style="position:relative;" @click.stop>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Jenis Layanan <span style="color:#ef4444;">*</span>
                        </label>
                        <button type="button" @click.stop="open = !open"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none text-left flex items-center justify-between"
                            style="background:white;" :style="open ? 'border-color:#1E3A8A' : 'border-color:#E2E8F0'">
                            <span x-text="selectedLabel || '-- Pilih Jenis Layanan --'"
                                :style="!selectedLabel ? 'color:#94A3B8' : 'color:#1E293B'"></span>
                            <svg style="width:0.875rem;height:0.875rem;color:#94A3B8;flex-shrink:0;" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" @click.outside="open = false; search = ''"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            style="position:absolute;z-index:9999;width:100%;background:white;border:1px solid #E2E8F0;border-radius:0.75rem;box-shadow:0 10px 30px rgba(0,0,0,0.1);margin-top:0.25rem;overflow:hidden;">
                            <div style="padding:0.5rem;border-bottom:1px solid #F1F5F9;">
                                <div style="position:relative;">
                                    <div
                                        style="position:absolute;left:0.625rem;top:50%;transform:translateY(-50%);pointer-events:none;">
                                        <svg style="width:0.875rem;height:0.875rem;color:#94A3B8;" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" x-model="search" @click.stop
                                        placeholder="Cari jenis layanan..."
                                        style="width:100%;padding:0.375rem 0.625rem 0.375rem 2rem;border:1px solid #E2E8F0;border-radius:0.5rem;font-size:0.8125rem;outline:none;box-sizing:border-box;"
                                        onfocus="this.style.borderColor='#1E3A8A'"
                                        onblur="this.style.borderColor='#E2E8F0'">
                                </div>
                            </div>
                            <div style="max-height:200px;overflow-y:auto;">
                                <template x-if="filtered.length === 0">
                                    <div
                                        style="padding:0.75rem 1rem;font-size:0.8125rem;color:#94A3B8;text-align:center;">
                                        Tidak ditemukan</div>
                                </template>
                                <template x-for="opt in filtered" :key="opt.id">
                                    <div style="border-bottom:1px solid #F8FAFC;">
                                        <button type="button" @click="choose(opt.id, opt.label)" x-text="opt.label"
                                            :style="opt.id === selected ?
                                                'width:100%;display:block;text-align:left;padding:0.625rem 1rem;font-size:0.8125rem;font-weight:600;color:#1E3A8A;background:#EFF6FF;border:none;cursor:pointer;' :
                                                'width:100%;display:block;text-align:left;padding:0.625rem 1rem;font-size:0.8125rem;color:#374151;background:white;border:none;cursor:pointer;'"
                                            @mouseover="$el.style.background = opt.id === selected ? '#EFF6FF' : '#F8FAFC'"
                                            @mouseout="$el.style.background = opt.id === selected ? '#EFF6FF' : 'white'">
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        @error('formJenis')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lokasi Layanan --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Lokasi Layanan <span style="color:#ef4444;">*</span>
                        </label>
                        <div style="position:relative;">
                            <select wire:model="formLokasi"
                                class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none appearance-none"
                                style="border-color:#E2E8F0;color:#1E293B;background:white;padding-right:2.5rem;"
                                onfocus="this.style.borderColor='#1E3A8A'" onblur="this.style.borderColor='#E2E8F0'">
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach ($lokasiList as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama_lokasi }}</option>
                                @endforeach
                            </select>
                            <div
                                style="position:absolute;right:0.875rem;top:50%;transform:translateY(-50%);pointer-events:none;">
                                <svg style="width:0.875rem;height:0.875rem;color:#94A3B8;" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('formLokasi')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Permit Number (auto uppercase) --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Permit Number Permit Number <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="text" wire:model="formPermitNumber" placeholder="ITK-2024-001234"
                            oninput="this.value = this.value.toUpperCase(); $wire.set('formPermitNumber', this.value)"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        <p class="text-xs mt-1" style="color:#94A3B8;">Otomatis uppercase. Huruf, angka, dan strip (-)
                            diperbolehkan.</p>
                        @error('formPermitNumber')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tgl Penerbitan (bisa dipilih) --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Tgl. Penerbitan <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="date" wire:model="formTanggalPenerbitan"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        @error('formTanggalPenerbitan')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stay Permit Expire --}}
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider" style="color:#64748B;">
                            Stay Permit Expire <span style="color:#ef4444;">*</span>
                        </label>
                        <input type="date" wire:model="formStayExpire"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        @error('formStayExpire')
                            <p class="text-xs mt-1" style="color:#dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Section 3: Kontak & Sponsor — collapsed by default --}}
    <div class="bg-white rounded-2xl overflow-hidden" style="border:1px solid #E2E8F0;" x-data="{ open: false }">
        <div class="px-5 py-4 flex items-center gap-3 cursor-pointer select-none" style="background:#1E3A8A;"
            @click="open = !open">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                style="background:rgba(255,255,255,0.15);">
                <span style="font-size:0.875rem;font-weight:800;color:white;">3</span>
            </div>
            <div class="flex-1 flex items-center gap-2">
                <p class="text-sm font-bold text-white">Kontak & Sponsor</p>
                <span
                    style="font-size:0.625rem;font-weight:600;background:rgba(255,255,255,0.15);color:rgba(255,255,255,0.7);padding:1px 8px;border-radius:9999px;">opsional</span>
                <p class="text-xs" style="color:rgba(255,255,255,0.45);">Nama sponsor, kontak, alamat, dan catatan</p>
            </div>
            <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none"
                stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2">
            <div class="p-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider"
                            style="color:#64748B;">Nama Sponsor / Penjamin</label>
                        <input type="text" wire:model="formNamaSponsor" placeholder="Nama lengkap sponsor"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider"
                            style="color:#64748B;">Nomor Kontak Sponsor</label>
                        <input type="tel" wire:model="formKontakSponsor" placeholder="08123456789"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'">
                        <p class="text-xs mt-1" style="color:#94A3B8;">Hanya angka, 8-15 digit</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider"
                            style="color:#64748B;">Alamat Sponsor</label>
                        <textarea wire:model="formAlamatSponsor" rows="2" placeholder="Alamat lengkap sponsor"
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none resize-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold mb-1.5 uppercase tracking-wider"
                            style="color:#64748B;">Catatan</label>
                        <textarea wire:model="formKeterangan" rows="2" placeholder="Catatan tambahan..."
                            class="w-full px-3.5 py-2.5 rounded-xl text-sm border outline-none resize-none"
                            style="border-color:#E2E8F0;color:#1E293B;" onfocus="this.style.borderColor='#1E3A8A'"
                            onblur="this.style.borderColor='#E2E8F0'"></textarea>
                    </div>
                </div>
            </div>
        </div>


    </div>

    {{-- Footer --}}
    <div class="px-5 py-4 flex items-center justify-between" style="border-top:1px solid #F1F5F9;background:#FAFAFA;">
        <a href="{{ route('operator.doklan.izin-tinggal.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold cursor-pointer"
            style="background:#F8FAFC;color:#64748B;border:1px solid #E2E8F0;">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <button wire:click="simpan"
            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold cursor-pointer"
            style="background:#D4AF37;color:#1E3A8A;" onmouseover="this.style.opacity='0.9'"
            onmouseout="this.style.opacity='1'">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span wire:loading.remove wire:target="simpan">{{ $editId ? 'Simpan Perubahan' : 'Simpan Draft' }}</span>
            <span wire:loading wire:target="simpan">Menyimpan...</span>
        </button>
    </div>

</div>
