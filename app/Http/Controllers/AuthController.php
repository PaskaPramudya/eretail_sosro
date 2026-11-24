<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // 1. Proses Login Pelanggan / Mitra (tabel: pengguna)
    public function prosesLogin(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required|string|max:100',
            'password' => 'required|string|max:255',
        ]);

        $input = $request->input('email_or_phone');
        $password = $request->input('password');

        $user = DB::table('pengguna')
            ->where(function ($query) use ($input) {
                $query->where('email', $input)
                    ->orWhere('no_hp', $input)
                    ->orWhere('nama_lengkap', $input);
            })
            ->first();

        if ($user && $this->passwordMatches($password, $user->password ?? null)) {
            $namaUser = $user->nama_lengkap ?? $user->nama ?? $input;
            session()->regenerate();
            session([
                'nama' => $namaUser,
                'role' => 'pelanggan',
                'user_id' => $user->id,
            ]);
            return redirect('/pelanggan?status=login_success&nama=' . urlencode($namaUser));
        }

        return redirect('/pelanggan?status=login_failed');
    }

    // 2. Proses Pendaftaran Pelanggan Baru / Mitra (tabel: pengguna)
    public function prosesDaftar(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|max:100',
            'no_hp'        => 'nullable|string|max:20',
            'password'     => 'required|string|min:4|max:255',
        ], [
            'nama_lengkap.required' => 'Nama lengkap / nama toko wajib diisi.',
            'email.required'        => 'Alamat email wajib diisi.',
            'email.email'           => 'Format email tidak valid (harus ada @ dan domain).',
            'password.required'     => 'Kata sandi wajib diisi.',
            'password.min'          => 'Kata sandi minimal 4 karakter.',
        ]);

        $nama     = trim($request->input('nama_lengkap'));
        $email    = trim($request->input('email'));
        $no_hp    = trim($request->input('no_hp'));
        $password = $request->input('password');

        // Cek apakah email sudah terdaftar
        $cekEmail = DB::table('pengguna')->where('email', $email)->first();
        if ($cekEmail) {
            return redirect('/pelanggan?status=email_exists');
        }

        try {
            DB::table('pengguna')->insert([
                'nama_lengkap' => $nama,
                'email'        => $email,
                'no_hp'        => $no_hp,
                'password'     => $password,
                'role'         => 'pelanggan',
            ]);

            return redirect('/pelanggan?status=register_success');
        } catch (\Exception $e) {
            return redirect('/pelanggan?status=register_failed&msg=' . urlencode($e->getMessage()));
        }
    }

    // 3. Login khusus Admin Distributor
    public function prosesAdminLogin(Request $request)
    {
        return $this->loginInternal($request, 'admin');
    }

    // 4. Login khusus Staff Distributor
    public function prosesStaffLogin(Request $request)
    {
        return $this->loginInternal($request, 'staff');
    }

    // 5. Logout (Pelanggan, Admin, & Staff)
    public function logout()
    {
        session()->flush();
        return redirect('/pelanggan');
    }

    private function passwordMatches(string $password, ?string $storedPassword): bool
    {
        if (!$storedPassword) {
            return false;
        }

        return hash_equals($storedPassword, $password)
            || password_verify($password, $storedPassword);
    }

    private function loginInternal(Request $request, string $expectedRole)
    {
        $request->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string|max:255',
        ]);

        $input = trim($request->input('username'));
        $user = DB::table('staff')
            ->where(function ($query) use ($input) {
                $query->whereRaw('LOWER(nama_staff) = ?', [strtolower($input)])
                    ->orWhereRaw('LOWER(email) = ?', [strtolower($input)]);
            })
            ->first();

        if (!$user || !$this->passwordMatches($request->password, $user->password ?? null)) {
            return redirect('/pelanggan?status=' . $expectedRole . '_login_failed');
        }

        // Data lama menggunakan kolom jabatan ("Staff", "Admin").
        // Tetap dukung variasi kapitalisasi/spasi agar login tidak gagal karena format data.
        $jabatan = strtolower(trim((string) ($user->jabatan ?? '')));
        $actualRole = str_contains($jabatan, 'staff') ? 'staff' : 'admin';

        if ($actualRole !== $expectedRole) {
            return redirect('/pelanggan?status=' . $expectedRole . '_login_failed');
        }

        $identifier = $user->nama_staff ?? $user->email ?? $input;
        session()->regenerate();
        session([
            'nama' => $identifier,
            'role' => $actualRole,
            'internal_id' => $user->id,
        ]);

        return redirect($actualRole === 'admin' ? '/admin' : '/staff/penjualan');
    }
}
