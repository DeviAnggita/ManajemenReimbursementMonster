<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\User;
use App\Models\Proyek;
use App\Models\Lampiran;
use App\Models\Supplier;
use Illuminate\Http\Request;

use App\Models\Reimbursement;
use App\Models\StatusPengajuan;
use Illuminate\Http\UploadedFile;
use App\Models\JenisReimbursement;
use Illuminate\Support\Facades\DB;
use App\Exports\ReimbursementExport;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;


class DashboardController extends Controller
{

    public function index()
    {
        $tahun_sekarang = date('Y');
        $tahun_terpilih = $request->input('tahun', $tahun_sekarang);
        $tahun_options = [2022, 2023,2024,2025]; // Ganti dengan daftar tahun yang sesuai dengan kebutuhan Anda

                
        $totalReimbursementMedical = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_reimbursement.id_jenis_reimbursement', '=', 'tb_jenis_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_reimbursement.id_status_pengajuan', '=', 'tb_status_pengajuan.id_status_pengajuan')
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereNotIn('tb_status_pengajuan.id_status_pengajuan', [26,17,6,5])
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->count();

        $MenungguReimbursementMedical = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1, 28])
            ->where('tb_reimbursement.id_jenis_reimbursement', 1)
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
            ->orderBy('id_reimbursement', 'asc')
            ->get();
        $totalMenungguReimbursementMedical  = count($MenungguReimbursementMedical); 

        $SetujuReimbursementMedical = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [8,10]) //10,21
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuReimbursementMedical = count($SetujuReimbursementMedical); 

        $RevisiReimbursementMedical = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [20,34,35])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiReimbursementMedical = count($RevisiReimbursementMedical); 

        $TolakReimbursementMedical  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11,22,9])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakReimbursementMedical  = count($TolakReimbursementMedical ); 





        
        $totalReimbursementPerjalananBisnis = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_reimbursement.id_jenis_reimbursement', '=', 'tb_jenis_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_reimbursement.id_status_pengajuan', '=', 'tb_status_pengajuan.id_status_pengajuan')
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereNotIn('tb_status_pengajuan.id_status_pengajuan', [26,17,6,5])
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->count();

        $MenungguReimbursementPerjalananBisnis= DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1, 28])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalMenungguReimbursementPerjalananBisnis = count($MenungguReimbursementPerjalananBisnis); 

        $SetujuReimbursementPerjalananBisnis = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [8,10]) //10,21
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuReimbursementPerjalananBisnis = count($SetujuReimbursementPerjalananBisnis); 

        $RevisiReimbursementPerjalananBisnis = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [20,34,35])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiReimbursementPerjalananBisnis = count($RevisiReimbursementPerjalananBisnis); 

        $TolakReimbursementPerjalananBisnis  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11,22,9])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakReimbursementPerjalananBisnis  = count($TolakReimbursementPerjalananBisnis ); 




        $totalReimbursementPenunjangKantor = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_reimbursement.id_jenis_reimbursement', '=', 'tb_jenis_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_reimbursement.id_status_pengajuan', '=', 'tb_status_pengajuan.id_status_pengajuan')
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereNotIn('tb_status_pengajuan.id_status_pengajuan', [26,17,6,5])
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->count();
        
        $MenungguReimbursementPenunjangKantor= DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1, 28])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalMenungguReimbursementPenunjangKantor = count($MenungguReimbursementPenunjangKantor); 

        $SetujuReimbursementPenunjangKantor = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [8,10]) //10,21
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuReimbursementPenunjangKantor = count($SetujuReimbursementPenunjangKantor); 

        $RevisiReimbursementPenunjangKantor = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [20,34,35])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiReimbursementPenunjangKantor = count($RevisiReimbursementPenunjangKantor); 

        $TolakReimbursementPenunjangKantor  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11,22,9])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakReimbursementPenunjangKantor = count($TolakReimbursementPenunjangKantor ); 
  
        $totalReimbursementOverall = $totalReimbursementMedical + $totalReimbursementPerjalananBisnis + $totalReimbursementPenunjangKantor;

        $percentageMedical = ($totalReimbursementOverall != 0) ? round(($totalReimbursementMedical / $totalReimbursementOverall) * 100, 2) : 0;
        $percentagePerjalananBisnis = ($totalReimbursementOverall != 0) ? round(($totalReimbursementPerjalananBisnis / $totalReimbursementOverall) * 100, 2) : 0;
        $percentagePenunjangKantor = ($totalReimbursementOverall != 0) ? round(($totalReimbursementPenunjangKantor / $totalReimbursementOverall) * 100, 2) : 0;

    
        //BAR CHART 
        $totalReimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->count();
    
        $totalReimbursementMonth = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
            ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
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
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
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
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
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
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
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
        $MenungguKDreimbursement = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1, 28])
            ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
            ->orderBy('id_reimbursement', 'asc')
            ->get();
        $totalMenungguKDReimbursement = count($MenungguKDreimbursement); 

        $SetujuKDreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10,21])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuKDReimbursement = count($SetujuKDreimbursement); 

        $RevisiKDreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [20,34])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiKDReimbursement = count($RevisiKDreimbursement); 

        $TolakKDreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11,22])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakKDReimbursement = count($TolakKDreimbursement); 

        $totalKDReimbursement=$totalMenungguKDReimbursement+ $totalSetujuKDReimbursement+$totalRevisiKDReimbursement+$totalTolakKDReimbursement;
        
        $percentageMenungguKD = ($totalKDReimbursement != 0) ? round(($totalMenungguKDReimbursement / $totalKDReimbursement) * 100, 2) : 0;
        $percentageSetujuKD = ($totalKDReimbursement != 0) ? round(($totalSetujuKDReimbursement / $totalKDReimbursement) * 100, 2) : 0;
        $percentageRevisiKD = ($totalKDReimbursement != 0) ? round(($totalRevisiKDReimbursement / $totalKDReimbursement) * 100, 2) : 0;
        $percentageTolakKD = ($totalKDReimbursement != 0) ? round(($totalTolakKDReimbursement / $totalKDReimbursement) * 100, 2) : 0;
        
        //PROGRESS BAR Manajer Keuangan
        $MenungguMKreimbursement = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10,21])
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
            ->orderBy('id_reimbursement', 'asc')
            ->get();
        $totalMenungguMKReimbursement = count($MenungguMKreimbursement); 

        $SetujuMKreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [8])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuMKReimbursement = count($SetujuMKreimbursement); 

        $RevisiMKreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [35])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiMKReimbursement = count($RevisiMKreimbursement); 

        $TolakMKreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [9])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakMKReimbursement = count($TolakMKreimbursement); 

        $SelesaiMKreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [26,17])
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_sekarang)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSelesaiMKReimbursement = count($SelesaiMKreimbursement); 

        $totalMKReimbursement=$totalMenungguMKReimbursement+ $totalSetujuMKReimbursement+$totalRevisiMKReimbursement+$totalTolakMKReimbursement+$totalSelesaiMKReimbursement;
        
        $percentageMenungguMK = ($totalMKReimbursement != 0) ? round(($totalMenungguMKReimbursement / $totalMKReimbursement) * 100, 2) : 0;
        $percentageSetujuMK = ($totalMKReimbursement != 0) ? round(($totalSetujuMKReimbursement / $totalMKReimbursement) * 100, 2) : 0;
        $percentageRevisiMK = ($totalMKReimbursement != 0) ? round(($totalRevisiMKReimbursement / $totalMKReimbursement) * 100, 2) : 0;
        $percentageTolakMK = ($totalMKReimbursement != 0) ? round(($totalTolakMKReimbursement / $totalMKReimbursement) * 100, 2) : 0;
        $percentageSelesaiMK = ($totalMKReimbursement != 0) ? round(($totalSelesaiMKReimbursement / $totalMKReimbursement) * 100, 2) : 0;
        
        
        return view('superadmin.dashboard.index', compact(
        'tahun_sekarang',
        'totalReimbursementMedical',
        'totalMenungguReimbursementMedical',
        'totalSetujuReimbursementMedical',
        'totalRevisiReimbursementMedical',
        'totalTolakReimbursementMedical',
        'totalReimbursementPerjalananBisnis',
        'totalMenungguReimbursementPerjalananBisnis',
        'totalSetujuReimbursementPerjalananBisnis',
        'totalRevisiReimbursementPerjalananBisnis',
        'totalTolakReimbursementPerjalananBisnis',
        'totalReimbursementPenunjangKantor',
        'totalMenungguReimbursementPenunjangKantor',
        'totalSetujuReimbursementPenunjangKantor',
        'totalRevisiReimbursementPenunjangKantor',
        'totalTolakReimbursementPenunjangKantor',
        'totalReimbursement',
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
        'percentageMedical', 
        'percentagePerjalananBisnis', 
        'percentagePenunjangKantor',
        'percentageMenungguKD',
        'percentageSetujuKD',
        'percentageRevisiKD',
        'percentageTolakKD',
        'percentageMenungguMK',
        'percentageSetujuMK',
        'percentageRevisiMK',
        'percentageTolakMK',
        'percentageSelesaiMK'
    
    ));
    }


    public function exportExcel(){

        $currentYear = date('Y');
        $uniqueNumber = time();
        $fileName = 'Data Reimbursement_' .$currentYear . '_' .  $uniqueNumber . '.xlsx';
        
        return Excel::download(new ReimbursementExport, $fileName);
    }
    
}