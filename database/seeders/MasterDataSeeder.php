<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KantorWilayah;
use App\Models\KantorImigrasi;
use App\Models\Kewarganegaraan;
use App\Models\LokasiLayanan;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── Kantor Wilayah ──
        if (!KantorWilayah::exists()) {
            KantorWilayah::create([
                'nama_kanwil' => 'Kantor Wilayah Direktorat Jenderal Imigrasi Jawa Barat',
                'kode_kanwil' => 'KANWIL-JABAR',
                'alamat'      => 'Jl. Jakarta No.27, Kebonwaru, Kec. Batununggal, Kota Bandung, Jawa Barat',
                'is_aktif'    => true,
            ]);
        }

        // ── Kantor Imigrasi ──
        if (!KantorImigrasi::exists()) {
            $kanim = [
                ['nama_kanim' => 'Kantor Imigrasi Kelas I TPI Bandung',          'kode_kanim' => 'KANIM-BDG'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas I TPI Cirebon',          'kode_kanim' => 'KANIM-CRB'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas I Non TPI Bogor',        'kode_kanim' => 'KANIM-BGR'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas II Non TPI Garut',       'kode_kanim' => 'KANIM-GRT'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas I Non TPI Depok',        'kode_kanim' => 'KANIM-DPK'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas I Non TPI Bekasi',       'kode_kanim' => 'KANIM-BKS'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas I Non TPI Karawang',     'kode_kanim' => 'KANIM-KRW'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas I Non TPI Sukabumi',     'kode_kanim' => 'KANIM-SKB'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas III Non TPI Cianjur',    'kode_kanim' => 'KANIM-CJR'],
                ['nama_kanim' => 'Kantor Imigrasi Kelas I Non TPI Tasikmalaya', 'kode_kanim' => 'KANIM-TSM'],
            ];

            foreach ($kanim as $data) {
                KantorImigrasi::create([
                    'kanwil_id'  => 1,
                    'nama_kanim' => $data['nama_kanim'],
                    'kode_kanim' => $data['kode_kanim'],
                    'is_aktif'   => true,
                ]);
            }
        }

        // ── Kewarganegaraan ──
        // if (!Kewarganegaraan::exists()) {
        //     $negara = [
        //         ['nama_negara' => 'Amerika Serikat',  'kode_negara' => 'US'],
        //         ['nama_negara' => 'Australia',         'kode_negara' => 'AU'],
        //         ['nama_negara' => 'Belanda',           'kode_negara' => 'NL'],
        //         ['nama_negara' => 'China',             'kode_negara' => 'CN'],
        //         ['nama_negara' => 'Filipina',          'kode_negara' => 'PH'],
        //         ['nama_negara' => 'India',             'kode_negara' => 'IN'],
        //         ['nama_negara' => 'Inggris',           'kode_negara' => 'GB'],
        //         ['nama_negara' => 'Jepang',            'kode_negara' => 'JP'],
        //         ['nama_negara' => 'Jerman',            'kode_negara' => 'DE'],
        //         ['nama_negara' => 'Korea Selatan',     'kode_negara' => 'KR'],
        //         ['nama_negara' => 'Malaysia',          'kode_negara' => 'MY'],
        //         ['nama_negara' => 'Pakistan',          'kode_negara' => 'PK'],
        //         ['nama_negara' => 'Prancis',           'kode_negara' => 'FR'],
        //         ['nama_negara' => 'Singapura',         'kode_negara' => 'SG'],
        //         ['nama_negara' => 'Taiwan',            'kode_negara' => 'TW'],
        //         ['nama_negara' => 'Thailand',          'kode_negara' => 'TH'],
        //         ['nama_negara' => 'Timor Leste',       'kode_negara' => 'TL'],
        //         ['nama_negara' => 'Vietnam',           'kode_negara' => 'VN'],
        //         ['nama_negara' => 'Arab Saudi',        'kode_negara' => 'SA'],
        //         ['nama_negara' => 'Bangladesh',        'kode_negara' => 'BD'],
        //         ['nama_negara' => 'Kanada',            'kode_negara' => 'CA'],
        //         ['nama_negara' => 'Mesir',             'kode_negara' => 'EG'],
        //         ['nama_negara' => 'Nigeria',           'kode_negara' => 'NG'],
        //         ['nama_negara' => 'Rusia',             'kode_negara' => 'RU'],
        //         ['nama_negara' => 'Spanyol',           'kode_negara' => 'ES'],
        //         ['nama_negara' => 'Italia',            'kode_negara' => 'IT'],
        //         ['nama_negara' => 'Brazil',            'kode_negara' => 'BR'],
        //         ['nama_negara' => 'Turki',             'kode_negara' => 'TR'],
        //         ['nama_negara' => 'Uni Emirat Arab',   'kode_negara' => 'AE'],
        //     ];

        //     foreach ($negara as $data) {
        //         Kewarganegaraan::create($data);
        //     }
        // }

        // ── Lokasi Layanan ──
        if (!LokasiLayanan::exists()) {
            $lokasi = [
                ['kanim_id' => 1,  'nama_lokasi' => 'Kantor Utama Bandung'],
                ['kanim_id' => 1,  'nama_lokasi' => 'Mal Pelayanan Publik Bandung'],
                ['kanim_id' => 2,  'nama_lokasi' => 'Kantor Utama Cirebon'],
                ['kanim_id' => 3,  'nama_lokasi' => 'Kantor Utama Bogor'],
                ['kanim_id' => 3,  'nama_lokasi' => 'Mal Pelayanan Publik Bogor'],
                ['kanim_id' => 4,  'nama_lokasi' => 'Kantor Utama Garut'],
                ['kanim_id' => 5,  'nama_lokasi' => 'Kantor Utama Depok'],
                ['kanim_id' => 5,  'nama_lokasi' => 'Mal Pelayanan Publik Depok'],
                ['kanim_id' => 6,  'nama_lokasi' => 'Kantor Utama Bekasi'],
                ['kanim_id' => 6,  'nama_lokasi' => 'Mal Pelayanan Publik Bekasi'],
                ['kanim_id' => 6,  'nama_lokasi' => 'Kantor Satelit Cikarang'],
                ['kanim_id' => 7,  'nama_lokasi' => 'Kantor Utama Karawang'],
                ['kanim_id' => 8,  'nama_lokasi' => 'Kantor Utama Sukabumi'],
                ['kanim_id' => 9,  'nama_lokasi' => 'Kantor Utama Cianjur'],
                ['kanim_id' => 10, 'nama_lokasi' => 'Kantor Utama Tasikmalaya'],
            ];

            foreach ($lokasi as $data) {
                LokasiLayanan::create([
                    'kanim_id'    => $data['kanim_id'],
                    'nama_lokasi' => $data['nama_lokasi'],
                    'is_aktif'    => true,
                ]);
            }
        }
    }
}