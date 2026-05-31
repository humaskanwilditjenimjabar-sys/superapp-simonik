<?php

namespace App\Livewire\Kanwil\Doklan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Modules\Doklan\Models\LayananPaspor as LayananPasporModel;
use App\Models\KantorImigrasi;
use App\Models\LokasiLayanan;
use App\Models\JenisLayanan;
use Illuminate\Support\Facades\Auth;

class LayananPaspor extends Component
{
    use WithPagination;

    // ── Filter ─────────────────────────────────────────────
    public string  $search       = '';
    public string  $filterKanim  = '';
    public string  $filterStatus = '';
    public ?string $filterLokasi = null;
    public string  $filterDari   = '';
    public string  $filterSampai = '';

    // ── Sort ───────────────────────────────────────────────
    public string $sortColumn    = 'tanggal';
    public string $sortDirection = 'desc';
    public int    $perPage       = 5;

    // ── Modal: Form Tambah/Edit ────────────────────────────
    public bool    $showForm     = false;
    public ?int    $formId       = null;   // null = tambah, int = edit
    public string  $formKanim    = '';
    public string  $formLokasi   = '';
    public string  $formJenis    = '';
    public string  $formTanggal  = '';
    public int     $formJumlah   = 1;
    public string  $formKeterangan = '';

    // ── Modal: View Detail + History ──────────────────────
    public bool  $showView  = false;
    public ?int  $viewId    = null;

    // ── Modal: Verifikasi ─────────────────────────────────
    public bool   $showVerif       = false;
    public ?int   $verifId         = null;
    public string $verifAksi       = '';   // 'terverifikasi' | 'ditolak'
    public string $verifCatatan    = '';

    // ── Computed props ─────────────────────────────────────
    protected function getUser() { return Auth::user(); }
    protected function isKabid(): bool
    {
        return in_array($this->getUser()->role, ['superadmin', 'admin_kabid_doklan']);
    }

    // ── Lifecycle ─────────────────────────────────────────
    public function mount(): void
    {
        $this->filterDari   = now()->startOfMonth()->format('Y-m-d');
        $this->filterSampai = now()->format('Y-m-d');
    }

    // ── Query utama ────────────────────────────────────────
    protected function baseQuery()
    {
        $user = $this->getUser();

        $q = LayananPasporModel::with(['kanim', 'lokasiLayanan', 'jenisLayanan', 'operator', 'verifiedBy'])
            ->byKanwil($user->kanwil_id);

        // Filter
        if ($this->filterKanim)  $q->where('doklan_layanan_paspor.kanim_id', $this->filterKanim);
        if ($this->filterStatus) $q->where('status', $this->filterStatus);
        if ($this->filterLokasi) $q->where('lokasi_layanan_id', $this->filterLokasi);
        if ($this->filterDari)   $q->whereDate('tanggal', '>=', $this->filterDari);
        if ($this->filterSampai) $q->whereDate('tanggal', '<=', $this->filterSampai);
        if ($this->search) {
            $q->whereHas('operator', fn($q) => $q->where('nama_lengkap', 'like', '%'.$this->search.'%'))
              ->orWhereHas('kanim',   fn($q) => $q->where('nama_kanim',    'like', '%'.$this->search.'%'));
        }

        return $q->orderBy($this->sortColumn, $this->sortDirection);
    }

