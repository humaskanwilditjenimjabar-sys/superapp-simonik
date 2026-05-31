<?php

namespace Database\Seeders;

use App\Models\HariLibur;
use App\Models\KantorImigrasi;
use App\Models\KantorWilayah;
use App\Models\Kewarganegaraan;
use App\Models\JenisLayanan;
use App\Models\LokasiLayanan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SharedSeeder extends Seeder
{
    public function run(): void
    {
        // ── Kantor Wilayah ──
        $kanwil = KantorWilayah::create([
            'nama_kanwil' => 'Kantor Wilayah Ditjenim Jawa Barat',
            'kode_kanwil' => 'JABAR',
            'alamat'      => 'Jl. Soekarno Hatta No. 1, Bandung',
            'is_aktif'    => true,
        ]);

        // ── Kantor Imigrasi ──
        $kanim1 = KantorImigrasi::create([
            'kanwil_id'  => $kanwil->id,
            'nama_kanim' => 'Kantor Imigrasi Kelas I TPI Bandung',
            'kode_kanim' => 'BDG',
            'alamat'     => 'Jl. Abdul Muis No. 2, Bandung',
            'is_aktif'   => true,
        ]);

        $kanim2 = KantorImigrasi::create([
            'kanwil_id'  => $kanwil->id,
            'nama_kanim' => 'Kantor Imigrasi Kelas II Non TPI Bogor',
            'kode_kanim' => 'BGR',
            'alamat'     => 'Jl. Pajajaran No. 10, Bogor',
            'is_aktif'   => true,
        ]);

        // ── Lokasi Layanan ──
        LokasiLayanan::create(['kanim_id' => $kanim1->id, 'nama_lokasi' => 'Kantor Utama Bandung',   'is_aktif' => true]);
        LokasiLayanan::create(['kanim_id' => $kanim1->id, 'nama_lokasi' => 'Gerai Mall Bandung',     'is_aktif' => true]);
        LokasiLayanan::create(['kanim_id' => $kanim2->id, 'nama_lokasi' => 'Kantor Utama Bogor',     'is_aktif' => true]);

        // ── Jenis Layanan Doklan Paspor ──
        $pasporData = [
            ['nama_layanan' => 'Penerbitan Paspor Baru',        'urutan' => 1],
            ['nama_layanan' => 'Penggantian Paspor Habis Masa', 'urutan' => 2],
            ['nama_layanan' => 'Penggantian Paspor Rusak',      'urutan' => 3],
            ['nama_layanan' => 'Penggantian Paspor Hilang',     'urutan' => 4],
            ['nama_layanan' => 'Paspor Anak',                   'urutan' => 5],
        ];
        foreach ($pasporData as $data) {
            JenisLayanan::create([
                'kategori'    => 'doklan_paspor',
                'nama_layanan'=> $data['nama_layanan'],
                'hitung_wna'  => false,
                'is_aktif'    => true,
                'urutan'      => $data['urutan'],
            ]);
        }

        // ── Jenis Layanan Doklan Izin Tinggal ──
        $izinData = [
            ['nama_layanan' => 'ITK Kunjungan Wisata',    'grup' => 'ITK',  'hitung_wna' => true,  'urutan' => 1],
            ['nama_layanan' => 'ITK Kunjungan Sosial',    'grup' => 'ITK',  'hitung_wna' => true,  'urutan' => 2],
            ['nama_layanan' => 'ITAS Pekerja',            'grup' => 'ITAS', 'hitung_wna' => true,  'urutan' => 3],
            ['nama_layanan' => 'ITAS Penyatuan Keluarga', 'grup' => 'ITAS', 'hitung_wna' => true,  'urutan' => 4],
            ['nama_layanan' => 'ITAS Investor',           'grup' => 'ITAS', 'hitung_wna' => true,  'urutan' => 5],
            ['nama_layanan' => 'ITAP',                    'grup' => 'ITAP', 'hitung_wna' => true,  'urutan' => 6],
            ['nama_layanan' => 'EPO',                     'grup' => null,   'hitung_wna' => false, 'urutan' => 7],
            ['nama_layanan' => 'ERP Tidak Kembali',       'grup' => null,   'hitung_wna' => false, 'urutan' => 8],
            ['nama_layanan' => 'Mutasi Keluar',           'grup' => null,   'hitung_wna' => false, 'urutan' => 9],
        ];
        foreach ($izinData as $data) {
            JenisLayanan::create([
                'kategori'    => 'doklan_izin_tinggal',
                'nama_layanan'=> $data['nama_layanan'],
                'grup'        => $data['grup'],
                'hitung_wna'  => $data['hitung_wna'],
                'is_aktif'    => true,
                'urutan'      => $data['urutan'],
            ]);
        }

        // ── Jenis Layanan Wasdakim ──
        $wasdakimData = [
            ['nama_layanan' => 'Pengawasan Keberadaan WNA', 'urutan' => 1],
            ['nama_layanan' => 'Pengawasan Kegiatan WNA',   'urutan' => 2],
            ['nama_layanan' => 'Tindakan Administratif',    'urutan' => 3],
            ['nama_layanan' => 'Penindakan Pelanggaran',    'urutan' => 4],
        ];
        foreach ($wasdakimData as $data) {
            JenisLayanan::create([
                'kategori'    => 'wasdakim',
                'nama_layanan'=> $data['nama_layanan'],
                'hitung_wna'  => false,
                'is_aktif'    => true,
                'urutan'      => $data['urutan'],
            ]);
        }

        // ── Kewarganegaraan ──
        $negaraData = [
            ['nama_negara' => 'Amerika Serikat', 'kode_negara' => 'US'],
            ['nama_negara' => 'Australia',       'kode_negara' => 'AU'],
            ['nama_negara' => 'China',           'kode_negara' => 'CN'],
            ['nama_negara' => 'India',           'kode_negara' => 'IN'],
            ['nama_negara' => 'Inggris',         'kode_negara' => 'GB'],
            ['nama_negara' => 'Jepang',          'kode_negara' => 'JP'],
            ['nama_negara' => 'Jerman',          'kode_negara' => 'DE'],
            ['nama_negara' => 'Korea Selatan',   'kode_negara' => 'KR'],
            ['nama_negara' => 'Malaysia',        'kode_negara' => 'MY'],
            ['nama_negara' => 'Singapura',       'kode_negara' => 'SG'],
        ];
        foreach ($negaraData as $data) {
            Kewarganegaraan::create($data);
        }

        // ── Users Testing ──
        $users = [
            ['nip' => '197001012000011001', 'nama_lengkap' => 'Super Admin',             'role' => 'superadmin',              'bidang' => 'semua',     'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
            ['nip' => '197001022000011001', 'nama_lengkap' => 'Admin Kakanwil',          'role' => 'admin_kakanwil',          'bidang' => 'semua',     'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
            ['nip' => '197001032000011001', 'nama_lengkap' => 'Admin Kabid Doklan',      'role' => 'admin_kabid_doklan',      'bidang' => 'doklan',    'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
            ['nip' => '197001042000011001', 'nama_lengkap' => 'Admin Kanwil Doklan',     'role' => 'admin_kanwil_doklan',     'bidang' => 'doklan',    'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
            ['nip' => '197001052000011001', 'nama_lengkap' => 'Admin Kabid Wasdakim',    'role' => 'admin_kabid_wasdakim',    'bidang' => 'wasdakim',  'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
            ['nip' => '197001062000011001', 'nama_lengkap' => 'Admin Kanwil Wasdakim',   'role' => 'admin_kanwil_wasdakim',   'bidang' => 'wasdakim',  'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
            ['nip' => '197001072000011001', 'nama_lengkap' => 'Admin Kabag TU',          'role' => 'admin_kabag_tu',          'bidang' => 'tu',        'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
            ['nip' => '197001082000011001', 'nama_lengkap' => 'Admin Kanwil TU',         'role' => 'admin_kanwil_tu',         'bidang' => 'tu',        'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
            ['nip' => '197001092000011001', 'nama_lengkap' => 'Admin Kanim Bandung',     'role' => 'admin_kanim',             'bidang' => 'semua',     'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => $kanim1->id],
            ['nip' => '197001102000011001', 'nama_lengkap' => 'Operator Paspor',         'role' => 'operator_kanim',          'bidang' => 'doklan',    'jenis_layanan' => 'paspor',      'kanwil_id' => $kanwil->id, 'kanim_id' => $kanim1->id],
            ['nip' => '197001112000011001', 'nama_lengkap' => 'Operator Izin Tinggal',   'role' => 'operator_kanim',          'bidang' => 'doklan',    'jenis_layanan' => 'izin_tinggal','kanwil_id' => $kanwil->id, 'kanim_id' => $kanim1->id],
            ['nip' => '197001122000011001', 'nama_lengkap' => 'Operator Wasdakim Pengawasan', 'role' => 'operator_kanim',     'bidang' => 'wasdakim',  'jenis_layanan' => 'pengawasan',  'kanwil_id' => $kanwil->id, 'kanim_id' => $kanim1->id],
            ['nip' => '197001132000011001', 'nama_lengkap' => 'Operator Wasdakim Penindakan', 'role' => 'operator_kanim',     'bidang' => 'wasdakim',  'jenis_layanan' => 'penindakan',  'kanwil_id' => $kanwil->id, 'kanim_id' => $kanim1->id],
            ['nip' => '197001142000011001', 'nama_lengkap' => 'Operator TU',             'role' => 'operator_tu',             'bidang' => 'tu',        'jenis_layanan' => null,          'kanwil_id' => $kanwil->id, 'kanim_id' => null],
        ];

        foreach ($users as $data) {
            User::create([
                ...$data,
                'jabatan'  => $data['nama_lengkap'],
                'password' => Hash::make('password123'),
                'status'   => 'aktif',
            ]);
        }
    }
}