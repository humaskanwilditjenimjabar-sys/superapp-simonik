<?php

namespace App\Livewire\Operator\Doklan;

use App\Models\JenisLayanan;
use App\Models\Kewarganegaraan;
use App\Models\LokasiLayanan;
use App\Modules\Doklan\Models\LayananIzinTinggal;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ListLayananIzinTinggal extends Component
{
    use WithPagination;

    public int    $perPage   = 5;
    public string $sortColumn    = 'tanggal_penerbitan';
    public string $sortDirection = 'desc';

    // Filter
    public string $search          = '';
    public string $filterJenis     = '';
    public string $filterNegara    = '';
    public string $filterLokasi    = '';
    public string $filterDariInput = '';
    public string $filterSampaiInput = '';
    public string $filterDariExpire  = '';
    public string $filterSampaiExpire = '';

    // Card filter
    public string $filterCard = ''; // 'itk' | 'itas' | 'itap' | ''

    // Modals
    public bool $showView          = false;
    public ?int $viewId            = null;
    public bool $showConfirmSubmit = false;
    public ?int $submitId          = null;
    public bool $showConfirmBatal  = false;
    public ?int $batalId           = null;

    public function updatedSearch(): void           { $this->resetPage(); }
    public function updatedFilterJenis(): void      { $this->resetPage(); }
    public function updatedFilterNegara(): void     { $this->resetPage(); }
    public function updatedFilterLokasi(): void     { $this->resetPage(); }
    public function updatedFilterDariInput(): void  { $this->resetPage(); }
    public function updatedFilterSampaiInput(): void { $this->resetPage(); }
    public function updatedFilterDariExpire(): void  { $this->resetPage(); }
    public function updatedFilterSampaiExpire(): void { $this->resetPage(); }
    public function updatedPerPage(): void          { $this->resetPage(); }

    public function setFilterCard(string $card): void
    {
        $this->filterCard  = $this->filterCard === $card ? '' : $card;
        $this->filterJenis = '';
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->search             = '';
        $this->filterJenis        = '';
        $this->filterNegara       = '';
        $this->filterLokasi       = '';
        $this->filterDariInput    = '';
        $this->filterSampaiInput  = '';
        $this->filterDariExpire   = '';
        $this->filterSampaiExpire = '';
        $this->filterCard         = '';
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn    = $column;
            $this->sortDirection = 'asc';
        }
    }

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

    public function confirmSubmit(int $id): void
    {
        $this->submitId          = $id;
        $this->showConfirmSubmit = true;
    }

    public function doSubmit(): void
    {
        $user    = Auth::user();
        $layanan = LayananIzinTinggal::where('id', $this->submitId)
            ->where('kanim_id', $user->kanim_id)
            ->where('status', 'draft')
            ->first();

        if ($layanan) {
            $layanan->update(['status' => 'disubmit']);
            session()->flash('success', 'Data berhasil disubmit untuk verifikasi.');
        }

        $this->showConfirmSubmit = false;
        $this->submitId          = null;
    }

    public function cancelSubmit(): void
    {
        $this->showConfirmSubmit = false;
        $this->submitId          = null;
    }

    public function confirmBatal(int $id): void
    {
        $this->batalId          = $id;
        $this->showConfirmBatal = true;
    }

    public function doBatal(): void
    {
        $user    = Auth::user();
        $layanan = LayananIzinTinggal::where('id', $this->batalId)
            ->where('kanim_id', $user->kanim_id)
            ->where('status', 'disubmit')
            ->first();

        if ($layanan) {
            $layanan->update(['status' => 'draft']);
            session()->flash('success', 'Submit dibatalkan, data kembali ke Draft.');
        }

        $this->showConfirmBatal = false;
        $this->batalId          = null;
    }

    public function cancelBatal(): void
    {
        $this->showConfirmBatal = false;
        $this->batalId          = null;
    }

    protected function baseQuery()
    {
        $user = Auth::user();

        return LayananIzinTinggal::with(['wna.kewarganegaraan', 'jenisLayanan', 'lokasiLayanan'])
            ->where('doklan_layanan_izin_tinggal.kanim_id', $user->kanim_id)
            ->when($this->filterJenis,  fn($q) => $q->where('jenis_layanan_id', $this->filterJenis))
            ->when($this->filterLokasi, fn($q) => $q->where('lokasi_layanan_id', $this->filterLokasi))
            ->when($this->filterNegara, fn($q) => $q->whereHas('wna', fn($wq) => $wq->where('kewarganegaraan_id', $this->filterNegara)))
            ->when($this->filterDariInput,    fn($q) => $q->whereDate('tanggal_penerbitan', '>=', $this->filterDariInput))
            ->when($this->filterSampaiInput,  fn($q) => $q->whereDate('tanggal_penerbitan', '<=', $this->filterSampaiInput))
            ->when($this->filterDariExpire,   fn($q) => $q->whereDate('stay_permit_expire', '>=', $this->filterDariExpire))
            ->when($this->filterSampaiExpire, fn($q) => $q->whereDate('stay_permit_expire', '<=', $this->filterSampaiExpire))
            ->when($this->filterCard === 'itk',  fn($q) => $q->whereHas('jenisLayanan', fn($jq) => $jq->where('nama_layanan', 'like', '%ITK%')))
            ->when($this->filterCard === 'itas', fn($q) => $q->whereHas('jenisLayanan', fn($jq) => $jq->where('nama_layanan', 'like', '%ITAS%')))
            ->when($this->filterCard === 'itap', fn($q) => $q->whereHas('jenisLayanan', fn($jq) => $jq->where('nama_layanan', 'like', '%ITAP%')))
            ->when($this->search, fn($q) => $q->where(function ($sq) {
                $sq->whereHas('wna', fn($wq) => $wq
                    ->where('nama_lengkap', 'like', '%'.$this->search.'%')
                    ->orWhere('nomor_paspor', 'like', '%'.$this->search.'%'))
                   ->orWhere('permit_number', 'like', '%'.$this->search.'%')
                   ->orWhereHas('jenisLayanan', fn($jq) => $jq->where('nama_layanan', 'like', '%'.$this->search.'%'));
            }));
    }

    public function render()
    {
        $user = Auth::user();

        // Stats cards
        $baseStats = LayananIzinTinggal::where('kanim_id', $user->kanim_id);
        $totalInputan = (clone $baseStats)->count();
        $totalITK     = (clone $baseStats)->whereHas('jenisLayanan', fn($q) => $q->where('nama_layanan', 'like', '%ITK%'))->count();
        $totalITAS    = (clone $baseStats)->whereHas('jenisLayanan', fn($q) => $q->where('nama_layanan', 'like', '%ITAS%'))->count();
        $totalITAP    = (clone $baseStats)->whereHas('jenisLayanan', fn($q) => $q->where('nama_layanan', 'like', '%ITAP%'))->count();

        $data = $this->baseQuery()
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        $viewData = $this->viewId
            ? LayananIzinTinggal::with(['wna.kewarganegaraan', 'jenisLayanan', 'lokasiLayanan', 'verifiedBy'])
                ->find($this->viewId)
            : null;

        return view('operator.doklan.izin-tinggal.list', [
            'data'          => $data,
            'totalInputan'  => $totalInputan,
            'totalITK'      => $totalITK,
            'totalITAS'     => $totalITAS,
            'totalITAP'     => $totalITAP,
            'jenisList'     => JenisLayanan::where('kategori', 'izin_tinggal')->orderBy('nama_layanan')->get(),
            'negaraList'    => Kewarganegaraan::orderBy('nama_negara')->get(),
            'lokasiList'    => LokasiLayanan::where('kanim_id', $user->kanim_id)->orderBy('nama_lokasi')->get(),
            'viewData'      => $viewData,
        ]);
    }
}