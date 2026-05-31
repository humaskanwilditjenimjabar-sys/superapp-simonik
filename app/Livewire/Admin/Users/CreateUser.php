<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Models\KantorImigrasi;
use App\Models\KantorWilayah;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Component
{
    use WithFileUploads;

    public $surat_pengajuan;
    public string $nip = '';
    public string $nama_lengkap = '';
    public string $jabatan = '';
    public string $no_hp = '';
    public string $email = '';
    public string $role = '';
    public string $bidang = '';
    public string $jenis_layanan = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?int $kanim_id = null;
    public ?int $kanwil_id = null;
    public string $status = 'aktif';
    public ?string $suratPath = null;

    protected function getAllowedRoles(): array
    {
        return match(auth()->user()->role) {
            'superadmin' => [
                'admin_kanwil_doklan', 'admin_kanwil_wasdakim', 'admin_kanwil_tu',
                'admin_kanim', 'operator_kanim', 'operator_tu',
            ],
            'admin_kakanwil' => [
                'admin_kanwil_doklan', 'admin_kanwil_wasdakim', 'admin_kanwil_tu',
                'admin_kanim', 'operator_kanim', 'operator_tu',
            ],
            'admin_kabid_doklan' => ['admin_kanwil_doklan', 'operator_kanim'],
            'admin_kabid_wasdakim' => ['admin_kanwil_wasdakim', 'operator_kanim'],
            'admin_kabag_tu' => ['admin_kanwil_tu', 'operator_tu'],
            'admin_kanim' => ['operator_kanim'],
            default => [],
        };
    }

    public function updatedRole(): void
    {
        $this->bidang = '';
        $this->jenis_layanan = '';
        $this->kanim_id = null;
    }

    public function simpan()
    {
        $rules = [
            'nip'          => ['required', 'digits:18', 'unique:users,nip'],
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'jabatan'      => ['required', 'string', 'max:100'],
            'no_hp'        => ['required', 'digits_between:10,15'],
            'email'             => ['nullable', 'email', 'max:100'],
            'surat_pengajuan'   => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'role'         => ['required', 'in:'.implode(',', $this->getAllowedRoles())],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Validasi tambahan berdasarkan role
        $needsKanim = in_array($this->role, ['operator_kanim', 'admin_kanim']);
        $needsKanwil = in_array($this->role, ['admin_kanwil_doklan', 'admin_kanwil_wasdakim', 'admin_kanwil_tu']);

        if ($needsKanim) {
            $rules['kanim_id'] = ['required', 'exists:kantor_imigrasi,id'];
        }
        if ($needsKanwil) {
            $rules['kanwil_id'] = ['required', 'exists:kantor_wilayah,id'];
        }
        if (in_array($this->role, ['operator_kanim', 'admin_kanwil_doklan', 'admin_kanwil_wasdakim', 'admin_kanwil_tu'])) {
            $rules['bidang'] = ['required', 'in:doklan,wasdakim,tu'];
        }
        if ($this->role === 'operator_kanim') {
            $rules['jenis_layanan'] = ['required', 'string'];
        }

        $this->validate($rules, [
            'nip.required'          => 'NIP wajib diisi.',
            'nip.digits'            => 'NIP harus 18 digit.',
            'nip.unique'            => 'NIP sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'jabatan.required'      => 'Jabatan wajib diisi.',
            'no_hp.required'        => 'No. HP wajib diisi.',
            'role.required'         => 'Role wajib dipilih.',
            'kanim_id.required'     => 'Kantor Imigrasi wajib dipilih.',
            'bidang.required'       => 'Bidang wajib dipilih.',
            'jenis_layanan.required'=> 'Jenis layanan wajib dipilih.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $kanim = $this->kanim_id ? KantorImigrasi::find($this->kanim_id) : null;

        $suratPath = null;
        if ($this->surat_pengajuan) {
            $suratPath = $this->surat_pengajuan->store('surat-pengajuan', 'public');
        }

        User::create([
            'nip'          => $this->nip,
            'nama_lengkap' => $this->nama_lengkap,
            'jabatan'      => $this->jabatan,
            'no_hp'        => $this->no_hp,
            'email'        => $this->email ?: null,
            'role'         => $this->role,
            'bidang'       => $this->bidang ?: null,
            'jenis_layanan'=> $this->jenis_layanan ?: null,
            'kanim_id'     => $this->kanim_id,
            'kanwil_id'    => $kanim?->kanwil_id ?? $this->kanwil_id ?? auth()->user()->kanwil_id,
            'password'     => Hash::make($this->password),
            'status'          => $this->status,
            'surat_pengajuan' => $suratPath,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function render()
    {
        return view('admin.users.create', [
            'allowedRoles' => $this->getAllowedRoles(),
            'kanimList'    => KantorImigrasi::orderBy('nama_kanim')->get(),
            'kanwilList'   => KantorWilayah::orderBy('nama_kanwil')->get(),
        ]);
    }
}