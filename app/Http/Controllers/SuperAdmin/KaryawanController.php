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


class KaryawanController extends Controller
{

    public function index()
    {
        $karyawans = DB::table('users')
        ->join('tb_divisi', 'users.id_divisi', '=', 'tb_divisi.id_divisi')
        ->join('tb_strata', 'users.id_strata', '=', 'tb_strata.id_strata')
        ->join('tb_role', 'users.id_role', '=', 'tb_role.id_role')
        ->select('users.*', 'users.status_active', 'tb_divisi.nama_divisi', 'tb_role.nama_role', 'tb_strata.nama_strata')
        ->where('tb_divisi.hapus', '!=', 1)
        ->where('tb_strata.hapus', '!=', 1)
        ->where('tb_role.hapus', '!=', 1)
        ->where('users.hapus', '!=', 1)
        ->orderBy('nama_karyawan', 'asc')
        ->get();
                
        $divisis = Divisi::where('hapus', '!=', 1)->get();
        $stratas = Strata::where('hapus', '!=', 1)->get();
        $roles = Role::where('hapus', '!=', 1)->get();
        
        return view('superadmin.karyawan.index', compact('karyawans', 'divisis', 'stratas', 'roles'));
    }


    public function create()
    {
        $divisis = Divisi::get();
        $stratas = Strata::get();
        $roles = Role::get();
        return view('superadmin.karyawan.create', compact('divisis, stratas, roles'));
    }


