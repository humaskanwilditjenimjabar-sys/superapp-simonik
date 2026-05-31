<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisLayanan;

class JenisLayananSeeder extends Seeder
{
    public function run(): void
    {
        JenisLayanan::truncate();

        // ── Jenis Layanan Paspor ──
        $paspor = [
            'Penerbitan Paspor Baru',
            'Penerbitan Paspor Hilang',
            'Penerbitan Paspor Rusak',
            'Penerbitan Paspor Pergantian',
            'Penerbitan Paspor Percepatan',
        ];

        foreach ($paspor as $i => $nama) {
            JenisLayanan::create([
                'kategori'     => 'doklan_paspor',
                'nama_layanan' => $nama,
                'grup'         => null,
                'hitung_wna'   => false,
                'is_aktif'     => true,
                'urutan'       => $i + 1,
            ]);
        }

        // ── Jenis Layanan Izin Tinggal ──
        $izinTinggal = [
            // ITK
            ['nama' => 'Pemberian ITK',          'hitung_wna' => true,  'grup' => 'ITK'],
            ['nama' => 'Perpanjangan ITK',        'hitung_wna' => true,  'grup' => 'ITK'],
            ['nama' => 'Pemberian ITKT',          'hitung_wna' => true,  'grup' => 'ITK'],
            ['nama' => 'Perpanjangan ITKT',       'hitung_wna' => true,  'grup' => 'ITK'],
            ['nama' => 'Perpanjangan VOA',        'hitung_wna' => true,  'grup' => 'ITK'],

            // ITAS
            ['nama' => 'Pemberian ITAS',          'hitung_wna' => true,  'grup' => 'ITAS'],
            ['nama' => 'Perpanjangan ITAS',       'hitung_wna' => true,  'grup' => 'ITAS'],
            ['nama' => 'Alih Status ITK ke ITAS', 'hitung_wna' => true,  'grup' => 'ITAS'],

            // ITAP
            ['nama' => 'Pemberian ITAP',           'hitung_wna' => true,  'grup' => 'ITAP'],
            ['nama' => 'Perpanjangan ITAP',        'hitung_wna' => true,  'grup' => 'ITAP'],
            ['nama' => 'Alih Status ITAS ke ITAP', 'hitung_wna' => true,  'grup' => 'ITAP'],

            // Lainnya
            ['nama' => 'Alih Penjamin',        'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Change of Activity',   'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'MERP',                 'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'KITAP Duplikat',       'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Mutasi Masuk',         'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Mutasi Paspor',        'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Affidavit',            'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Sertifikat Affidavit', 'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Lapor Lahir',          'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Lapor Kematian',       'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Perubahan Data Diri',  'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Perubahan Pekerjaan',  'hitung_wna' => true,  'grup' => 'lain'],
            ['nama' => 'Bridging',             'hitung_wna' => true,  'grup' => 'lain'],

            // Exclude dari Data WNA
            ['nama' => 'ERP Tidak Kembali', 'hitung_wna' => false, 'grup' => 'exclude'],
            ['nama' => 'EPO',               'hitung_wna' => false, 'grup' => 'exclude'],
            ['nama' => 'Mutasi Keluar',     'hitung_wna' => false, 'grup' => 'exclude'],
        ];

        foreach ($izinTinggal as $i => $data) {
            JenisLayanan::create([
                'kategori'     => 'izin_tinggal',
                'nama_layanan' => $data['nama'],
                'grup'         => $data['grup'],
                'hitung_wna'   => $data['hitung_wna'],
                'is_aktif'     => true,
                'urutan'       => $i + 1,
            ]);
        }
    }
}