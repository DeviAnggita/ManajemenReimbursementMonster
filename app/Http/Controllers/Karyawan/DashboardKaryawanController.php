<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

use App\Models\Reimbursement;
use App\Models\Lampiran;
use App\Models\JenisReimbursement;
use App\Models\StatusPengajuan;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Proyek;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReimbursementKaryawanExport;

use Illuminate\Support\Facades\Mail;

class DashboardKaryawanController extends Controller
{

    public function index(Request $request)
    {
        $loggedInUserId = Auth::id(); // Assuming you have the authenticated user's ID
        $tahun_sekarang = date('Y');
        $tahun_terpilih = $request->input('tahun', $tahun_sekarang);
        $tahun_options = [];
        for ($i = 0; $i < 5; $i++) {
            $tahun_options[] = $tahun_sekarang - $i;
        }
        $reimbursements = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->leftjoin('tb_status_pengajuan as sp_mk', 'sp_mk.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
            ->leftjoin('tb_status_pengajuan as sp_ky', 'sp_ky.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_ky')        
            ->select('users.nama_karyawan', 'users.status_active', 'tb_reimbursement.*', 'tb_jenis_reimbursement.*', 'users.*', 'tb_status_pengajuan.nama_status_pengajuan', 'sp_mk.nama_status_pengajuan as nama_status_pengajuan_mk','sp_ky.nama_status_pengajuan as nama_status_pengajuan_ky')
            ->orderBy('tanggal_reimbursement', 'asc')
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
            ->where('tb_status_pengajuan.id_status_pengajuan', '=', 28)
            ->orwhere('sp_mk.id_status_pengajuan', '=', 41)
            ->orwhere('sp_ky.id_status_pengajuan', '=', 42)
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->get();
        $status_pengajuans = DB::table('tb_status_pengajuan')
            ->join('tb_role', 'tb_status_pengajuan.id_role', '=', 'tb_role.id_role')
            ->where('tb_role.id_role', '=', 4)
            ->whereNotIn('tb_status_pengajuan.id_status_pengajuan', [17])
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->where('tb_role.hapus', '=', 0) //tidak terhapus
            ->where('tb_role.status_active', '=', 1) //aktif
            ->get();
        // dd($status_pengajuans);
            
       
        $allowedStatus = DB::table('tb_status_pengajuan')
            ->where('id_status_pengajuan', '=', 8)
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->get();

        $totalReimbursementMedical = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
            ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 1)
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('tb_reimbursement.id_reimbursement', 'asc')
            ->count();
        
        $totalReimbursementPerjalananBisnis = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
            ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 2)
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->count();
        
        $totalReimbursementPenunjangKantor = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
            ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->count();
        
        $totalReimbursementOverall = $totalReimbursementMedical + $totalReimbursementPerjalananBisnis + $totalReimbursementPenunjangKantor;
        
        $percentageMedical = ($totalReimbursementOverall != 0) ? round(($totalReimbursementMedical / $totalReimbursementOverall) * 100, 2) : 0;
        $percentagePerjalananBisnis = ($totalReimbursementOverall != 0) ? round(($totalReimbursementPerjalananBisnis / $totalReimbursementOverall) * 100, 2) : 0;
        $percentagePenunjangKantor = ($totalReimbursementOverall != 0) ? round(($totalReimbursementPenunjangKantor / $totalReimbursementOverall) * 100, 2) : 0;
        

      
    
        //BAR CHART
    
        $totalReimbursementMonth = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->groupBy('month')
            ->get();

        $totalReimbursementJan = $totalReimbursementMonth->where('month', 1)->sum('total');
        $totalReimbursementFeb = $totalReimbursementMonth->where('month', 2)->sum('total');
        $totalReimbursementMar = $totalReimbursementMonth->where('month', 3)->sum('total');
        $totalReimbursementApr = $totalReimbursementMonth->where('month', 4)->sum('total');
        $totalReimbursementMay = $totalReimbursementMonth->where('month', 5)->sum('total');
        $totalReimbursementJun = $totalReimbursementMonth->where('month', 6)->sum('total');
        $totalReimbursementJul = $totalReimbursementMonth->where('month', 7)->sum('total');
        $totalReimbursementAug = $totalReimbursementMonth->where('month', 8)->sum('total');
        $totalReimbursementSep = $totalReimbursementMonth->where('month', 9)->sum('total');
        $totalReimbursementOct = $totalReimbursementMonth->where('month', 10)->sum('total');
        $totalReimbursementNov = $totalReimbursementMonth->where('month', 11)->sum('total');
        $totalReimbursementDec = $totalReimbursementMonth->where('month', 12)->sum('total');
        $highestReimbursement = $totalReimbursementMonth->max('total');



