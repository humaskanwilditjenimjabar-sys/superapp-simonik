<?php

namespace App\Http\Controllers\Operator\Doklan;

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

        $filterLokasi  = $request->filter_lokasi;
        $filterDari    = $request->filter_dari;
        $filterSampai  = $request->filter_sampai;
        $filterJenis   = $request->filter_jenis;
        $search        = $request->search;

        $query = LayananPaspor::with(['jenisLayanan', 'lokasiLayanan'])
            ->where('operator_id', $user->id)
            ->when($filterLokasi, fn($q) => $q->where('lokasi_layanan_id', $filterLokasi))
            ->when($filterDari,   fn($q) => $q->where('tanggal', '>=', $filterDari))
            ->when($filterSampai, fn($q) => $q->where('tanggal', '<=', $filterSampai))
            ->when($filterJenis,  fn($q) => $q->where('jenis_layanan_id', $filterJenis))
            ->when($search, fn($q) => $q->where(function($sq) use ($search) {
                $sq->whereHas('jenisLayanan', fn($jq) => $jq->where('nama_layanan', 'like', "%{$search}%"))
                   ->orWhereHas('lokasiLayanan', fn($lq) => $lq->where('nama_lokasi', 'like', "%{$search}%"))
                   ->orWhere('keterangan', 'like', "%{$search}%");
            }))
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

        $filters = [
            'lokasi'  => $filterLokasi ? $query->first()?->lokasiLayanan?->nama_lokasi : 'Semua Lokasi',
            'dari'    => $filterDari ? Carbon::parse($filterDari)->format('d/m/Y') : null,
            'sampai'  => $filterSampai ? Carbon::parse($filterSampai)->format('d/m/Y') : null,
            'jenis'   => $filterJenis ? $query->first()?->jenisLayanan?->nama_layanan : 'Semua Jenis',
            'search'  => $search ?: null,
        ];

        $pdf = Pdf::loadView('operator.doklan.paspor.pdf', [
            'data'          => $query,
            'total'         => $total,
            'summaryLokasi' => $summaryLokasi,
            'summaryJenis'  => $summaryJenis,
            'filters'       => $filters,
            'kanim'         => $user->kanim?->nama_kanim ?? '-',
            'operator'      => $user->nama_lengkap,
            'exportedAt'    => now()->format('d/m/Y H:i') . ' WIB',
        ])->setPaper('a4', 'portrait');

        return $pdf->download('layanan-paspor-' . now()->format('Ymd-His') . '.pdf');
    }
}