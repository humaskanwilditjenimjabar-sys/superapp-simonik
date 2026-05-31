<?php

namespace App\Livewire\Operator\Doklan;

use App\Models\Kewarganegaraan;
use App\Modules\Doklan\Models\LayananIzinTinggal;
use App\Modules\Doklan\Models\Wna;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class DataWna extends Component
{
    use WithPagination;

    public int    $perPage   = 10;
    public string $search    = '';
    public string $filterNegara = '';
    public string $filterEarly  = ''; // 'early' | 'expired' | ''

    public bool $showView  = false;
    public ?int $viewWnaId = null;

    public function updatedSearch(): void      { $this->resetPage(); }
    public function updatedFilterNegara(): void { $this->resetPage(); }
    public function updatedFilterEarly(): void  { $this->resetPage(); }
    public function updatedPerPage(): void      { $this->resetPage(); }

    public function resetFilter(): void
    {
        $this->search       = '';
        $this->filterNegara = '';
        $this->filterEarly  = '';
        $this->resetPage();
    }

    public function viewDetail(int $wnaId): void
    {
        $this->viewWnaId = $wnaId;
        $this->showView  = true;
    }

    public function closeView(): void
    {
        $this->showView  = false;
        $this->viewWnaId = null;
    }

    public function render()
    {
        $user = Auth::user();

        // Ambil WNA yang layanan terakhirnya hitung_wna = true
        // dengan join ke layanan izin tinggal terbaru
        $query = Wna::where('doklan_wna.kanim_id', $user->kanim_id)
            ->whereExists(function ($sub) {
                $sub->selectRaw('1')
                    ->from('doklan_layanan_izin_tinggal as l')
                    ->join('jenis_layanan as j', 'l.jenis_layanan_id', '=', 'j.id')
                    ->whereColumn('l.wna_id', 'doklan_wna.id')
                    ->where('j.hitung_wna', true)
                    ->whereRaw('l.id = (SELECT MAX(id) FROM doklan_layanan_izin_tinggal WHERE wna_id = doklan_wna.id AND deleted_at IS NULL)');
            })
            ->with(['kewarganegaraan'])
            ->withMax('izinTinggal', 'id') // ambil id terbaru untuk join
            ->when($this->search, fn($q) => $q->where(function ($sq) {
                $sq->where('doklan_wna.nama_lengkap', 'like', '%'.$this->search.'%')
                   ->orWhere('doklan_wna.nomor_paspor', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterNegara, fn($q) => $q->where('doklan_wna.kewarganegaraan_id', $this->filterNegara));

        $wnaIds = $query->pluck('doklan_wna.id');

        // Ambil layanan terbaru per WNA untuk kolom expire + jenis
        $layananTerbaru = LayananIzinTinggal::with(['jenisLayanan'])
            ->whereIn('wna_id', $wnaIds)
            ->whereRaw('id = (SELECT MAX(id) FROM doklan_layanan_izin_tinggal WHERE wna_id = doklan_layanan_izin_tinggal.wna_id AND deleted_at IS NULL)')
            ->get()
            ->keyBy('wna_id');

        // Filter early warning / expired setelah dapat layanan terbaru
        if ($this->filterEarly === 'early') {
            $filteredIds = $layananTerbaru->filter(fn($l) => $l->isEarlyWarning())->pluck('wna_id');
            $query->whereIn('doklan_wna.id', $filteredIds);
        } elseif ($this->filterEarly === 'expired') {
            $filteredIds = $layananTerbaru->filter(fn($l) => $l->stay_permit_expire && $l->stay_permit_expire->isPast())->pluck('wna_id');
            $query->whereIn('doklan_wna.id', $filteredIds);
        }

        $data = $query->orderBy('doklan_wna.nama_lengkap')->paginate($this->perPage);

        // View detail
        $viewWna = null;
        $viewHistory = collect();
        if ($this->viewWnaId) {
            $viewWna    = Wna::with('kewarganegaraan')->find($this->viewWnaId);
            $viewHistory = LayananIzinTinggal::with(['jenisLayanan', 'lokasiLayanan', 'operator'])
                ->where('wna_id', $this->viewWnaId)
                ->orderByDesc('id')
                ->get();
        }

        return view('operator.doklan.izin-tinggal.wna', [
            'data'           => $data,
            'layananTerbaru' => $layananTerbaru,
            'negaraList'     => Kewarganegaraan::orderBy('nama_negara')->get(),
            'viewWna'        => $viewWna,
            'viewHistory'    => $viewHistory,
        ]);
    }
}