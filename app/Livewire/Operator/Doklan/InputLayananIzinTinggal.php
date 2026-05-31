<?php

namespace App\Livewire\Operator\Doklan;

use App\Models\JenisLayanan;
use App\Models\Kewarganegaraan;
use App\Models\LokasiLayanan;
use App\Modules\Doklan\Models\LayananIzinTinggal;
use App\Modules\Doklan\Models\Wna;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InputLayananIzinTinggal extends Component
{
    public ?int $editId = null;

    // Section 1: Identitas WNA
    public string $wNamaLengkap     = '';
    public string $wTempatLahir     = '';
    public string $wTanggalLahir    = '';
    public string $wKewarganegaraan = '';
    public string $wJenisKelamin    = '';
    public string $wNomorPaspor     = '';
    public string $wPasporExpire    = '';
    public string $wJabatan         = '';
    public string $wAktivitas       = '';
    public string $wAlamat          = '';

    // Section 2: Data Layanan
    public string $formJenis             = '';
    public string $formLokasi            = '';
    public string $formPermitNumber      = '';
    public string $formTanggalPenerbitan = '';
    public string $formStayExpire        = '';

    // Section 3: Sponsor
    public string $formNamaSponsor   = '';
    public string $formKontakSponsor = '';
    public string $formAlamatSponsor = '';
    public string $formKeterangan    = '';

    public function mount(?int $id = null): void
    {
        $this->formTanggalPenerbitan = '';

        if ($id) {
            $this->editId = $id;
            $this->loadEdit($id);
        }
    }

    protected function loadEdit(int $id): void
    {
        $user    = Auth::user();
        $layanan = LayananIzinTinggal::with('wna')
            ->where('id', $id)
            ->where('kanim_id', $user->kanim_id)
            ->where('status', 'disubmit')
            ->firstOrFail();

        $wna = $layanan->wna;

        $this->wNamaLengkap     = $wna?->nama_lengkap        ?? '';
        $this->wTempatLahir     = $wna?->tempat_lahir         ?? '';
        $this->wTanggalLahir    = $wna?->tanggal_lahir?->format('Y-m-d') ?? '';
        $this->wKewarganegaraan = (string) ($wna?->kewarganegaraan_id ?? '');
        $this->wJenisKelamin    = $wna?->jenis_kelamin        ?? '';
        $this->wNomorPaspor     = $wna?->nomor_paspor         ?? '';
        $this->wPasporExpire    = $wna?->paspor_expire?->format('Y-m-d') ?? '';
        $this->wJabatan         = $wna?->jabatan              ?? '';
        $this->wAktivitas       = $wna?->aktivitas            ?? '';
        $this->wAlamat          = $wna?->alamat_di_indonesia  ?? '';

        $this->formJenis             = (string) ($layanan->jenis_layanan_id  ?? '');
        $this->formLokasi            = (string) ($layanan->lokasi_layanan_id ?? '');
        $this->formPermitNumber      = $layanan->permit_number ?? '';
        $this->formTanggalPenerbitan = $layanan->tanggal_penerbitan?->format('Y-m-d') ?? '';
        $this->formStayExpire        = $layanan->stay_permit_expire?->format('Y-m-d') ?? '';
        $this->formNamaSponsor       = $layanan->nama_sponsor   ?? '';
        $this->formKontakSponsor     = $layanan->kontak_sponsor ?? '';
        $this->formAlamatSponsor     = $layanan->alamat_sponsor ?? '';
        $this->formKeterangan        = $layanan->keterangan     ?? '';
    }

    public function simpan(): void
    {
        $this->validate([
            'wNamaLengkap'          => 'required|string|max:255',
            'wTempatLahir'          => 'required|string|max:255',
            'wTanggalLahir'         => 'required|date',
            'wKewarganegaraan'      => 'required|exists:kewarganegaraan,id',
            'wJenisKelamin'         => 'required|in:L,P',
            'wNomorPaspor'          => 'required|string|max:50',
            'wPasporExpire'         => 'required|date',
            'wJabatan'              => 'required|string|max:255',
            'wAktivitas'            => 'required|string|max:255',
            'wAlamat'               => 'required|string|max:1000',
            'formJenis'             => 'required|exists:jenis_layanan,id',
            'formLokasi'            => 'required|exists:lokasi_layanan,id',
            'formTanggalPenerbitan' => 'required|date',
            'formPermitNumber'      => 'required|string|max:100',
            'formStayExpire'        => 'required|date',
            'formKontakSponsor'     => 'nullable|digits_between:8,15',
            'formKeterangan'        => 'nullable|string|max:1000',
        ], [
            'wNamaLengkap.required'          => 'Nama lengkap wajib diisi.',
            'wTempatLahir.required'          => 'Tempat lahir wajib diisi.',
            'wTanggalLahir.required'         => 'Tanggal lahir wajib diisi.',
            'wTanggalLahir.date'             => 'Format tanggal lahir tidak valid.',
            'wKewarganegaraan.required'      => 'Kewarganegaraan wajib dipilih.',
            'wJenisKelamin.required'         => 'Jenis kelamin wajib dipilih.',
            'wNomorPaspor.required'          => 'Nomor paspor wajib diisi.',
            'wPasporExpire.required'         => 'Tanggal habis berlaku paspor wajib diisi.',
            'wPasporExpire.date'             => 'Format tanggal tidak valid.',
            'wJabatan.required'              => 'Jabatan wajib diisi.',
            'wAktivitas.required'            => 'Aktivitas wajib diisi.',
            'wAlamat.required'               => 'Alamat di Indonesia wajib diisi.',
            'formJenis.required'             => 'Jenis layanan wajib dipilih.',
            'formLokasi.required'            => 'Lokasi layanan wajib dipilih.',
            'formPermitNumber.required'      => 'Permit number wajib diisi.',
            'formTanggalPenerbitan.required' => 'Tanggal penerbitan wajib diisi.',
            'formStayExpire.required'        => 'Stay permit expire wajib diisi.',
            'formKontakSponsor.digits_between' => 'Nomor kontak harus 8-15 digit angka.',
        ]);

        $user = Auth::user();

        // Simpan / update WNA
        $wna = Wna::firstOrCreate(
            [
                'nama_lengkap'       => $this->wNamaLengkap,
                'tanggal_lahir'      => $this->wTanggalLahir,
                'kewarganegaraan_id' => $this->wKewarganegaraan,
            ],
            [
                'kanim_id'            => $user->kanim_id,
                'kanwil_id'           => $user->kanwil_id,
                'tempat_lahir'        => $this->wTempatLahir,
                'jenis_kelamin'       => $this->wJenisKelamin,
                'nomor_paspor'        => $this->wNomorPaspor,
                'paspor_expire'       => $this->wPasporExpire ?: null,
                'jabatan'             => $this->wJabatan,
                'aktivitas'           => $this->wAktivitas,
                'alamat_di_indonesia' => $this->wAlamat,
            ]
        );

        $wna->update([
            'tempat_lahir'        => $this->wTempatLahir,
            'jenis_kelamin'       => $this->wJenisKelamin,
            'nomor_paspor'        => $this->wNomorPaspor,
            'paspor_expire'       => $this->wPasporExpire ?: null,
            'jabatan'             => $this->wJabatan,
            'aktivitas'           => $this->wAktivitas,
            'alamat_di_indonesia' => $this->wAlamat,
        ]);

        $layananData = [
            'wna_id'            => $wna->id,
            'jenis_layanan_id'  => $this->formJenis,
            'lokasi_layanan_id' => $this->formLokasi,
            'permit_number'     => strtoupper($this->formPermitNumber),
            'stay_permit_expire'=> $this->formStayExpire,
            'nama_sponsor'      => $this->formNamaSponsor   ?: null,
            'kontak_sponsor'    => $this->formKontakSponsor ?: null,
            'alamat_sponsor'    => $this->formAlamatSponsor ?: null,
            'keterangan'        => $this->formKeterangan    ?: null,
        ];

        if ($this->editId) {
            LayananIzinTinggal::where('id', $this->editId)
                ->where('kanim_id', $user->kanim_id)
                ->where('status', 'disubmit')
                ->update($layananData);
            session()->flash('success', 'Data berhasil diperbarui.');
        } else {
            LayananIzinTinggal::create(array_merge($layananData, [
                'kanim_id'          => $user->kanim_id,
                'kanwil_id'         => $user->kanwil_id,
                'operator_id'       => $user->id,
                'tanggal_penerbitan'=> $this->formTanggalPenerbitan,
                'status'            => 'disubmit',
            ]));
            session()->flash('success', 'Data izin tinggal berhasil disimpan sebagai draft.');
        }

        $this->redirect(route('operator.doklan.izin-tinggal.index'));
    }

    public function render()
    {
        return view('operator.doklan.izin-tinggal.input', [
            'jenisList'  => JenisLayanan::where('kategori', 'izin_tinggal')->orderBy('nama_layanan')->get(),
            'lokasiList' => LokasiLayanan::where('kanim_id', Auth::user()->kanim_id)->orderBy('nama_lokasi')->get(),
            'negaraList' => Kewarganegaraan::orderBy('nama_negara')->get(),
        ]);
    }
}