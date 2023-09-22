<?php

namespace App\Http\Controllers\ManajerKeuangan;

use App\Models\User;
use App\Models\Proyek;

use App\Models\Lampiran;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Reimbursement;
use App\Models\StatusPengajuan;
use App\Models\JenisReimbursement;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReimbursementRevisiMKExport;

use Illuminate\Support\Facades\Mail;

class RevisiVerifikasiMKController extends Controller
{
        public function index(Request $request)
        {
            $bulan_terpilih = $request->input('bulan', 'all');
            $tahun_terpilih = $request->input('tahun', 'all');
            $bulan_options = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
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
            ->select('users.nama_karyawan', 'users.status_active', 'tb_reimbursement.*', 'tb_reimbursement.id_status_pengajuan_sk','tb_jenis_reimbursement.*', 'users.*', 'tb_status_pengajuan.nama_status_pengajuan', 'sp_mk.nama_status_pengajuan as nama_status_pengajuan_mk','sp_sk.nama_status_pengajuan as nama_status_pengajuan_sk', 'sp_ky.nama_status_pengajuan as nama_status_pengajuan_ky')     
            ->whereIn('tb_reimbursement.id_status_pengajuan_mk', [35])
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


            //Menampilkan Pilihan Status Verifikasi 
            $status_pengajuans = DB::table('tb_status_pengajuan')
            ->join('tb_role', 'tb_status_pengajuan.id_role', '=', 'tb_role.id_role')
            ->where('tb_role.id_role', '=', 3)
            ->whereNotIn('tb_status_pengajuan.id_status_pengajuan', [26,41]) // Menambahkan kondisi where not in
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->get();

            
            return view('ManajerKeuangan.revisi-verifikasi.index', compact(
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
                ->select('users.nama_karyawan', 'users.status_active', 'tb_reimbursement.*', 'tb_reimbursement.id_status_pengajuan_sk','tb_jenis_reimbursement.*', 'users.*', 'tb_status_pengajuan.nama_status_pengajuan', 'sp_mk.nama_status_pengajuan as nama_status_pengajuan_mk','sp_sk.nama_status_pengajuan as nama_status_pengajuan_sk', 'sp_ky.nama_status_pengajuan as nama_status_pengajuan_ky')     
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

            return view('ManajerKeuangan.revisi-verifikasi.show', compact('reimbursement', 'lampirans','lamp1','lamp2','lampiranCount'));
        }

        public function update(Request $request, $id_reimbursement)
        {
            $reimbursement = Reimbursement::findOrFail($id_reimbursement);
        
            if ($request->has('id_status_pengajuan_mk')) {
                $reimbursement->id_status_pengajuan_mk = $request->input('id_status_pengajuan_mk');
           
                // Mengambil nama status pengajuan berdasarkan id
                $nama_status_pengajuan = StatusPengajuan::find($reimbursement->id_status_pengajuan_mk)->nama_status_pengajuan;
                $body5 = $nama_status_pengajuan;
            }

            if ($reimbursement->id_status_pengajuan_mk == 8) {
                $reimbursement->id_status_pengajuan_sk = 46;
            } else {
                $reimbursement->id_status_pengajuan_sk = null;
            }


        
            $reimbursement->total_setuju_mk = str_replace('.', '', $request->input('total_setuju_mk'));
            
            $reimbursement->tanggal_verifikasi_mk = now()->setTimezone('Asia/Jakarta');
            $reimbursement->id_user_verifikasi_mk = Auth::user()->id_user;
            $reimbursement->alasan_revisi_mk = $request->input('alasan_revisi_mk');
            $reimbursement->alasan_ditolak_mk = $request->input('alasan_ditolak_mk');
            // $reimbursement->total_setuju_mk = optional($request->input('total_setuju_mk'))->str_replace('.', '', '');
            $total_setuju_mk = $request->input('total_setuju_mk');
            if ($total_setuju_mk !== null) {
                $reimbursement->total_setuju_mk = str_replace('.', '', $total_setuju_mk);
            } else {
                $reimbursement->total_setuju_mk = null;
            }

        
            if ($reimbursement->id_status_pengajuan_mk == 8) {
               
                $email_staff_keuangan = User::where('id_role', 5)->pluck('email_karyawan');

                // Jika ada staff dengan role ID 5, kita pilih salah satu email secara acak
                if ($email_staff_keuangan->count() > 0) {
                    $random_index = rand(0, $email_staff_keuangan->count() - 1);
                    $receiver = $email_staff_keuangan[$random_index];
                } else {
                    // Jika tidak ada staff dengan role ID 5, atur $receiver ke nilai default (misalnya null)
                    $receiver = null;
                }
        
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
        
            $reimbursement->save();
        
            return redirect()->route('revisi-verifikasi-mk.index')->with('success', 'Data berhasil diperbarui');
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
                Mail::send('ManajerKeuangan.revisi-verifikasi.email', $email, function ($message) use ($email) {
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
                return Excel::download(new ReimbursementRevisiMKExport($bulan_terpilih, $tahun_terpilih, $searchValue), $fileName);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal mengunduh file Excel: ' . $e->getMessage()]);
            }            
        }
}