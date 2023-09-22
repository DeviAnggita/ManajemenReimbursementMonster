<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;



class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $datainput = $request->all();

        $credentials = $request->only('email_karyawan', 'password');
        $credentials['email_karyawan'] = $request->input('email_karyawan');
        $credentials['password'] = $request->input('password');

        $recaptcha_secret = "6LekafMmAAAAAGhelC0PbXFbxaubOeW39KGSBOgt";
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $recaptcha_secret . "&response=" .  $datainput['g-recaptcha-response']);
        $response = json_decode($response, true);
        
        // Cek apakah captcha sudah diisi
        if (!isset($datainput['g-recaptcha-response'])) {
            return back()->withInput()->withErrors([
                'g-recaptcha-response' => 'Mohon isi captcha.'
            ]);
        }
        
        $validationErrors = [];
        if ($response["success"] === true) {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->status_active == 1 && $user->hapus == 0) {
                    // Login berhasil
                    Alert::success('Login Berhasil', '');

                    // Periksa peran pengguna
                    if ($user->role->nama_role === 'Super Admin') {
                        return redirect()->route('superadmin.dashboard');
                    } elseif ($user->role->nama_role === 'Kepala Divisi') {
                        return redirect()->route('kepaladivisi.dashboard');
                    } elseif ($user->role->nama_role === 'Manajer Keuangan') {
                        return redirect()->route('manajerkeuangan.dashboard');
                    } elseif ($user->role->nama_role === 'Karyawan') {
                        return redirect()->route('karyawan.dashboard');
                    } elseif ($user->role->nama_role === 'Staff Keuangan') {
                        return redirect()->route('staffkeuangan.dashboard');
                    }
                } else {
                    // Pengguna tidak aktif atau telah dihapus
                    Auth::logout();
                    $validationErrors['email_karyawan'] = 'Akun tidak aktif atau telah dihapus.';
                }
            } else {
                // Login gagal
                $validationErrors['email_karyawan'] = 'Email atau password salah.';
            }
        } else {
            // Login gagal (captcha tidak valid)
            $validationErrors['email_karyawan'] = 'Email atau password salah.';
        }

        return back()->withErrors($validationErrors)->withInput($request->except('password'))->with('closeButton', true);
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}