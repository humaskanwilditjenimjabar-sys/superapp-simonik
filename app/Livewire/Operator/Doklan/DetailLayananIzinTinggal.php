<?php

namespace App\Livewire\Operator\Doklan;

use App\Modules\Doklan\Models\LayananIzinTinggal;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DetailLayananIzinTinggal extends Component
{
    public int $id;
    public ?LayananIzinTinggal $layanan = null;

    public function mount(int $id): void
    {
        $user = Auth::user();
        $this->layanan = LayananIzinTinggal::with([
            'wna.kewarganegaraan',
            'jenisLayanan',
            'lokasiLayanan',
            'operator',
        ])->where('id', $id)
          ->where('kanim_id', $user->kanim_id)
          ->firstOrFail();
    }

    public function render()
    {
        return view('operator.doklan.izin-tinggal.detail');
    }
}