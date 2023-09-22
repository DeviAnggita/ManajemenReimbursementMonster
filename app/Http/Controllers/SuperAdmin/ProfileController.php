<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Divisi;
use App\Models\Strata;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


// use Alert;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;


class ProfileController extends Controller
{

    public function index()
    {
        $userId = Auth::id(); // Mengambil ID pengguna yang sedang login
        
        $karyawan = DB::table('users')
        ->join('tb_divisi', 'users.id_divisi', '=', 'tb_divisi.id_divisi')
        ->join('tb_strata', 'users.id_strata', '=', 'tb_strata.id_strata')
        ->join('tb_role', 'users.id_role', '=', 'tb_role.id_role')
        ->select('users.*', 'users.status_active', 'tb_divisi.nama_divisi', 'tb_role.nama_role', 'tb_strata.nama_strata')
        ->where('tb_divisi.hapus', '=', 0) 
        ->where('tb_strata.hapus', '=', 0)
        ->where('tb_role.hapus', '=', 0)
        ->where('users.hapus', '=', 0)
        ->where('tb_divisi.status_active', '=', 1)
        ->where('tb_strata.status_active', '=', 1)
        ->where('tb_role.status_active', '=', 1)
        ->where('users.status_active', '=', 1)
        ->where('users.id_user', $userId) // Menambahkan kondisi untuk ID pengguna
        ->orderBy('nama_karyawan', 'asc')
        ->first();
        // dd($karyawan);
                
    
        $divisis = Divisi::where('hapus', '=', 0)
        ->where('status_active', '=', 1)
        ->get();
        
        $stratas = Strata::where('hapus', '=', 0)
        ->where('status_active', '=', 1)
        ->get();
        
        $roles = Role::where('hapus', '=', 0)
        ->where('status_active', '=', 1)
        ->get();
        
        return view('superadmin.profile.index', compact('karyawan', 'divisis', 'stratas', 'roles'));
    }



    public function updateFotoProfile(Request $request, $id_user)
    {
        $karyawan = User::findOrFail($id_user);
    
        $validator = Validator::make($request->all(), [
            'foto_profil' => 'image|mimes:png,jpeg,jpg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $fileName = $karyawan->nama_karyawan . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move('FotoProfile', $fileName);
            $karyawan->foto_profile = $fileName;
        }
    
        $karyawan->save();
    
        return redirect()
            ->route('superadmin.profile')
            ->with([
                'success' => 'Foto Profile Berhasil Diubah',
            ]);
    }


    public function updateKelolaPengguna(Request $request, $id_user)
    {
        $karyawan = User::findOrFail($id_user);
    
        $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
        $karyawan->nama_karyawan = $request->nama_karyawan;
        $karyawan->telepon = $request->telepon;
        $karyawan->tanggal_masuk = $request->tanggal_masuk;
        $karyawan->id_strata = $request->id_strata;
        $karyawan->gaji = str_replace('.', '', $request->gaji);
        $karyawan->alamat_lengkap = $request->alamat_lengkap;

        $karyawan->save();
    
        if ($karyawan) {
            return redirect()
                ->route('superadmin.profile')
                ->with([
                    Alert::success('Berhasil', 'Data Berhasil Diubah'),
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Gagal Diubah'),
                ]);
        }
    }


    public function updateKelolaAkun(Request $request, $id_user)
    {
        $karyawan = User::findOrFail($id_user);
    
        $karyawan->email_karyawan = $request->email_karyawan;

        // Periksa apakah password baru diberikan dan berbeda dengan password lama
        if ($request->has('password') && !empty($request->password) && $request->password != '********') {
            if ($karyawan->password != $request->password) {
                $karyawan->password = Hash::make($request->password);
            }
        }

        $karyawan->save();

        if ($karyawan) {
            return redirect()
                ->route('superadmin.profile')
                ->with([
                    Alert::success('Berhasil', 'Data Berhasil Diubah'),
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Gagal Diubah'),
                ]);
        }
    }


    


    // public function update(Request $request, $id_user)
    // {
    //     $karyawan = User::findOrFail($id_user);
    
    //     if ($request->hasFile('foto_profile')) {
    //         $file = $request->file('foto_profile');
    //         $fileName = $request->nama_karyawan . '_' . time() . '.' . $file->getClientOriginalExtension();
    //         $file->move('FotoProfile', $fileName);
    //         $karyawan->foto_profile = $fileName;
    //     }
        
    //     $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
    //     $karyawan->nama_karyawan = $request->nama_karyawan;
    //     $karyawan->telepon = $request->telepon;
    //     $karyawan->tanggal_masuk = $request->tanggal_masuk;
    //     $karyawan->id_strata = $request->id_strata;
    //     $karyawan->gaji = str_replace('.', '', $request->gaji);
    //     $karyawan->alamat_lengkap = $request->alamat_lengkap;


    //     $karyawan->email_karyawan = $request->email_karyawan;

    //     // Periksa apakah password baru diberikan dan berbeda dengan password lama
    //     if ($request->has('password') && !empty($request->password) && $request->password != '********') {
    //         if ($karyawan->password != $request->password) {
    //             $karyawan->password = Hash::make($request->password);
    //         }
    //     }

    //     // $karyawan->gaji = str_replace('.', '', $request->gaji);
    //     // $karyawan->status_active = $request->has('status_active') ? 1 : 0;

    //     $karyawan->save();

    //     if ($karyawan) {
    //         return redirect()
    //             ->route('superadmin.profile')
    //             ->with([
    //                 Alert::success('Berhasil', 'Data Berhasil Diubah'),
    //             ]);
    //     } else {
    //         return redirect()
    //             ->back()
    //             ->withInput()
    //             ->with([
    //                 Alert::error('Gagal', 'Data Gagal Diubah'),
    //             ]);
    //     }
    // }



    

    // public function sendEmail($receiver, $subject, $body, $body2)
    // {
    //     if ($this->isOnline()) {
    //         $email = [
    //             'recepient' => $receiver,
    //             'fromEmail' => 'admin@kuisioner.com',
    //             'fromName' => 'Monster Group',
    //             'subject' => $subject,
    //             'body' => $body,
    //             'body2' => $body2,
    //         ];

    //         Mail::send('SuperAdmin.profile.email', $email, function ($message) use ($email) {
    //             $message->from($email['fromEmail'], $email['fromName']);
    //             $message->to($email['recepient']);
    //             $message->subject($email['subject']);
    //         });
    //     }
    // }

    // public function isOnline($site = "https://www.youtube.com/")
    // {
    //     if (@fopen($site, "r")) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }    
}