    public function store(Request $request)
    {
        $nomor_identitas_karyawan = User::where(
            'nomor_identitas_karyawan',
            $request->nomor_identitas_karyawan
        )->first();

        $email_karyawan = User::where(
            'email_karyawan',
            $request->email_karyawan
        )->first();

        $divisi = User::where(
            'id_divisi',
            $request->id_divisi
        )->first();

        $existingKaryawan = User::where('nama_karyawan', $request->nama_karyawan)
            ->where('id_divisi', $request->id_divisi)
            ->first();

        if ($nomor_identitas_karyawan) {
            return redirect()
                ->route('karyawan.index')
                ->with([
                    Alert::error('Gagal', 'Nomor Identitas Karyawan Sudah Ada')
                ]);
        } else if ($email_karyawan) {
            return redirect()
                ->route('karyawan.index')
                ->with([
                    Alert::error('Gagal', 'Email Karyawan Sudah Ada')
                ]);
        } else if ($existingKaryawan) {
            return redirect()
                ->route('karyawan.index')
                ->with([
                    Alert::error('Gagal', 'Nama Karyawan dan Divisi sudah ada')
                ]);
        }

        $validator = Validator::make($request->all(), [
            'id_divisi' => 'required',
            'id_strata' => 'required',
            'id_role' => 'required',
            'nomor_identitas_karyawan' => 'required|min:5',
            'nama_karyawan' => 'required',
            'email_karyawan' => 'required|email',
            'password' => 'required|min:8',
            'gaji' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->route('karyawan.index')
                ->withErrors($validator)
                ->withInput()
                ->with([
                    Alert::error('Gagal',  'Pengisian form belum sesuai dengan validasi.')
                    // 'error_message' => 'Validasi form tidak berhasil.',
                ]);
        }
        
        

       
        

        $status_active = $request->has('status_active') ? 1 : 0;

        $karyawan = User::create([
            'id_divisi' => $request->id_divisi,
            'id_strata' => $request->id_strata,
            'id_role' => $request->id_role,
            'nomor_identitas_karyawan' => $request->nomor_identitas_karyawan,
            'nama_karyawan' => $request->nama_karyawan,
            'email_karyawan' => $request->email_karyawan,
            'password' => Hash::make($request->password),
            'gaji' =>  str_replace('.', '', $request->gaji),
            'status_active' => $status_active,
        ]);

        if ($karyawan) {
            // Mengambil email karyawan berdasarkan id
            $receiver = $request->email_karyawan;
            // dd($receiver);
            $subject = "Login Information - Reimbursement";
            $body = $request->email_karyawan;
            $body2 = $request->password;

            // Panggil fungsi sendEmail()
            $this->sendEmail($receiver, $subject, $body, $body2);

            return redirect()
                ->route('karyawan.index')
                ->with([
                    Alert::success('Berhasil', 'Data Karyawan Berhasil Ditambahkan')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Karyawan Gagal Ditambahkan')
                ]);
        }
    }

    public function show($id_user)
    {
        $karyawans = DB::table('users')
            ->join('tb_divisi', 'users.id_divisi', '=', 'tb_divisi.id_divisi')
            ->join('tb_strata', 'users.id_strata', '=', 'tb_strata.id_strata')
            ->join('tb_role', 'users.id_role', '=', 'tb_role.id_role')
            ->where('id_user', $id_user)->first();
        return view('superadmin.karyawan.show', compact('karyawans'));
    }

    public function edit($id_user)
    {
        $karyawan = User::findOrFail($id_user);
        $divisis = Divisi::get();
        $stratas = Strata::get();
        $roles = Role::get();        
        return view('superadmin.karyawan.update', compact('karyawan', 'divisis', 'stratas', 'roles'));
    }


    public function update(Request $request, $id_user)
    {
        $karyawan = User::findOrFail($id_user);

        // Menghitung jumlah Super Admin dengan status active
        $activeSuperAdmins = User::where('id_role', 1)
                                ->where('status_active', 1)
                                ->where('hapus', 0)
                                ->count();

        // Periksa apakah karyawan yang sedang diubah adalah Super Admin dengan status active
        $isSuperAdmin = $karyawan->id_role == 1 && $karyawan->status_active == 1;

        // Periksa apakah hanya ada 1 Super Admin yang aktif
        if ($isSuperAdmin && $activeSuperAdmins <= 1 && !$request->has('status_active')) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Tidak dapat melakukan perubahan. Harus ada setidaknya 1 Super Admin yang aktif.'),
                ]);
        }


        // Lanjutkan dengan pembaruan data karyawan

        $karyawan->id_divisi = $request->id_divisi;
        $karyawan->id_strata = $request->id_strata;
        $karyawan->id_role = $request->id_role;
        $karyawan->nomor_identitas_karyawan = $request->nomor_identitas_karyawan;
        $karyawan->nama_karyawan = $request->nama_karyawan;
        $karyawan->email_karyawan = $request->email_karyawan;

        // Periksa apakah password baru diberikan dan berbeda dengan password lama
        if ($request->has('password') && !empty($request->password) && $request->password != '********') {
            if ($karyawan->password != $request->password) {
                $karyawan->password = Hash::make($request->password);
            }
        }

        $karyawan->gaji = str_replace('.', '', $request->gaji);
        $karyawan->status_active = $request->has('status_active') ? 1 : 0;

        $karyawan->save();

        if ($karyawan) {
            return redirect()
                ->route('karyawan.index')
                ->with([
                    Alert::success('Berhasil', 'Data Karyawan Berhasil Diubah'),
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Karyawan Gagal Diubah'),
                ]);
        }
    }

    public function sendEmail($receiver, $subject, $body, $body2)
    {
        if ($this->isOnline()) {
            $email = [
                'recepient' => $receiver,
                'fromEmail' => 'admin@kuisioner.com',
                'fromName' => 'Monster Group',
                'subject' => $subject,
                'body' => $body,
                'body2' => $body2,
            ];

            Mail::send('SuperAdmin.karyawan.email', $email, function ($message) use ($email) {
                $message->from($email['fromEmail'], $email['fromName']);
                $message->to($email['recepient']);
                $message->subject($email['subject']);
            });
        }
    }

    public function isOnline($site = "https://www.youtube.com/")
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($id_user)
    {
        $karyawan = User::findOrFail($id_user);
    
        if ($karyawan->id_role == 1) {
            $superAdminCount = User::where('id_role', 1)
                ->where('hapus', '!=', 1)
                ->count();
    
            if ($superAdminCount <= 1) {
                return redirect()
                    ->route('karyawan.index')
                    ->with([
                        Alert::error('Gagal', 'Setidaknya ada satu user yang memiliki peran SuperAdmin')
                    ]);
            }
        }
    
        $karyawan->hapus = 1;
        $karyawan->save();
    
        if ($karyawan) {
            return redirect()
                ->route('karyawan.index')
                ->with('success', 'Data karyawan berhasil dihapus');
        } else {
            return redirect()
                ->route('karyawan.index')
                ->with('error', 'Data karyawan gagal dihapus');
        }
    }
    
    
    
}