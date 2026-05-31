<?php

namespace App\Http\Controllers\Kanwil\Doklan;

use App\Http\Controllers\Controller;
use App\Modules\Doklan\Models\LayananPaspor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LayananPasporPdfController extends Controller
{
    public function export(Request $request)
    {
        $user = auth()->user();

        $filterKanim  = $request->filter_kanim;
        $filterLokasi = $request->filter_lokasi;
        $filterDari   = $request->filter_dari;
        $filterSampai = $request->filter_sampai;
        $filterJenis  = $request->filter_jenis;

        $query = LayananPaspor::with(['jenisLayanan', 'lokasiLayanan', 'kanim', 'operator'])
            ->where('kanwil_id', $user->kanwil_id)
            ->when($filterKanim,  fn($q) => $q->where('doklan_layanan_paspor.kanim_id', $filterKanim))
            ->when($filterLokasi, fn($q) => $q->where('lokasi_layanan_id', $filterLokasi))
            ->when($filterDari,   fn($q) => $q->where('tanggal', '>=', $filterDari))
            ->when($filterSampai, fn($q) => $q->where('tanggal', '<=', $filterSampai))
            ->when($filterJenis,  fn($q) => $q->where('jenis_layanan_id', $filterJenis))
            ->orderBy('tanggal', 'desc')
            ->get();

        $total = $query->sum('jumlah');

        $summaryLokasi = $query->groupBy('lokasi_layanan_id')->map(fn($items) => [
            'nama'  => $items->first()->lokasiLayanan?->nama_lokasi ?? '-',
            'total' => $items->sum('jumlah'),
        ])->values();

        $summaryJenis = $query->groupBy('jenis_layanan_id')->map(fn($items) => [
            'nama'  => $items->first()->jenisLayanan?->nama_layanan ?? '-',
            'total' => $items->sum('jumlah'),
        ])->values();

        $summaryKanim = $query->groupBy('kanim_id')->map(fn($items) => [
            'nama'  => $items->first()->kanim?->nama_kanim ?? '-',
            'total' => $items->sum('jumlah'),
        ])->values();

        $filters = [
            'kanim'  => $filterKanim  ? ($query->first()?->kanim?->nama_kanim ?? '-') : 'Semua Kanim',
            'lokasi' => $filterLokasi ? ($query->first()?->lokasiLayanan?->nama_lokasi ?? '-') : 'Semua Lokasi',
            'dari'   => $filterDari   ? Carbon::parse($filterDari)->format('d/m/Y')   : null,
            'sampai' => $filterSampai ? Carbon::parse($filterSampai)->format('d/m/Y') : null,
            'jenis'  => $filterJenis  ? ($query->first()?->jenisLayanan?->nama_layanan ?? '-') : 'Semua Jenis',
        ];

        $pdf = Pdf::loadView('kanwil.doklan.paspor.pdf', [
            'data'          => $query,
            'total'         => $total,
            'summaryKanim'  => $summaryKanim,
            'summaryLokasi' => $summaryLokasi,
            'summaryJenis'  => $summaryJenis,
            'filters'       => $filters,
            'kanwil'        => $user->kanwil?->nama_kanwil ?? 'Kanwil Ditjenim Jabar',
            'exportedBy'    => $user->nama_lengkap,
            'exportedAt'    => now()->format('d/m/Y H:i') . ' WIB',
        ])->setPaper('a4', 'portrait');

        return $pdf->download('layanan-paspor-kanwil-' . now()->format('Ymd-His') . '.pdf');
    }
}