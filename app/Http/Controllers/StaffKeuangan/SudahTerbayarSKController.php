<?php

namespace App\Http\Controllers\StaffKeuangan;

use App\Models\User;
use App\Models\Proyek;

use App\Models\Lampiran;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\StatusPengajuan;
use App\Models\JenisReimbursement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReimbursementSudahTerbayarSKExport;

use Illuminate\Support\Facades\Mail;


class SudahTerbayarSKController extends Controller
{
    public function index(Request $request)
    {
        $bulan_terpilih = $request->input('bulan', 'all');
        $tahun_terpilih = $request->input('tahun', 'all');
            
        $bulan_options = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        // $tahun_options = [2022, 2023, 2024, 2025, 2026, 2027, 2028]; // Ganti dengan daftar tahun yang sesuai dengan kebutuhan Anda

        $tahun_sekarang = date('Y');
        $tahun_options = [];

        for ($i = 0; $i < 5; $i++) {
            $tahun_options[] = $tahun_sekarang - $i;
        }  

        $reimbursements = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->leftjoin('tb_status_pengajuan as sp_sk', 'sp_sk.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_sk')        
            ->leftjoin('tb_status_pengajuan as sp_mk', 'sp_mk.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')        
            ->leftjoin('tb_status_pengajuan as sp_ky', 'sp_ky.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_ky')   
            ->select('users.nama_karyawan', 'users.status_active', 'tb_reimbursement.*', 'tb_jenis_reimbursement.*', 'users.*', 'tb_status_pengajuan.nama_status_pengajuan', 'sp_mk.nama_status_pengajuan as nama_status_pengajuan_mk','sp_sk.nama_status_pengajuan as nama_status_pengajuan_sk','sp_ky.nama_status_pengajuan as nama_status_pengajuan_ky')    
            ->whereIn('tb_reimbursement.id_status_pengajuan_sk', [45])
            ->whereIn('tb_reimbursement.id_status_pengajuan_ky', [42])
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->orderBy('tb_reimbursement.updated_at', 'desc');
            // Filter berdasarkan tahun
            if ($tahun_terpilih !== 'all') {
                $reimbursements->whereYear('tb_reimbursement.tanggal_reimbursement', $tahun_terpilih);
            }
            
            // Filter berdasarkan bulan
            if ($bulan_terpilih !== 'all') {
                $reimbursements->whereMonth('tb_reimbursement.tanggal_reimbursement', $bulan_terpilih);
            }
            
            $reimbursements = $reimbursements->get();
            
            foreach ($reimbursements as $item) {
                if ($item->id_status_pengajuan_sk == 45) {
                    // $limaHariKemudian = Carbon::parse($item->tanggal_verifikasi_sk, 'Asia/Jakarta')->addMinutes(2);
                    $limaHariKemudian = Carbon::parse($item->tanggal_verifikasi_sk, 'Asia/Jakarta')->addDay(5);
                    
                    if (now()->timezone('Asia/Jakarta') >= $limaHariKemudian) {
                        // Mengubah id_status_pengajuan menjadi 17
                        $updatedRows = DB::table('tb_reimbursement')
                            ->where('id_reimbursement', $item->id_reimbursement)
                            ->update(['id_status_pengajuan_ky' => 17]);
            
                        if ($updatedRows) {
                            $item->id_status_pengajuan_ky = 17;
                        }
                    }
                }
            }
            // dd($limaHariKemudian);            
            
    
        //Menampilkan Pilihan Status Verifikasi 
        $status_pengajuans = DB::table('tb_status_pengajuan')
            ->join('tb_role', 'tb_status_pengajuan.id_role', '=', 'tb_role.id_role')
            ->where('tb_role.id_role', '=', 5)
            ->whereNotIn('tb_status_pengajuan.id_status_pengajuan', [46]) 
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->get();
    
        // Ubah status pengajuan pada setiap reimbursement
        foreach ($reimbursements as $reimbursement) {
            $reimbursementModel = Reimbursement::find($reimbursement->id_reimbursement);
            $reimbursementModel->setStatusPengajuan();
        }
    
        return view('StaffKeuangan.sudah-terbayar.index', compact(
            'reimbursements', 
            'status_pengajuans',
            'bulan_terpilih',
            'bulan_options',
            'tahun_terpilih',
            'tahun_options'
        ));
    }
    
