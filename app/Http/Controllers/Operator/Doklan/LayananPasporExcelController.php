<?php

namespace App\Http\Controllers\Operator\Doklan;

use App\Exports\LayananPasporExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LayananPasporExcelController extends Controller
{
    public function export(Request $request)
    {
        $user = auth()->user();

        return Excel::download(
            new LayananPasporExport(
                operatorId:   $user->id,
                kanimId:      $user->kanim_id,
                filterLokasi: $request->filter_lokasi ? (int) $request->filter_lokasi : null,
                filterDari:   $request->filter_dari   ?? '',
                filterSampai: $request->filter_sampai ?? '',
                filterJenis:  $request->filter_jenis  ?? '',
                search:       $request->search        ?? '',
            ),
            'layanan-paspor-' . now()->format('Ymd-His') . '.xlsx'
        );
    }
}