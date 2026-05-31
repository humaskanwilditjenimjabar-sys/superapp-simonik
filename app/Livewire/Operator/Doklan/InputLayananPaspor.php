<?php

namespace App\Livewire\Operator\Doklan;

use App\Models\JenisLayanan;
use App\Models\LokasiLayanan;
use App\Modules\Doklan\Models\LayananPaspor as LayananPasporModel;
use Livewire\Component;
use Livewire\WithPagination;

class InputLayananPaspor extends Component
{
    use WithPagination;

    public string $sortColumn = 'tanggal';
    public string $sortDirection = 'desc';
    public int $perPage = 5;

    // Filter
    public ?int $filterLokasi = null;
    public string $filterDari = '';
    public string $filterSampai = '';
    public string $filterJenis = '';
    public string $search = '';
    public bool $showFilter = false;

    // Form input
    public bool $showForm = false;
    public ?int $formLokasi = null;
    public ?int $formJenis = null;
    public string $formJumlah = '';
    public string $formKeterangan = '';
    public string $formTanggal = '';
    public array $formErrors = [];

    // Untuk view
    public ?int $viewId = null;
    public bool $showView = false;

    public function viewDetail(int $id): void
    {
        $this->viewId = $id;
        $this->showView = true;
    }

    public function closeView(): void
    {
        $this->showView = false;
        $this->viewId = null;
    }
    // end view

    // untuk export
    public bool $showExport = false;
    public function openExport(): void { $this->showExport = true; }
    public function closeExport(): void { $this->showExport = false; }
        // end export

    public function mount(): void
    {
        $this->formTanggal = today()->toDateString();
    }

    public function updatedFilterLokasi(): void { $this->resetPage(); }
    public function updatedFilterDari(): void { $this->resetPage(); }
    public function updatedFilterSampai(): void { $this->resetPage(); }
    public function updatedFilterJenis(): void { $this->resetPage(); }
    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedPerPage(): void { $this->resetPage(); }

    public function resetFilter(): void
    {
        $this->filterLokasi = null;
        $this->filterDari = '';
        $this->filterSampai = '';
        $this->filterJenis = '';
        $this->search = '';
        $this->resetPage();
    }

