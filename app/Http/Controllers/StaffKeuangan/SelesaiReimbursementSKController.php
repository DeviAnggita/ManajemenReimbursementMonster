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

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReimbursementSelesaiSKExport;



class SelesaiReimbursementSKController extends Controller
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
            ->whereIn('tb_reimbursement.id_status_pengajuan_ky', [17])
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

            $status_pengajuans = DB::table('tb_status_pengajuan')
            ->join('tb_role', 'tb_status_pengajuan.id_role', '=', 'tb_role.id_role')
            ->where('tb_role.id_role', '=', 3)
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->get();
            
            return view('StaffKeuangan.selesai-reimbursement.index', compact(
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
                ->select('tb_supplier.nama_supplier')
                ->distinct()
                ->first();

                // dd($lamp1);

                $lamp2 = DB::table('tb_lampiran')
                ->join('tb_proyek', 'tb_lampiran.id_proyek', '=', 'tb_proyek.id_proyek')
                ->where('tb_lampiran.id_reimbursement', $id_reimbursement)
                ->select('tb_proyek.nama_proyek')
                ->distinct()
                ->first();

                // dd($lamp2);
            $lampirans = DB::table('tb_lampiran')
                ->where('id_reimbursement', '=', $id_reimbursement)
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

            return view('StaffKeuangan.selesai-reimbursement.show', compact('reimbursement', 'lampirans','lamp1','lamp2','lampiranCount'));
        }


        public function exportExcel(Request $request)
        {
            $bulan_terpilih = $request->input('bulan', 'all');
            $tahun_terpilih = $request->input('tahun', 'all');
            $searchValue = $request->input('search'); // Memperoleh nilai parameter 'search' dari URL
            // dd($searchValue);
        
            $uniqueNumber = time();
            $fileName = 'Data Reimbursement Verifikasi_' . $bulan_terpilih . '_' . $tahun_terpilih . '_' . $uniqueNumber . '.xlsx';
            
            try {
                return Excel::download(new ReimbursementSelesaiSKExport($bulan_terpilih, $tahun_terpilih, $searchValue), $fileName);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal mengunduh file Excel: ' . $e->getMessage()]);
            }            
        }
}