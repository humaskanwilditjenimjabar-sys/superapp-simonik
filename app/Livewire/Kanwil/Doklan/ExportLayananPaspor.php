<?php

namespace App\Livewire\Kanwil\Doklan;

use App\Models\JenisLayanan;
use App\Models\KantorImigrasi;
use App\Models\LokasiLayanan;
use App\Modules\Doklan\Models\LayananPaspor as LayananPasporModel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ExportLayananPaspor extends Component
{
    use WithPagination;

    public string $sortColumn    = 'tanggal';
    public string $sortDirection = 'desc';
    public int    $perPage       = 5;

    public string  $filterKanim  = '';
    public ?int    $filterLokasi = null;
    public string  $filterDari   = '';
    public string  $filterSampai = '';
    public string  $filterJenis  = '';
    public string  $search       = '';

    public function updatedFilterKanim(): void  { $this->filterLokasi = null; $this->resetPage(); }
    public function updatedFilterLokasi(): void { $this->resetPage(); }
    public function updatedFilterDari(): void   { $this->resetPage(); }
    public function updatedFilterSampai(): void { $this->resetPage(); }
    public function updatedFilterJenis(): void  { $this->resetPage(); }
    public function updatedSearch(): void       { $this->resetPage(); }
    public function updatedPerPage(): void      { $this->resetPage(); }

    public function resetFilter(): void
    {
        $this->filterKanim  = '';
        $this->filterLokasi = null;
        $this->filterDari   = '';
        $this->filterSampai = '';
        $this->filterJenis  = '';
        $this->search       = '';
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
            $this->sortColumn    = $column;
            $this->sortDirection = 'asc';
        }
    }

    protected function baseQuery()
    {
        $user = Auth::user();

        return LayananPasporModel::with(['jenisLayanan', 'lokasiLayanan', 'kanim', 'operator'])
            ->where('kanwil_id', $user->kanwil_id)
            ->when($this->filterKanim,  fn($q) => $q->where('doklan_layanan_paspor.kanim_id', $this->filterKanim))
            ->when($this->filterLokasi, fn($q) => $q->where('lokasi_layanan_id', $this->filterLokasi))
            ->when($this->filterDari,   fn($q) => $q->where('tanggal', '>=', $this->filterDari))
            ->when($this->filterSampai, fn($q) => $q->where('tanggal', '<=', $this->filterSampai))
            ->when($this->filterJenis,  fn($q) => $q->where('jenis_layanan_id', $this->filterJenis))
            ->when($this->search, fn($q) => $q->where(function ($sq) {
                $sq->whereHas('jenisLayanan',   fn($jq) => $jq->where('nama_layanan', 'like', '%'.$this->search.'%'))
                   ->orWhereHas('lokasiLayanan', fn($lq) => $lq->where('nama_lokasi',  'like', '%'.$this->search.'%'))
                   ->orWhereHas('kanim',         fn($kq) => $kq->where('nama_kanim',   'like', '%'.$this->search.'%'))
                   ->orWhere('keterangan', 'like', '%'.$this->search.'%')
                   ->orWhere('tanggal',    'like', '%'.$this->search.'%');
            }));
    }

    public function render()
    {
        $user    = Auth::user();
        $kanims  = KantorImigrasi::where('kanwil_id', $user->kanwil_id)->orderBy('nama_kanim')->get();

        // Lokasi berdasarkan kanim yang dipilih, atau semua kalau belum pilih
        $lokasiList = $this->filterKanim
            ? LokasiLayanan::where('kanim_id', $this->filterKanim)->orderBy('nama_lokasi')->get()
            : LokasiLayanan::orderBy('nama_lokasi')->get();

        $data    = $this->baseQuery()->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
        $allData = $this->baseQuery()->get();
        $total   = $allData->sum('jumlah');

        $statsPerLokasi = $lokasiList->map(fn($l) => [
            'id'    => $l->id,
            'nama'  => $l->nama_lokasi,
            'total' => (clone $this->baseQuery())
                ->where('lokasi_layanan_id', $l->id)
                ->sum('jumlah'),
        ])->filter(fn($l) => $l['total'] > 0)->values();

        $summaryLokasi = $allData->groupBy('lokasi_layanan_id')->map(fn($items) => [
            'nama'  => $items->first()->lokasiLayanan?->nama_lokasi ?? '-',
            'total' => $items->sum('jumlah'),
        ])->values();

        $summaryJenis = $allData->groupBy('jenis_layanan_id')->map(fn($items) => [
            'nama'  => $items->first()->jenisLayanan?->nama_layanan ?? '-',
            'total' => $items->sum('jumlah'),
        ])->values();

        return view('kanwil.doklan.paspor.export', [
            'data'           => $data,
            'total'          => $total,
            'kanims'         => $kanims,
            'lokasiList'     => $lokasiList,
            'statsPerLokasi' => $statsPerLokasi,
            'summaryLokasi'  => $summaryLokasi,
            'summaryJenis'   => $summaryJenis,
            'jenisList'      => JenisLayanan::where('kategori', 'doklan_paspor')->orderBy('nama_layanan')->get(),
        ]);
    }
}