        $totalReimbursementMonthMedical = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->groupBy('month')
        ->get();

        $totalReimbursementJanMedical = $totalReimbursementMonthMedical->where('month', 1)->sum('total');
        $totalReimbursementFebMedical = $totalReimbursementMonthMedical->where('month', 2)->sum('total');
        $totalReimbursementMarMedical = $totalReimbursementMonthMedical->where('month', 3)->sum('total');
        $totalReimbursementAprMedical = $totalReimbursementMonthMedical->where('month', 4)->sum('total');
        $totalReimbursementMayMedical = $totalReimbursementMonthMedical->where('month', 5)->sum('total');
        $totalReimbursementJunMedical = $totalReimbursementMonthMedical->where('month', 6)->sum('total');
        $totalReimbursementJulMedical = $totalReimbursementMonthMedical->where('month', 7)->sum('total');
        $totalReimbursementAugMedical = $totalReimbursementMonthMedical->where('month', 8)->sum('total');
        $totalReimbursementSepMedical = $totalReimbursementMonthMedical->where('month', 9)->sum('total');
        $totalReimbursementOctMedical = $totalReimbursementMonthMedical->where('month', 10)->sum('total');
        $totalReimbursementNovMedical = $totalReimbursementMonthMedical->where('month', 11)->sum('total');
        $totalReimbursementDecMedical = $totalReimbursementMonthMedical->where('month', 12)->sum('total');
        $highestReimbursementMedical = $totalReimbursementMonthMedical->max('total');

        $totalReimbursementMonthPB = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->groupBy('month')
        ->get();

        $totalReimbursementJanPB = $totalReimbursementMonthPB->where('month', 1)->sum('total');
        $totalReimbursementFebPB = $totalReimbursementMonthPB->where('month', 2)->sum('total');
        $totalReimbursementMarPB = $totalReimbursementMonthPB->where('month', 3)->sum('total');
        $totalReimbursementAprPB = $totalReimbursementMonthPB->where('month', 4)->sum('total');
        $totalReimbursementMayPB = $totalReimbursementMonthPB->where('month', 5)->sum('total');
        $totalReimbursementJunPB = $totalReimbursementMonthPB->where('month', 6)->sum('total');
        $totalReimbursementJulPB = $totalReimbursementMonthPB->where('month', 7)->sum('total');
        $totalReimbursementAugPB = $totalReimbursementMonthPB->where('month', 8)->sum('total');
        $totalReimbursementSepPB = $totalReimbursementMonthPB->where('month', 9)->sum('total');
        $totalReimbursementOctPB = $totalReimbursementMonthPB->where('month', 10)->sum('total');
        $totalReimbursementNovPB = $totalReimbursementMonthPB->where('month', 11)->sum('total');
        $totalReimbursementDecPB = $totalReimbursementMonthPB->where('month', 12)->sum('total');
        $highestReimbursementPB = $totalReimbursementMonthPB->max('total');


        $totalReimbursementMonthPK = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->groupBy('month')
        ->get();

