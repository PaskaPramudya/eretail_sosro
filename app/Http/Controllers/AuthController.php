<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // 1. Proses Login Pelanggan (tabel: pengguna)
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

    // 2. Proses Pendaftaran Pelanggan Baru (tabel: pengguna)
    public function prosesDaftar(Request $request)
    {
        $nama    = $request->input('nama_lengkap');
        $email   = $request->input('email');
        $no_hp   = $request->input('no_hp');
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

    // 3. Proses Login Admin (tabel: staff / admin)
    public function prosesAdminLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $admin = DB::table('staff')
            ->where('username', $username)
            ->first();

        if ($admin && ($admin->password === $password || password_verify($password, $admin->password))) {
            session(['admin' => $admin->username]);
            return redirect('/admin');
        }

        return redirect('/pelanggan?status=admin_login_failed');
    }

    // 4. Logout Pelanggan & Admin
    public function logout()
    {
        session()->forget(['nama', 'admin']);
        return redirect('/pelanggan');
    }
}