<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KantorImigrasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DaftarController extends Controller
{
    public function show()
    {
        $kanim = KantorImigrasi::orderBy('nama_kanim')->get();
        return view('auth.daftar', compact('kanim'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'             => ['required', 'digits:18', 'unique:users,nip'],
            'nama_lengkap'    => ['required', 'string', 'max:100'],
            'jabatan'         => ['required', 'string', 'max:100'],
            'no_hp'           => ['required', 'digits_between:10,15'],
            'kanim_id'        => ['required', 'exists:kantor_imigrasi,id'],
            'bidang'          => ['required', 'in:doklan,wasdakim'],
            'jenis_layanan'   => ['required', 'string'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'surat_pengajuan' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ], [
            'nip.required'          => 'NIP wajib diisi.',
            'nip.digits'            => 'NIP harus 18 digit.',
            'nip.unique'            => 'NIP sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'jabatan.required'      => 'Jabatan wajib diisi.',
            'no_hp.required'        => 'No. HP wajib diisi.',
            'no_hp.digits_between'   => 'No. HP harus 10-15 digit angka.',
            'kanim_id.required'     => 'Kantor Imigrasi wajib dipilih.',
            'bidang.required'       => 'Bidang wajib dipilih.',
            'jenis_layanan.required'=> 'Jenis layanan wajib dipilih.',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi kata sandi tidak cocok.',
            'surat_pengajuan.required' => 'Surat pengajuan wajib diupload.',
            'surat_pengajuan.mimes' => 'Surat pengajuan harus berformat PDF.',
            'surat_pengajuan.max'   => 'Ukuran surat maksimal 2MB.',
        ]);

        // Ambil kanwil dari kanim yang dipilih
        $kanim = KantorImigrasi::findOrFail($request->kanim_id);

        // Upload surat
        $suratPath = $request->file('surat_pengajuan')
            ->store('surat-pengajuan', 'public');

        User::create([
            'nip'             => $request->nip,
            'nama_lengkap'    => $request->nama_lengkap,
            'jabatan'         => $request->jabatan,
            'no_hp'           => $request->no_hp,
            'kanim_id'        => $request->kanim_id,
            'kanwil_id'       => $kanim->kanwil_id,
            'bidang'          => $request->bidang,
            'jenis_layanan'   => $request->jenis_layanan,
            'role'            => 'operator_kanim',
            'password'        => Hash::make($request->password),
            'status'          => 'pending',
            'surat_pengajuan' => $suratPath,
        ]);

        return redirect()->route('pending');
    }
}