        $totalReimbursementJanPK = $totalReimbursementMonthPK->where('month', 1)->sum('total');
        $totalReimbursementFebPK = $totalReimbursementMonthPK->where('month', 2)->sum('total');
        $totalReimbursementMarPK = $totalReimbursementMonthPK->where('month', 3)->sum('total');
        $totalReimbursementAprPK = $totalReimbursementMonthPK->where('month', 4)->sum('total');
        $totalReimbursementMayPK = $totalReimbursementMonthPK->where('month', 5)->sum('total');
        $totalReimbursementJunPK = $totalReimbursementMonthPK->where('month', 6)->sum('total');
        $totalReimbursementJulPK = $totalReimbursementMonthPK->where('month', 7)->sum('total');
        $totalReimbursementAugPK = $totalReimbursementMonthPK->where('month', 8)->sum('total');
        $totalReimbursementSepPK = $totalReimbursementMonthPK->where('month', 9)->sum('total');
        $totalReimbursementOctPK = $totalReimbursementMonthPK->where('month', 10)->sum('total');
        $totalReimbursementNovPK = $totalReimbursementMonthPK->where('month', 11)->sum('total');
        $totalReimbursementDecPK = $totalReimbursementMonthPK->where('month', 12)->sum('total');
        $highestReimbursementPK = $totalReimbursementMonthPK->max('total');



        
        //PROGRESS BAR KEPALA DIVISI
        $MenungguKaryawanreimbursement = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1,28])
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->get();
        $totalMenungguKaryawanReimbursement = count($MenungguKaryawanreimbursement); 
   

        $SetujuKaryawanreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10,21,8])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuKaryawanReimbursement = count($SetujuKaryawanreimbursement); 

        $RevisiKaryawanreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [20,34,35])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiKaryawanReimbursement = count($RevisiKaryawanreimbursement); 

        $TolakKaryawanreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11,22,9])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakKaryawanReimbursement = count($TolakKaryawanreimbursement); 


        $SelesaiKaryawanreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [26,17])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSelesaiKaryawanReimbursement = count($SelesaiKaryawanreimbursement); 
        
        $PembayaranSesuaiKaryawanreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [6])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalPembayaranSesuaiKaryawanReimbursement = count($PembayaranSesuaiKaryawanreimbursement); 

        $PembayaranTidakSesuaiKaryawanreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('tb_reimbursement.id_user', '=', $loggedInUserId)
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [5])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalPembayaranTidakSesuaiKaryawanReimbursement = count($PembayaranTidakSesuaiKaryawanreimbursement); 



        $totalKaryawanReimbursement=$totalMenungguKaryawanReimbursement+ $totalSetujuKaryawanReimbursement+$totalRevisiKaryawanReimbursement+$totalTolakKaryawanReimbursement+$totalSelesaiKaryawanReimbursement
        +$totalPembayaranSesuaiKaryawanReimbursement+$totalPembayaranTidakSesuaiKaryawanReimbursement;
        
        $percentageMenungguKaryawan = $totalKaryawanReimbursement != 0 ? round(($totalMenungguKaryawanReimbursement / $totalKaryawanReimbursement) * 100, 2) : 0;
        $percentageSetujuKaryawan = $totalKaryawanReimbursement != 0 ? round(($totalSetujuKaryawanReimbursement / $totalKaryawanReimbursement) * 100, 2) : 0;
        $percentageRevisiKaryawan = $totalKaryawanReimbursement != 0 ? round(($totalRevisiKaryawanReimbursement / $totalKaryawanReimbursement) * 100, 2) : 0;
        $percentageTolakKaryawan = $totalKaryawanReimbursement != 0 ? round(($totalTolakKaryawanReimbursement / $totalKaryawanReimbursement) * 100, 2) : 0;
        $percentageSelesaiKaryawan = $totalKaryawanReimbursement != 0 ? round(($totalSelesaiKaryawanReimbursement / $totalKaryawanReimbursement) * 100, 2) : 0;
        $percentagePembayaranSesuaiKaryawan = $totalKaryawanReimbursement != 0 ? round(($totalPembayaranSesuaiKaryawanReimbursement / $totalKaryawanReimbursement) * 100, 2) : 0;
        $percentagePembayaranTidakSesuaiKaryawan = $totalKaryawanReimbursement != 0 ? round(($totalPembayaranTidakSesuaiKaryawanReimbursement / $totalKaryawanReimbursement) * 100, 2) : 0;
        // dd($percentagePembayaranSesuaiKaryawan);
        
        return view('karyawan.dashboard.index', compact(
        'tahun_terpilih',
        'tahun_options',
        'tahun_sekarang',
        'allowedStatus',
        'reimbursements', 
        'status_pengajuans',
        'totalReimbursementMedical',
        'totalReimbursementPerjalananBisnis','totalReimbursementPenunjangKantor',
        'highestReimbursement',
        'totalReimbursementJan',
        'totalReimbursementFeb',
        'totalReimbursementMar',
        'totalReimbursementApr',
        'totalReimbursementMay',
        'totalReimbursementJun',
        'totalReimbursementJul',
        'totalReimbursementAug',
        'totalReimbursementSep',
        'totalReimbursementOct',
        'totalReimbursementNov',
        'totalReimbursementDec',
        'totalReimbursementJanMedical',
        'totalReimbursementFebMedical',
        'totalReimbursementMarMedical',
        'totalReimbursementAprMedical',
        'totalReimbursementMayMedical',
        'totalReimbursementJunMedical',
        'totalReimbursementJulMedical',
        'totalReimbursementAugMedical',
        'totalReimbursementSepMedical',
        'totalReimbursementOctMedical',
        'totalReimbursementNovMedical',
        'totalReimbursementDecMedical',
        'totalReimbursementJanPB',
        'totalReimbursementFebPB',
        'totalReimbursementMarPB',
        'totalReimbursementAprPB',
        'totalReimbursementMayPB',
        'totalReimbursementJunPB',
        'totalReimbursementJulPB',
        'totalReimbursementAugPB',
        'totalReimbursementSepPB',
        'totalReimbursementOctPB',
        'totalReimbursementNovPB',
        'totalReimbursementDecPB',
        'totalReimbursementJanPK',
        'totalReimbursementFebPK',
        'totalReimbursementMarPK',
        'totalReimbursementAprPK',
        'totalReimbursementMayPK',
        'totalReimbursementJunPK',
        'totalReimbursementJulPK',
        'totalReimbursementAugPK',
        'totalReimbursementSepPK',
        'totalReimbursementOctPK',
        'totalReimbursementNovPK',
        'totalReimbursementDecPK',
        'totalMenungguKaryawanReimbursement',
        'totalSetujuKaryawanReimbursement',
        'totalRevisiKaryawanReimbursement',
        'totalTolakKaryawanReimbursement',
        'totalSelesaiKaryawanReimbursement',
        'totalPembayaranSesuaiKaryawanReimbursement',
        'totalPembayaranTidakSesuaiKaryawanReimbursement',
        'percentageMedical', 
        'percentagePerjalananBisnis', 
        'percentagePenunjangKantor',
        'percentageMenungguKaryawan',
        'percentageSetujuKaryawan',
        'percentageRevisiKaryawan',
        'percentageTolakKaryawan',
        'percentageSelesaiKaryawan',
        'percentagePembayaranSesuaiKaryawan',
        'percentagePembayaranTidakSesuaiKaryawan'
    ));
    }


    public function exportExcel(Request $request)
    {

        $tahun_sekarang = date('Y');
        $tahun_terpilih = $request->input('tahun', $tahun_sekarang);
        $uniqueNumber = time();

        $fileName = 'Data Reimbursement_' .$tahun_terpilih . '_' .  $uniqueNumber . '.xlsx';
        
        return Excel::download(new ReimbursementKaryawanExport($tahun_terpilih), $fileName);
    }



    public function updateStatus(Request $request, $id_reimbursement)
    {
        $reimbursement = Reimbursement::findOrFail($id_reimbursement);

        if ($request->has('id_status_pengajuan')) {
            $reimbursement->id_status_pengajuan = $request->input('id_status_pengajuan');
        
        // Mengambil nama status pengajuan berdasarkan id
        $nama_status_pengajuan = StatusPengajuan::find($reimbursement->id_status_pengajuan)->nama_status_pengajuan;

        $body5 = $nama_status_pengajuan;
        }
        


        if ($reimbursement->id_status_pengajuan == 6 || $reimbursement->id_status_pengajuan == 5) {
            $email_manajerkeuangan = User::where('id_role', 3)->pluck('email_karyawan');
            $receiver = $email_manajerkeuangan[0];
            // dd($receiver); // Verifikasi nilai $receiver
            $subject = "Konfirmasi Pembayaran Reimbursement Karyawan";
            $body = $reimbursement->nama_karyawan;
            $id_jenis_reimbursement = $reimbursement->id_jenis_reimbursement;
            $jenis_reimbursement = DB::table('tb_reimbursement')
                ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
                ->where('tb_reimbursement.id_jenis_reimbursement', $id_jenis_reimbursement)
                ->select('tb_jenis_reimbursement.nama_jenis_reimbursement')
                ->first();
            $nama_jenis_reimbursement = $jenis_reimbursement->nama_jenis_reimbursement;
        
            $body2 = $nama_jenis_reimbursement;
            $body3 = $reimbursement->total; // Ambil nilai total dari $reimbursement
            $body4 = $reimbursement->keterangan;
           
            // $body5 = $nama_status_pengajuan;
        
            // Panggil fungsi sendEmail()
            $this->sendEmail($receiver, $subject, $body, $body2, $body3, $body4, $body5 );
        }
                
        $reimbursement->save();

        return redirect()->route('karyawan.dashboard')->with('success', 'Data berhasil diperbarui');
    }

    public function sendEmail($receiver, $subject, $body, $body2, $body3, $body4, $body5)
    {
        if ($this->isOnline()) {
            $email = [
                'recepient' => $receiver,
                'fromEmail' => 'reimbursement@gmail.com',
                'fromName' => 'Monster Group',
                'subject' => $subject,
                'body' => $body,
                'body2' => $body2,
                'body3' => $body3,
                'body4' => $body4,
                'body5' => $body5,
            ];

            // Pastikan template email 'KepalaDivisi.verifikasi.email' tersedia
            Mail::send('Karyawan.medical.email', $email, function ($message) use ($email) {
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
}