    // ── Sort ───────────────────────────────────────────────
    public function sort(string $col): void
    {
        if ($this->sortColumn === $col) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn    = $col;
            $this->sortDirection = 'desc';
        }
        $this->resetPage();
    }

    // ── Reset filter ───────────────────────────────────────
    public function resetFilter(): void
    {
        $this->search       = '';
        $this->filterKanim  = '';
        $this->filterStatus = '';
        $this->filterLokasi = null;
        $this->filterDari   = now()->startOfMonth()->format('Y-m-d');
        $this->filterSampai = now()->format('Y-m-d');
        $this->resetPage();
    }

    public function setFilterLokasi(?int $id): void
    {
        $this->filterLokasi = $id ? (string) $id : null;
        $this->resetPage();
    }

    public function updatedSearch():       void { $this->resetPage(); }
    public function updatedFilterKanim():  void { $this->resetPage(); }
    public function updatedFilterStatus(): void { $this->resetPage(); }
    public function updatedFilterLokasi(): void { $this->resetPage(); }
    public function updatedFilterDari():   void { $this->resetPage(); }
    public function updatedFilterSampai(): void { $this->resetPage(); }

    // ── Modal: Tambah ──────────────────────────────────────
    public function openTambah(): void
    {
        $this->resetForm();
        $this->formTanggal = today()->format('Y-m-d');
        $this->showForm    = true;
    }

    // ── Modal: Edit ────────────────────────────────────────
    public function openEdit(int $id): void
    {
        $data = LayananPasporModel::findOrFail($id);
        $this->formId         = $id;
        $this->formKanim      = $data->kanim_id;
        $this->formLokasi     = $data->lokasi_layanan_id;
        $this->formJenis      = $data->jenis_layanan_id;
        $this->formTanggal    = $data->tanggal->format('Y-m-d');
        $this->formJumlah     = $data->jumlah;
        $this->formKeterangan = $data->keterangan ?? '';
        $this->showForm       = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    protected function resetForm(): void
    {
        $this->formId         = null;
        $this->formKanim      = '';
        $this->formLokasi     = '';
        $this->formJenis      = '';
        $this->formTanggal    = '';
        $this->formJumlah     = 1;
        $this->formKeterangan = '';
    }

    // ── Simpan (tambah / edit) ─────────────────────────────
    public function simpan(): void
    {
        $this->validate([
            'formKanim'   => 'required|exists:kantor_imigrasi,id',
            'formLokasi'  => 'required|exists:lokasi_layanan,id',
            'formJenis'   => 'required|exists:jenis_layanan,id',
            'formTanggal' => 'required|date',
            'formJumlah'  => 'required|integer|min:1|max:9999',
        ], [
            'formKanim.required'  => 'Kanim wajib dipilih.',
            'formLokasi.required' => 'Lokasi wajib dipilih.',
            'formJenis.required'  => 'Jenis layanan wajib dipilih.',
            'formTanggal.required'=> 'Tanggal wajib diisi.',
            'formJumlah.required' => 'Jumlah wajib diisi.',
            'formJumlah.min'      => 'Jumlah minimal 1.',
            'formJumlah.max'      => 'Jumlah maksimal 9999.',
        ]);

        $user = $this->getUser();
        $data = [
            'kanim_id'          => $this->formKanim,
            'kanwil_id'         => $user->kanwil_id,
            'lokasi_layanan_id' => $this->formLokasi,
            'jenis_layanan_id'  => $this->formJenis,
            'tanggal'           => $this->formTanggal,
            'jumlah'            => $this->formJumlah,
            'keterangan'        => $this->formKeterangan ?: null,
        ];

        if ($this->formId) {
            // Edit
            $record = LayananPasporModel::findOrFail($this->formId);
            $record->update($data);
            $this->dispatch('notify', message: 'Data berhasil diperbarui.');
        } else {
            // Tambah — status langsung disubmit, operator_id = user kanwil
            $data['operator_id'] = $user->id;
            $data['status']      = 'disubmit';
            LayananPasporModel::create($data);
            $this->dispatch('notify', message: 'Data berhasil ditambahkan.');
        }

        $this->closeForm();
        $this->resetPage();
    }

    // ── Modal: View Detail ─────────────────────────────────
    public function viewDetail(int $id): void
    {
        $this->viewId   = $id;
        $this->showView = true;
    }

    public function closeView(): void
    {
        $this->showView = false;
        $this->viewId   = null;
    }

    // ── Modal: Verifikasi ─────────────────────────────────
    public function openVerif(int $id, string $aksi): void
    {
        if (! $this->isKabid()) return;

        $this->verifId      = $id;
        $this->verifAksi    = $aksi;
        $this->verifCatatan = '';
        $this->showVerif    = true;
    }

    public function closeVerif(): void
    {
        $this->showVerif    = false;
        $this->verifId      = null;
        $this->verifAksi    = '';
        $this->verifCatatan = '';
    }

    public function simpanVerif(): void
    {
        if (! $this->isKabid()) return;

        $this->validate([
            'verifCatatan' => $this->verifAksi === 'ditolak' ? 'required|string|max:500' : 'nullable|string|max:500',
        ], [
            'verifCatatan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $user   = $this->getUser();
        $record = LayananPasporModel::findOrFail($this->verifId);

        // Tambah ke riwayat
        $record->tambahRiwayat($this->verifAksi, $user, $this->verifCatatan ?: null);

        // Update status
        $record->status             = $this->verifAksi;
        $record->verified_by        = $user->id;
        $record->verified_at        = now();
        $record->catatan_verifikasi = $this->verifCatatan ?: null;
        $record->save();

        $label = $this->verifAksi === 'terverifikasi' ? 'diverifikasi' : 'ditolak';
        $this->dispatch('notify', message: "Data berhasil {$label}.");
        $this->closeVerif();
    }

    public function hasActiveFilter(): bool
    {
        return $this->filterStatus !== ''
            || $this->search !== ''
            || $this->filterLokasi !== null
            || $this->filterDari !== now()->startOfMonth()->format('Y-m-d')
            || $this->filterSampai !== now()->format('Y-m-d');
    }

    // ── Render ─────────────────────────────────────────────
    public function render()
    {
        $user = $this->getUser();

        // Stats ringkasan
        $baseStats = LayananPasporModel::byKanwil($user->kanwil_id);
        $stats = [
            'total'         => (clone $baseStats)->sum('jumlah'),
            'bulan_ini'     => (clone $baseStats)->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->sum('jumlah'),
            'disubmit'      => (clone $baseStats)->where('status', 'disubmit')->count(),
            'terverifikasi' => (clone $baseStats)->where('status', 'terverifikasi')->count(),
            'ditolak'       => (clone $baseStats)->where('status', 'ditolak')->count(),
        ];

        $data        = $this->baseQuery()->paginate($this->perPage);
        $kanims       = KantorImigrasi::where('kanwil_id', $user->kanwil_id)->orderBy('nama_kanim')->get();
        $lokasis      = LokasiLayanan::orderBy('nama_lokasi')->get();
        $jenisLayanan = JenisLayanan::where('kategori', 'doklan_paspor')->orderBy('nama_layanan')->get();

        // Data untuk modal view
        $viewData = $this->viewId ? LayananPasporModel::with(['kanim', 'lokasiLayanan', 'jenisLayanan', 'operator', 'verifiedBy'])->find($this->viewId) : null;

        // Stats per lokasi (hanya jika kanim dipilih)
        $statsPerLokasi = [];
        if ($this->filterKanim) {
            $statsPerLokasi = LayananPasporModel::byKanwil($user->kanwil_id)
                ->where('doklan_layanan_paspor.kanim_id', $this->filterKanim)
                ->join('lokasi_layanan', 'doklan_layanan_paspor.lokasi_layanan_id', '=', 'lokasi_layanan.id')
                ->selectRaw('lokasi_layanan.id, lokasi_layanan.nama_lokasi as nama, SUM(jumlah) as total')
                ->groupBy('lokasi_layanan.id', 'lokasi_layanan.nama_lokasi')
                ->get()
                ->map(fn($l) => ['id' => $l->id, 'nama' => $l->nama, 'total' => $l->total])
                ->toArray();
        }

        // Sum filtered
        $sumFiltered = (clone $this->baseQuery())->sum('jumlah');
        // Di render() tambah:
        $hasActiveFilter = $this->hasActiveFilter();


        return view('kanwil.doklan.paspor.layanan-paspor', compact(
            'data', 'stats', 'kanims', 'lokasis', 'jenisLayanan', 'viewData',
            'statsPerLokasi', 'sumFiltered', 'hasActiveFilter'
        ));
    }
}