        public function show($id_reimbursement)
        {
            $reimbursement = DB::table('tb_reimbursement')
                ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
                ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')     
                ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
                ->leftjoin('tb_status_pengajuan as sp_sk', 'sp_sk.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_sk')        
                ->leftjoin('tb_status_pengajuan as sp_mk', 'sp_mk.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')        
                ->leftjoin('tb_status_pengajuan as sp_ky', 'sp_ky.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_ky')   
                ->select('users.nama_karyawan', 'users.status_active', 'tb_reimbursement.*', 'tb_jenis_reimbursement.*', 'users.*', 'tb_status_pengajuan.nama_status_pengajuan', 'sp_mk.nama_status_pengajuan as nama_status_pengajuan_mk','sp_sk.nama_status_pengajuan as nama_status_pengajuan_sk','sp_ky.nama_status_pengajuan as nama_status_pengajuan_ky')    
                ->whereIn('tb_reimbursement.id_status_pengajuan_sk', [45])
                ->where('users.hapus', '=', 0) //tidak terhapus
                ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
                ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
                ->where('users.status_active', '=', 1) //aktif
                ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
                ->where('tb_reimbursement.id_reimbursement', '=', $id_reimbursement)
                ->first();
            
                $lamp1 = DB::table('tb_lampiran')
                ->join('tb_supplier', 'tb_lampiran.id_supplier', '=', 'tb_supplier.id_supplier')
                ->where('tb_lampiran.id_reimbursement', $id_reimbursement)
                ->where('tb_lampiran.hapus', '=', 0) //tidak terhapus
                ->select('tb_supplier.nama_supplier')
                ->distinct()
                ->first();

                // dd($lamp1);

                $lamp2 = DB::table('tb_lampiran')
                ->join('tb_proyek', 'tb_lampiran.id_proyek', '=', 'tb_proyek.id_proyek')
                ->where('tb_lampiran.id_reimbursement', $id_reimbursement)
                ->where('tb_lampiran.hapus', '=', 0) //tidak terhapus
                ->select('tb_proyek.nama_proyek')
                ->distinct()
                ->first();

                // dd($lamp2);
            $lampirans = DB::table('tb_lampiran')
                ->where('id_reimbursement', '=', $id_reimbursement)
                ->where('tb_lampiran.hapus', '=', 0) //tidak terhapus
                ->get();

            $lampiranCount = $lampirans->count();
            $lampiranCount = $lampiranCount > 0 ? $lampiranCount : 1; // Set minimum count to 1

            foreach ($lampirans as $lampiran) {
                if (strpos($lampiran->file, '.pdf') !== false) {
                    $lampiran->fileUrl = asset('LampiranPDFBaru/' . $lampiran->file);
                } else {
                    $lampiran->fileUrl = asset('LampiranBaru/' . $lampiran->file);
                }
            }
            // dd($reimbursement);

            return view('StaffKeuangan.sudah-terbayar.show', compact('reimbursement', 'lampirans','lamp1','lamp2','lampiranCount'));
        }

    



