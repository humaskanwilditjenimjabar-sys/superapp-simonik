<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        Module::truncate();

        $modules = [

            // ══════════════════════════════════════
            // DOKLAN
            // ══════════════════════════════════════

            // Paspor
            [
                'bidang_code' => 'doklan',
                'module_code' => 'doklan.paspor',
                'nama_modul'  => 'Paspor',
                'icon'        => 'notebook',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'both',
                'urutan'      => 1,
            ],
            [
                'bidang_code' => 'doklan',
                'module_code' => 'doklan.paspor.input',
                'nama_modul'  => 'Input Layanan Paspor',
                'icon'        => 'file-plus',
                'route_name'  => 'operator.doklan.paspor',
                'parent_code' => 'doklan.paspor',
                'scope'       => 'kanim',
                'urutan'      => 2,
            ],
            [
                'bidang_code' => 'doklan',
                'module_code' => 'doklan.paspor.monitoring',
                'nama_modul'  => 'Monitoring Input',
                'icon'        => 'chart-bar',
                'route_name'  => 'kanwil.doklan.paspor.monitoring',
                'parent_code' => 'doklan.paspor',
                'scope'       => 'kanwil',
                'urutan'      => 3,
            ],
            [
                'bidang_code' => 'doklan',
                'module_code' => 'doklan.paspor.export',
                'nama_modul'  => 'Export Data Paspor',
                'icon'        => 'download',
                'route_name'  => 'operator.doklan.paspor.export',
                'parent_code' => 'doklan.paspor',
                'scope'       => 'both',
                'urutan'      => 4,
            ],

            // Izin Tinggal
            [
                'bidang_code' => 'doklan',
                'module_code' => 'doklan.izin_tinggal',
                'nama_modul'  => 'Izin Tinggal',
                'icon'        => 'id-badge',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'both',
                'urutan'      => 10,
            ],
            [
                'bidang_code' => 'doklan',
                'module_code' => 'doklan.izin_tinggal.layanan',
                'nama_modul'  => 'Layanan Izin Tinggal',
                'icon'        => 'file-plus',
                'route_name'  => 'operator.doklan.izin-tinggal.index',
                'parent_code' => 'doklan.izin_tinggal',
                'scope'       => 'kanim',
                'urutan'      => 11,
            ],
            [
                'bidang_code' => 'doklan',
                'module_code' => 'doklan.izin_tinggal.wna',
                'nama_modul'  => 'Data WNA',
                'icon'        => 'users',
                'route_name'  => 'operator.doklan.izin-tinggal.wna',
                'parent_code' => 'doklan.izin_tinggal',
                'scope'       => 'both',
                'urutan'      => 12,
            ],
            [
                'bidang_code' => 'doklan',
                'module_code' => 'doklan.izin_tinggal.export',
                'nama_modul'  => 'Export Izin Tinggal',
                'icon'        => 'download',
                'route_name'  => null,
                'parent_code' => 'doklan.izin_tinggal',
                'scope'       => 'both',
                'urutan'      => 13,
            ],

            // ══════════════════════════════════════
            // INTELDAKIM
            // ══════════════════════════════════════

            [
                'bidang_code' => 'inteldakim',
                'module_code' => 'inteldakim.pengawasan',
                'nama_modul'  => 'Pengawasan',
                'icon'        => 'eye',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'both',
                'urutan'      => 1,
            ],
            [
                'bidang_code' => 'inteldakim',
                'module_code' => 'inteldakim.pengawasan.input',
                'nama_modul'  => 'Input Laporan',
                'icon'        => 'file-plus',
                'route_name'  => null,
                'parent_code' => 'inteldakim.pengawasan',
                'scope'       => 'both',
                'urutan'      => 2,
            ],
            [
                'bidang_code' => 'inteldakim',
                'module_code' => 'inteldakim.pengawasan.riwayat',
                'nama_modul'  => 'Riwayat Laporan',
                'icon'        => 'history',
                'route_name'  => null,
                'parent_code' => 'inteldakim.pengawasan',
                'scope'       => 'both',
                'urutan'      => 3,
            ],
            [
                'bidang_code' => 'inteldakim',
                'module_code' => 'inteldakim.penindakan',
                'nama_modul'  => 'Penindakan',
                'icon'        => 'shield',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'both',
                'urutan'      => 10,
            ],
            [
                'bidang_code' => 'inteldakim',
                'module_code' => 'inteldakim.penindakan.deportasi',
                'nama_modul'  => 'Deportasi',
                'icon'        => 'plane-departure',
                'route_name'  => null,
                'parent_code' => 'inteldakim.penindakan',
                'scope'       => 'both',
                'urutan'      => 11,
            ],
            [
                'bidang_code' => 'inteldakim',
                'module_code' => 'inteldakim.laporan_ta',
                'nama_modul'  => 'Laporan TA',
                'icon'        => 'report',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'both',
                'urutan'      => 20,
            ],

            // ══════════════════════════════════════
            // TATA USAHA
            // ══════════════════════════════════════

            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.surat',
                'nama_modul'  => 'Penomoran Surat',
                'icon'        => 'mail',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'kanwil',
                'urutan'      => 1,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.surat.buat',
                'nama_modul'  => 'Buat Nomor Surat',
                'icon'        => 'file-plus',
                'route_name'  => null,
                'parent_code' => 'tu.surat',
                'scope'       => 'kanwil',
                'urutan'      => 2,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.surat.klasifikasi',
                'nama_modul'  => 'Klasifikasi Surat',
                'icon'        => 'tags',
                'route_name'  => null,
                'parent_code' => 'tu.surat',
                'scope'       => 'kanwil',
                'urutan'      => 3,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.surat.referensi',
                'nama_modul'  => 'Referensi TND & Kepmen',
                'icon'        => 'book',
                'route_name'  => null,
                'parent_code' => 'tu.surat',
                'scope'       => 'kanwil',
                'urutan'      => 4,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.surat.riwayat',
                'nama_modul'  => 'Riwayat Nomor',
                'icon'        => 'history',
                'route_name'  => null,
                'parent_code' => 'tu.surat',
                'scope'       => 'kanwil',
                'urutan'      => 5,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.spak',
                'nama_modul'  => 'SPAK & SPKP',
                'icon'        => 'certificate',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'both',
                'urutan'      => 10,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.spak.input',
                'nama_modul'  => 'Input SPAK',
                'icon'        => 'file-plus',
                'route_name'  => null,
                'parent_code' => 'tu.spak',
                'scope'       => 'both',
                'urutan'      => 11,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.spak.spkp',
                'nama_modul'  => 'Input SPKP',
                'icon'        => 'file-plus',
                'route_name'  => null,
                'parent_code' => 'tu.spak',
                'scope'       => 'both',
                'urutan'      => 12,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.elapor',
                'nama_modul'  => 'e-Lapor',
                'icon'        => 'report',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'both',
                'urutan'      => 20,
            ],
            [
                'bidang_code' => 'tu',
                'module_code' => 'tu.inventaris',
                'nama_modul'  => 'Inventaris',
                'icon'        => 'building-warehouse',
                'route_name'  => null,
                'parent_code' => null,
                'scope'       => 'both',
                'urutan'      => 30,
            ],
        ];

        foreach ($modules as $data) {
            Module::create($data);
        }
    }
}