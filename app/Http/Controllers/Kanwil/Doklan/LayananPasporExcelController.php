<?php

namespace App\Http\Controllers\Kanwil\Doklan;

use App\Exports\KanwilLayananPasporExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LayananPasporExcelController extends Controller
{
    public function export(Request $request)
    {
        $user = auth()->user();

        return Excel::download(
            new KanwilLayananPasporExport(
                kanwilId:     $user->kanwil_id,
                filterKanim:  $request->filter_kanim  ? (int) $request->filter_kanim  : null,
                filterLokasi: $request->filter_lokasi ? (int) $request->filter_lokasi : null,
                filterDari:   $request->filter_dari   ?? '',
                filterSampai: $request->filter_sampai ?? '',
                filterJenis:  $request->filter_jenis  ?? '',
            ),
            'layanan-paspor-kanwil-' . now()->format('Ymd-His') . '.xlsx'
        );
    }
}