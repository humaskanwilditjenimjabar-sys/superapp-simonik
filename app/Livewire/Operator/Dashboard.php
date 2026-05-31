<?php

namespace App\Livewire\Operator;

use App\Modules\Doklan\Models\LayananPaspor;
use App\Models\LokasiLayanan;
use App\Models\JenisLayanan;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public string $chartDari   = '';
    public string $chartSampai = '';

    public function mount(): void
    {
        $this->chartDari   = now()->startOfYear()->format('Y-m-d');
        $this->chartSampai = now()->format('Y-m-d');
    }

    public function render()
    {
        $user = auth()->user();

        // ── Status hari ini & kemarin ──
        $sudahHariIni  = LayananPaspor::where('operator_id', $user->id)->where('tanggal', today())->exists();
        $sudahKemarin  = LayananPaspor::where('operator_id', $user->id)->where('tanggal', today()->subDay())->exists();

        // ── Stats global ──
        $totalPaspor   = LayananPaspor::where('operator_id', $user->id)->sum('jumlah');
        $totalBulanIni = LayananPaspor::where('operator_id', $user->id)->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->sum('jumlah');
        $totalHariIni  = LayananPaspor::where('operator_id', $user->id)->where('tanggal', today())->sum('jumlah');

        // ── Per lokasi ──
        $lokasiList = LokasiLayanan::where('kanim_id', $user->kanim_id)->orderBy('nama_lokasi')->get();
        $perLokasi  = $lokasiList->map(fn($l) => [
            'nama'       => $l->nama_lokasi,
            'total'      => LayananPaspor::where('operator_id', $user->id)->where('lokasi_layanan_id', $l->id)->sum('jumlah'),
            'bulan_ini'  => LayananPaspor::where('operator_id', $user->id)->where('lokasi_layanan_id', $l->id)->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->sum('jumlah'),
        ]);

        // ── Per jenis layanan ──
        $jenisList = JenisLayanan::where('kategori', 'doklan_paspor')->orderBy('nama_layanan')->get();
        $perJenis  = $jenisList->map(fn($j) => [
            'nama'      => $j->nama_layanan,
            'total'     => LayananPaspor::where('operator_id', $user->id)->where('jenis_layanan_id', $j->id)->sum('jumlah'),
            'bulan_ini' => LayananPaspor::where('operator_id', $user->id)->where('jenis_layanan_id', $j->id)->whereMonth('tanggal', now()->month)->whereYear('tanggal', now()->year)->sum('jumlah'),
        ]);

        // ── Chart data (per bulan dalam range) ──
        $dari   = $this->chartDari   ? Carbon::parse($this->chartDari)   : now()->startOfYear();
        $sampai = $this->chartSampai ? Carbon::parse($this->chartSampai) : now();

        $chartLabels = [];
        $chartData   = [];
        $current = $dari->copy()->startOfMonth();
        while ($current->lte($sampai)) {
            $chartLabels[] = $current->translatedFormat('M Y');
            $chartData[]   = (int) LayananPaspor::where('operator_id', $user->id)
                ->whereMonth('tanggal', $current->month)
                ->whereYear('tanggal',  $current->year)
                ->when($this->chartDari,   fn($q) => $q->where('tanggal', '>=', $this->chartDari))
                ->when($this->chartSampai, fn($q) => $q->where('tanggal', '<=', $this->chartSampai))
                ->sum('jumlah');
            $current->addMonth();
        }

        $this->dispatch('chartUpdated', labels: $chartLabels, data: $chartData);

        return view('operator.dashboard', [
            'user'          => $user,
            'sudahHariIni'  => $sudahHariIni,
            'sudahKemarin'  => $sudahKemarin,
            'totalPaspor'   => $totalPaspor,
            'totalBulanIni' => $totalBulanIni,
            'totalHariIni'  => $totalHariIni,
            'perLokasi'     => $perLokasi,
            'perJenis'      => $perJenis,
            'chartLabels'   => json_encode($chartLabels),
            'chartData'     => json_encode($chartData),
        ]);
    }
}