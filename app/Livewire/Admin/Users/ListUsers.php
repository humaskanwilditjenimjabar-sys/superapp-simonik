<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Models\KantorImigrasi;
use Livewire\Component;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public string $filterRole = '';
    public string $filterKanim = '';
    public string $sortColumn = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 5;

    // Modal
    public bool $showModalTolak = false;
    public bool $showModalApprove = false;
    public bool $showModalNonaktif = false;
    public bool $showModalAktifkan = false;
    public ?int $selectedUserId = null;
    public string $selectedUserName = '';
    public string $alasanPenolakan = '';

    protected $queryString = [
        'search'       => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterRole'   => ['except' => ''],
        'filterKanim'  => ['except' => ''],
    ];

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedFilterStatus(): void { $this->resetPage(); }
    public function updatedFilterRole(): void { $this->resetPage(); }
    public function updatedFilterKanim(): void { $this->resetPage(); }
    public function updatedPerPage(): void { $this->resetPage(); }

    public function resetFilter(): void
    {
        $this->search = '';
        $this->filterStatus = '';
        $this->filterRole = '';
        $this->filterKanim = '';
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    // Roles yang boleh dilihat berdasarkan role yang login
    protected function getAllowedRoles(): array
    {
        $role = auth()->user()->role;

        return match($role) {
            'superadmin' => [
                'admin_kakanwil',
                'admin_kabid_doklan', 'admin_kanwil_doklan',
                'admin_kabid_wasdakim', 'admin_kanwil_wasdakim',
                'admin_kabag_tu', 'admin_kanwil_tu',
                'admin_kanim', 'operator_kanim', 'operator_tu',
            ],
            'admin_kakanwil' => [
                'admin_kabid_doklan', 'admin_kanwil_doklan',
                'admin_kabid_wasdakim', 'admin_kanwil_wasdakim',
                'admin_kabag_tu', 'admin_kanwil_tu',
                'admin_kanim', 'operator_kanim', 'operator_tu',
            ],
            'admin_kabid_doklan' => ['admin_kanwil_doklan', 'operator_kanim'],
            'admin_kabid_wasdakim' => ['admin_kanwil_wasdakim', 'operator_kanim'],
            'admin_kabag_tu' => ['admin_kanwil_tu', 'operator_tu'],
            'admin_kanwil_doklan' => ['operator_kanim'],
            'admin_kanwil_wasdakim' => ['operator_kanim'],
            'admin_kanwil_tu' => ['operator_tu'],
            'admin_kanim' => ['operator_kanim'],
            default => [],
        };
    }

    // Roles yang boleh ditambah/dikelola
    public function getManageableRoles(): array
    {
        return $this->getAllowedRoles();
    }

    public function openApprove(int $id, string $nama): void
    {
        $this->selectedUserId = $id;
        $this->selectedUserName = $nama;
        $this->showModalApprove = true;
    }

    public function openTolak(int $id, string $nama): void
    {
        $this->selectedUserId = $id;
        $this->selectedUserName = $nama;
        $this->alasanPenolakan = '';
        $this->showModalTolak = true;
    }

    public function openNonaktif(int $id, string $nama): void
    {
        $this->selectedUserId = $id;
        $this->selectedUserName = $nama;
        $this->showModalNonaktif = true;
    }

    public function openAktifkan(int $id, string $nama): void
    {
        $this->selectedUserId = $id;
        $this->selectedUserName = $nama;
        $this->showModalAktifkan = true;
    }

    public function closeModal(): void
    {
        $this->showModalApprove = false;
        $this->showModalTolak = false;
        $this->showModalNonaktif = false;
        $this->showModalAktifkan = false;
        $this->selectedUserId = null;
        $this->selectedUserName = '';
        $this->alasanPenolakan = '';
    }

    public function approve(): void
    {
        User::findOrFail($this->selectedUserId)->update(['status' => 'aktif']);
        $this->dispatch('notify', message: 'Akun berhasil disetujui.');
        $this->closeModal();
        
    }

    public function tolak(): void
    {
        $this->validate(['alasanPenolakan' => 'required|string|min:5'], [
            'alasanPenolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasanPenolakan.min'      => 'Alasan minimal 5 karakter.',
        ]);
        User::findOrFail($this->selectedUserId)->update([
            'status'           => 'ditolak',
            'alasan_penolakan' => $this->alasanPenolakan,
        ]);
        $this->dispatch('notify', message: 'Akun telah ditolak.');
        $this->closeModal();
    }

    public function nonaktifkan(): void
    {
        User::findOrFail($this->selectedUserId)->update(['status' => 'nonaktif']);
        $this->dispatch('notify', message: 'Akun dinonaktifkan.');
        $this->closeModal();
    }

    public function aktifkan(): void
    {
        User::findOrFail($this->selectedUserId)->update(['status' => 'aktif']);
        $this->dispatch('notify', message: 'Akun diaktifkan kembali.');
        $this->closeModal();
    }

    public function render()
    {
        $allowedRoles = $this->getAllowedRoles();
        $user = auth()->user();

        $query = User::with(['kanim', 'kanwil'])
            ->whereIn('role', $allowedRoles)
            ->when($this->search, fn($q) => $q->where(function($sq) {
                $sq->where('nama_lengkap', 'like', '%'.$this->search.'%')
                   ->orWhere('nip', 'like', '%'.$this->search.'%')
                   ->orWhere('jabatan', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterRole, fn($q) => $q->where('role', $this->filterRole))
            ->when($this->filterKanim, fn($q) => $q->where('kanim_id', $this->filterKanim))
            ->orderBy($this->sortColumn, $this->sortDirection);

        // Hitung stats hanya untuk role yang boleh dilihat
        $baseQuery = User::whereIn('role', $allowedRoles);
        $stats = [
            'total'    => (clone $baseQuery)->count(),
            'aktif'    => (clone $baseQuery)->where('status', 'aktif')->count(),
            'pending'  => (clone $baseQuery)->where('status', 'pending')->count(),
            'nonaktif' => (clone $baseQuery)->where('status', 'nonaktif')->count(),
            'ditolak'  => (clone $baseQuery)->where('status', 'ditolak')->count(),
        ];

        // Kanim list — filter sesuai scope user
        $kanimList = KantorImigrasi::orderBy('nama_kanim')->get();

        return view('admin.users.list', [
            'users'           => $query->paginate($this->perPage),
            'stats'           => $stats,
            'kanimList'       => $kanimList,
            'manageableRoles' => $this->getManageableRoles(),
        ]);
    }
}