<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // 1. Proses Login Pelanggan / Mitra (tabel: pengguna)
    public function prosesLogin(Request $request)
    {
        $input = $request->input('email_or_phone');
        $password = $request->input('password');

        $user = DB::table('pengguna')
            ->where('email', $input)
            ->orWhere('no_hp', $input)
            ->first();

        if ($user && ($user->password === $password || password_verify($password, $user->password))) {
            $namaUser = $user->nama_lengkap ?? $user->nama ?? $input;
            session(['nama' => $namaUser]);
            return redirect('/pelanggan?status=login_success&nama=' . urlencode($namaUser));
        }

        return redirect('/pelanggan?status=login_failed');
    }

    // 2. Proses Pendaftaran Pelanggan Baru / Mitra (tabel: pengguna)
    public function prosesDaftar(Request $request)
    {
        $nama     = $request->input('nama_lengkap');
        $email    = $request->input('email');
        $no_hp    = $request->input('no_hp');
        $password = $request->input('password');

        // Cek apakah email sudah terdaftar
        $cekEmail = DB::table('pengguna')->where('email', $email)->first();
        if ($cekEmail) {
            return redirect('/pelanggan?status=email_exists');
        }

        DB::table('pengguna')->insert([
            'nama_lengkap' => $nama,
            'email'        => $email,
            'no_hp'        => $no_hp,
            'password'     => $password
        ]);

        return redirect('/pelanggan?status=register_success');
    }

    // 3. Proses Login Internal (Staff Distributor & Admin Distributor)
    public function prosesAdminLogin(Request $request)
    {
        $input = $request->input('username');
        $password = $request->input('password');

        // Cari berdasarkan kolom 'nama_staff' atau 'email' di tabel 'staff'
        $user = DB::table('staff')
            ->where(function($query) use ($input) {
                $query->where('nama_staff', $input)
                      ->orWhere('email', $input);
            })
            ->first();

        if ($user && ($user->password === $password || password_verify($password, $user->password))) {
            // Membaca dari kolom 'jabatan'
            $jabatan = strtolower($user->jabatan ?? 'admin');
            $identifier = $user->nama_staff ?? $user->email ?? $input;

            if ($jabatan === 'staff') {
                session([
                    'staff' => $identifier,
                    'role'  => 'staff'
                ]);
                return redirect('/staff/penjualan');
            } else {
                session([
                    'admin' => $identifier,
                    'role'  => 'admin'
                ]);
                return redirect('/admin');
            }
        }

        return redirect('/pelanggan?status=admin_login_failed');
    }

    // 4. Logout (Pelanggan, Admin, & Staff)
    public function logout()
    {
        session()->forget(['nama', 'admin', 'staff', 'role']);
        return redirect('/pelanggan');
    }
}