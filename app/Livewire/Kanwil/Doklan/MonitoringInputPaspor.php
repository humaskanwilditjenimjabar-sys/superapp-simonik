<?php

namespace App\Livewire\Kanwil\Doklan;

use App\Models\KantorImigrasi;
use App\Models\LokasiLayanan;
use App\Modules\Doklan\Models\LayananPaspor as LayananPasporModel;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class MonitoringInputPaspor extends Component
{
    public string  $filterKanim  = '';
    public string  $filterLokasi = '';
    public string  $filterDari   = '';
    public string  $filterSampai = '';

    // Popup
    public bool    $showPopup       = false;
    public ?string $popupTanggal    = null;
    public array   $popupDetail     = [];
    public int     $popupTotal      = 0;
    public bool    $popupSudahInput = false;

    public function mount(): void
    {
        $this->filterDari   = now()->startOfMonth()->format('Y-m-d');
        $this->filterSampai = now()->format('Y-m-d');
    }

    public function updatedFilterKanim(): void
    {
        $this->filterLokasi = '';
        $this->showPopup    = false;
    }

    public function resetFilter(): void
    {
        $this->filterKanim  = '';
        $this->filterLokasi = '';
        $this->filterDari   = now()->startOfMonth()->format('Y-m-d');
        $this->filterSampai = now()->format('Y-m-d');
        $this->showPopup    = false;
    }

    public function openPopup(string $tanggal): void
    {
        $this->popupTanggal = $tanggal;

        $query = LayananPasporModel::with(['jenisLayanan', 'lokasiLayanan'])
            ->where('kanim_id', $this->filterKanim)
            ->whereDate('tanggal', $tanggal);

        if ($this->filterLokasi) {
            $query->where('lokasi_layanan_id', $this->filterLokasi);
        }

        $data = $query->get();

        $this->popupSudahInput = $data->count() > 0;
        $this->popupTotal      = $data->sum('jumlah');

        // Group per lokasi + jenis
        $this->popupDetail = $data->map(fn($item) => [
            'lokasi' => $item->lokasiLayanan?->nama_lokasi ?? '-',
            'jenis'  => $item->jenisLayanan?->nama_layanan  ?? '-',
            'jumlah' => $item->jumlah,
        ])->toArray();

        $this->showPopup = true;
    }

    public function closePopup(): void
    {
        $this->showPopup = false;
    }

    public function render()
    {
        $user   = auth()->user();
        $kanims = KantorImigrasi::where('kanwil_id', $user->kanwil_id)
            ->orderBy('nama_kanim')->get();

        $lokasiList = $this->filterKanim
            ? LokasiLayanan::where('kanim_id', $this->filterKanim)->orderBy('nama_lokasi')->get()
            : collect();

        $kalender  = [];
        $kanimInfo = null;

        if ($this->filterKanim && $this->filterDari && $this->filterSampai) {
            $kanimInfo = $kanims->firstWhere('id', $this->filterKanim);

            $query = LayananPasporModel::where('kanim_id', $this->filterKanim)
                ->whereBetween('tanggal', [$this->filterDari, $this->filterSampai]);

            if ($this->filterLokasi) {
                $query->where('lokasi_layanan_id', $this->filterLokasi);
            }

            $dataInput = $query
                ->selectRaw('tanggal, SUM(jumlah) as total_jumlah, COUNT(*) as total_entri')
                ->groupBy('tanggal')
                ->get()
                ->keyBy(fn($d) => Carbon::parse($d->tanggal)->format('Y-m-d'));

            $period = CarbonPeriod::create($this->filterDari, $this->filterSampai);
            foreach ($period as $date) {
                $key       = $date->format('Y-m-d');
                $isSunday  = $date->dayOfWeek === Carbon::SUNDAY;
                $isHoliday = \App\Models\HariLibur::whereDate('tanggal', $key)->exists();
                $isLibur   = $isSunday || $isHoliday;

                $kalender[] = [
                    'tanggal'      => $key,
                    'label'        => $date->translatedFormat('d'),
                    'hari'         => $date->translatedFormat('D'),
                    'day_of_week'  => $date->dayOfWeek,
                    'is_today'     => $date->isToday(),
                    'is_libur'     => $isLibur,
                    'is_sunday'    => $isSunday,
                    'is_holiday'   => $isHoliday,
                    'is_past'      => $date->isPast() && !$date->isToday(),
                    'sudah_input'  => isset($dataInput[$key]),
                    'total_jumlah' => $dataInput[$key]->total_jumlah ?? 0,
                    'total_entri'  => $dataInput[$key]->total_entri  ?? 0,
                ];
            }
        }

        $totalHariRange   = count($kalender);
        $totalHariLibur   = collect($kalender)->where('is_libur', true)->count();
        $totalHariKerja   = $totalHariRange - $totalHariLibur;
        $totalSudahInput  = collect($kalender)->where('sudah_input', true)->where('is_libur', false)->count();
        $totalBelumInput  = collect($kalender)->where('sudah_input', false)->where('is_libur', false)->where('is_past', true)->count();
        $totalJumlah      = collect($kalender)->sum('total_jumlah');

        return view('kanwil.doklan.paspor.monitoring-input', [
            'kanims'          => $kanims,
            'lokasiList'      => $lokasiList,
            'kalender'        => $kalender,
            'kanimInfo'       => $kanimInfo,
            'totalHariRange'  => $totalHariRange,
            'totalHariKerja'  => $totalHariKerja,
            'totalHariLibur'  => $totalHariLibur,
            'totalSudahInput' => $totalSudahInput,
            'totalBelumInput' => $totalBelumInput,
            'totalJumlah'     => $totalJumlah,
        ]);
    }
}