        public function update(Request $request, $id_reimbursement)
        {
            // $reimbursement = Reimbursement::findOrFail($id_reimbursement);
        
            // if ($request->has('id_status_pengajuan_sk')) {
            //     $reimbursement->id_status_pengajuan_sk = $request->input('id_status_pengajuan_sk');
     
        
            //     // Mengambil nama status pengajuan berdasarkan id
            //     $nama_status_pengajuan = StatusPengajuan::find($reimbursement->id_status_pengajuan_sk)->nama_status_pengajuan;
            //     $body5 = $nama_status_pengajuan;
            // }
            $reimbursement = Reimbursement::findOrFail($id_reimbursement);
            
            // Determine the new status based on the checkbox value
            $newStatus = $request->has('id_status_pengajuan_sk') ? $request->input('id_status_pengajuan_sk') : 46;
            $reimbursement->id_status_pengajuan_sk = $newStatus;
        
            // Mengambil nama status pengajuan berdasarkan id
            $nama_status_pengajuan = StatusPengajuan::find($reimbursement->id_status_pengajuan_sk)->nama_status_pengajuan;
            $body5 = $nama_status_pengajuan;


            
            $reimbursement->tanggal_verifikasi_sk = now()->setTimezone('Asia/Jakarta');
            $reimbursement->id_user_verifikasi_sk = Auth::user()->id_user;
            $reimbursement->total_dibayar_sk = str_replace('.', '', $request->input('total_dibayar_sk'));

           
        
            if ($reimbursement->id_status_pengajuan_sk == 45) {
                $reimbursement->id_status_pengajuan_ky = 42;
            } else {
                $reimbursement->id_status_pengajuan_ky = null;
            }
        
            if ($reimbursement->id_status_pengajuan_sk == 45) {
                // Mendapatkan id_user dari objek $reimbursement
                $id_user = $reimbursement->id_user;
                // Mendapatkan email_karyawan berdasarkan id_user
                $user = User::findOrFail($id_user);
                $receiver = $user->email_karyawan;
                // dd($receiver);
        
                $id_user = $reimbursement->id_user;
                // Ambil data karyawan dari tabel users berdasarkan id_user
                $nama_karyawan = DB::table('users')
                    ->where('id_user', $id_user)
                    ->select('nama_karyawan')
                    ->first()
                    ->nama_karyawan;

                $subject = "Mohon Verifikasi Status Pengajuan Reimbursment Karyawan";
                $body = $nama_karyawan; // ambil nama_karyawan dari id_user yang berelasi dengan id_user di table users yang diambil nama_karyawannya 
                
                $id_jenis_reimbursement = $reimbursement->id_jenis_reimbursement;
                $jenis_reimbursement = DB::table('tb_reimbursement')
                    ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
                    ->where('tb_reimbursement.id_jenis_reimbursement', $id_jenis_reimbursement)
                    ->select('tb_jenis_reimbursement.nama_jenis_reimbursement')
                    ->first();
                $nama_jenis_reimbursement = $jenis_reimbursement->nama_jenis_reimbursement;
                $body2 = $nama_jenis_reimbursement;
                $body3 = 'Rp. ' . number_format($reimbursement->total, 0, ',', '.') . ',00';
                $body4 = $reimbursement->keterangan;
                $body6 = 'Rp. ' . number_format($reimbursement->total_setuju_mk, 0, ',', '.') . ',00';
        
                // Panggil fungsi sendEmail()
                $this->sendEmail($receiver, $subject, $body, $body2, $body3, $body4, $body5, $body6);
        
            }


            if ($request->hasFile('file_dibayar_sk')) {
                $uploadedFile = $request->file('file_dibayar_sk');
                // dd($uploadedFile);
                $extension = $uploadedFile->getClientOriginalExtension();
                $allowedExtensions = ['png', 'jpeg', 'jpg'];

                if (in_array($extension, $allowedExtensions)) {
                    $destinationPath = public_path('BuktiPembayaran');
                    
                   
                    $id_user = Auth::user()->id_user;
                    $karyawan = User::findOrFail($id_user);
                    $nama_karyawan = $karyawan->nama_karyawan;
                  
                    $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $uploadedFile->getClientOriginalExtension();
                    $bulan = date('m');
                    $tahun = date('Y');
                    $uniqenumber = uniqid();
                    $time = time();
                    $fileName = $nama_karyawan . '_' . $originalFileName . '_' . $bulan . '_' . $tahun . '_' . $uniqenumber . '_' . $time . '.' . $extension;

                    $uploadedFile->move($destinationPath, $fileName);

                    $reimbursement->file_dibayar_sk = $fileName;
                    $reimbursement->save();
                
                } else {
                    return redirect()->back()->withErrors(["file_dibayar_sk" => 'Hanya file PNG, JPEG, JPG yang diizinkan.']);
                }
            }
    
        
            // $reimbursement->save();
            // dd($reimbursement);
        
            return redirect()->route('sudah-terbayar-sk.index')->with('success', 'Data berhasil diperbarui');
        }
        
        public function sendEmail($receiver, $subject, $body, $body2, $body3, $body4, $body5, $body6)
        {
            if ($this->isOnline()) {
                $email = [
                    'recipient' => $receiver,
                    'fromEmail' => 'reimbursement@gmail.com',
                    'fromName' => 'Monster Group',
                    'subject' => $subject,
                    'body' => $body,
                    'body2' => $body2,
                    'body3' => $body3,
                    'body4' => $body4,
                    'body5' => $body5,
                    'body6' => $body6,
                ];
        
                // Pastikan template email 'ManajerKeuangan.verifikasi.email' tersedia
                Mail::send('StaffKeuangan.sudah-terbayar.email', $email, function ($message) use ($email) {
                    $message->from($email['fromEmail'], $email['fromName']);
                    $message->to($email['recipient']);
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

 


        public function exportExcel(Request $request)
        {
            $bulan_terpilih = $request->input('bulan', 'all');
            $tahun_terpilih = $request->input('tahun', 'all');
            $searchValue = $request->input('search'); // Memperoleh nilai parameter 'search' dari URL
            // dd($searchValue);
        
            $uniqueNumber = time();
            $fileName = 'Data Verifikasi Setuju Reimbursement_' . $bulan_terpilih . '_' . $tahun_terpilih . '_' . $uniqueNumber . '.xlsx';
            
            try {
                return Excel::download(new ReimbursementSudahTerbayarSKExport($bulan_terpilih, $tahun_terpilih, $searchValue), $fileName);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal mengunduh file Excel: ' . $e->getMessage()]);
            }            
        }

}