    public function setFilterLokasi(?int $id): void
    {
        $this->filterLokasi = ($this->filterLokasi === $id) ? null : $id;
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

    public function sudahInput(): bool
    {
        if (!$this->formTanggal) return false;
        return LayananPasporModel::where('operator_id', auth()->id())
            ->where('tanggal', $this->formTanggal)
            ->exists();
    }

    public function setFormTanggal(string $tanggal): void
    {
        $today     = today()->toDateString();
        $yesterday = today()->subDay()->toDateString();

        if (!in_array($tanggal, [$today, $yesterday])) return;

        // Jangan set kalau sudah ada input
        $sudah = LayananPasporModel::where('operator_id', auth()->id())
            ->where('tanggal', $tanggal)->exists();

        if (!$sudah) {
            $this->formTanggal = $tanggal;
            unset($this->formErrors['tanggal']);
        }
    }

    public function openForm(): void
    {
        $this->formLokasi    = null;
        $this->formJenis     = null;
        $this->formJumlah    = '';
        $this->formKeterangan = '';
        $this->formTanggal   = today()->toDateString();
        $this->formErrors    = [];
        $this->showForm      = true;
    }

    public function closeForm(): void
    {
        $this->showForm   = false;
        $this->formErrors = [];
    }

    public function simpan(): void
    {
        $this->formErrors = [];

        $today     = today()->toDateString();
        $yesterday = today()->subDay()->toDateString();

        if (!in_array($this->formTanggal, [$today, $yesterday])) {
            $this->formErrors['tanggal'] = 'Tanggal hanya boleh hari ini atau kemarin.';
        }
        if (!$this->formLokasi) {
            $this->formErrors['lokasi'] = 'Lokasi layanan wajib dipilih.';
        }
        if (!$this->formJenis) {
            $this->formErrors['jenis'] = 'Jenis layanan wajib dipilih.';
        }
        if (!$this->formJumlah || !is_numeric($this->formJumlah)) {
            $this->formErrors['jumlah'] = 'Jumlah wajib diisi dengan angka.';
        } elseif ((int)$this->formJumlah < 1 || (int)$this->formJumlah > 9999) {
            $this->formErrors['jumlah'] = 'Jumlah harus antara 1 dan 9999.';
        }

      
        if (empty($this->formErrors) && $this->sudahInput()) {
            $this->formErrors['tanggal'] = 'Kamu sudah menginput data untuk tanggal ini.';
        }

        if (!empty($this->formErrors)) return;

        $user = auth()->user();

        LayananPasporModel::create([
            'kanim_id'          => $user->kanim_id,
            'kanwil_id'         => $user->kanwil_id,
            'operator_id'       => $user->id,
            'lokasi_layanan_id' => $this->formLokasi,
            'jenis_layanan_id'  => $this->formJenis,
            'jumlah'            => (int)$this->formJumlah,
            'keterangan'        => $this->formKeterangan ?: null,
            'tanggal'           => $this->formTanggal,
            'status'            => 'disubmit',
        ]);

        $this->closeForm();
        $this->dispatch('notify', message: 'Data layanan paspor berhasil disimpan.');
    }

    public function render()
    {
        $user = auth()->user();

        $lokasiList = LokasiLayanan::where('kanim_id', $user->kanim_id)->orderBy('nama_lokasi')->get();

        $data = LayananPasporModel::with(['jenisLayanan', 'lokasiLayanan'])
            ->where('operator_id', $user->id)
            ->when($this->filterLokasi, fn($q) => $q->where('lokasi_layanan_id', $this->filterLokasi))
            ->when($this->filterDari, fn($q) => $q->where('tanggal', '>=', $this->filterDari))
            ->when($this->filterSampai, fn($q) => $q->where('tanggal', '<=', $this->filterSampai))
            ->when($this->filterJenis, fn($q) => $q->where('jenis_layanan_id', $this->filterJenis))
            ->when($this->search, fn($q) => $q->where(function($sq) {
                $sq->whereHas('jenisLayanan', fn($jq) => $jq->where('nama_layanan', 'like', '%'.$this->search.'%'))
                   ->orWhereHas('lokasiLayanan', fn($lq) => $lq->where('nama_lokasi', 'like', '%'.$this->search.'%'))
                   ->orWhere('jumlah', 'like', '%'.$this->search.'%')
                   ->orWhere('keterangan', 'like', '%'.$this->search.'%')
                   ->orWhere('tanggal', 'like', '%'.$this->search.'%');
            }))
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        // Sum jumlah sesuai filter aktif
        $sumQuery = LayananPasporModel::where('operator_id', $user->id)
            ->when($this->filterLokasi, fn($q) => $q->where('lokasi_layanan_id', $this->filterLokasi))
            ->when($this->filterDari, fn($q) => $q->where('tanggal', '>=', $this->filterDari))
            ->when($this->filterSampai, fn($q) => $q->where('tanggal', '<=', $this->filterSampai))
            ->when($this->filterJenis, fn($q) => $q->where('jenis_layanan_id', $this->filterJenis))
            ->when($this->search, fn($q) => $q->where(function($sq) {
                $sq->whereHas('jenisLayanan', fn($jq) => $jq->where('nama_layanan', 'like', '%'.$this->search.'%'))
                   ->orWhereHas('lokasiLayanan', fn($lq) => $lq->where('nama_lokasi', 'like', '%'.$this->search.'%'))
                   ->orWhere('jumlah', 'like', '%'.$this->search.'%')
                   ->orWhere('keterangan', 'like', '%'.$this->search.'%')
                   ->orWhere('tanggal', 'like', '%'.$this->search.'%');
            }));
        $sumFiltered = (clone $sumQuery)->sum('jumlah');

        $baseQuery = LayananPasporModel::where('operator_id', $user->id);
        $stats = [
            'total'         => (clone $baseQuery)->sum('jumlah'),
            'hari_ini'      => (clone $baseQuery)->where('tanggal', today())->sum('jumlah'),
            'bulan_ini'     => (clone $baseQuery)->whereMonth('tanggal', now()->month)->sum('jumlah'),
            'disubmit'      => (clone $baseQuery)->where('status', 'disubmit')->count(),
            'terverifikasi' => (clone $baseQuery)->where('status', 'terverifikasi')->count(),
        ];

        $statsPerLokasi = $lokasiList->map(fn($lokasi) => [
            'id'        => $lokasi->id,
            'nama'      => $lokasi->nama_lokasi,
            'total'     => LayananPasporModel::where('operator_id', $user->id)->where('lokasi_layanan_id', $lokasi->id)->sum('jumlah'),
            'bulan_ini' => LayananPasporModel::where('operator_id', $user->id)->where('lokasi_layanan_id', $lokasi->id)->whereMonth('tanggal', now()->month)->sum('jumlah'),
        ]);

        $sudahInputHariIni = LayananPasporModel::where('operator_id', $user->id)->where('tanggal', today())->exists();
        $sudahInputKemarin = LayananPasporModel::where('operator_id', $user->id)->where('tanggal', today()->subDay())->exists();

        return view('operator.doklan.paspor.index', [
            'data'              => $data,
            'stats'             => $stats,
            'statsPerLokasi'    => $statsPerLokasi,
            'lokasiList'        => $lokasiList,
            'jenisList'         => JenisLayanan::where('kategori', 'doklan_paspor')->orderBy('nama_layanan')->get(),
            'sudahInputHariIni' => $sudahInputHariIni,
            'sudahInputKemarin' => $sudahInputKemarin,
            'sumFiltered'       => $sumFiltered,
            'viewData' => $this->viewId ? LayananPasporModel::with(['jenisLayanan', 'lokasiLayanan', 'operator'])->find($this->viewId) : null,
        ]);
    }
}