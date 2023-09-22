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

    public function index(Request $request)
    {
        $tahun_sekarang = date('Y');
        $tahun_terpilih = $request->input('tahun', $tahun_sekarang);
        $tahun_options = [];

        for ($i = 0; $i < 5; $i++) {
            $tahun_options[] = $tahun_sekarang - $i;
        }
          
        $totalReimbursementMedical = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_reimbursement.id_jenis_reimbursement', '=', 'tb_jenis_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_reimbursement.id_status_pengajuan', '=', 'tb_status_pengajuan.id_status_pengajuan')
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->count();

        $MenungguReimbursementMedical1 = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [28])
            ->where('tb_reimbursement.id_jenis_reimbursement', 1)
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->count();
           
        $MenungguReimbursementMedical2 = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [41])
            ->where('tb_reimbursement.id_jenis_reimbursement', 1)
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->count();
            //  dd( $MenungguReimbursementMedical1);
        
        $MenungguReimbursementMedical=$MenungguReimbursementMedical1+$MenungguReimbursementMedical2;
        $totalMenungguReimbursementMedical  = $MenungguReimbursementMedical; 

        $SetujuReimbursementMedical1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10]) //10,21
        ->where('tb_reimbursement.id_status_pengajuan_ky', '=',null)
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        // dd($SetujuReimbursementMedical1);
        $SetujuReimbursementMedical2 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [8]) //10,21
        ->where('tb_reimbursement.id_status_pengajuan_ky', '=',null)
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        // dd($SetujuReimbursementMedical2);
        $SetujuReimbursementMedical = $SetujuReimbursementMedical2;
        $totalSetujuReimbursementMedical = $SetujuReimbursementMedical; 
        

        $RevisiReimbursementMedical1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [34])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $RevisiReimbursementMedical2 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [35])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $RevisiReimbursementMedical =  $RevisiReimbursementMedical1 +  $RevisiReimbursementMedical2;
        $totalRevisiReimbursementMedical = $RevisiReimbursementMedical; 

        
        $TolakReimbursementMedical1  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $TolakReimbursementMedical2  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [9])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $TolakReimbursementMedical =  $TolakReimbursementMedical1 +  $TolakReimbursementMedical2 ;
        $totalTolakReimbursementMedical  = $TolakReimbursementMedical; 


        $SelesaiReimbursementMedical  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_ky')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [17])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSelesaiReimbursementMedical  = count($SelesaiReimbursementMedical ); 



        $totalReimbursementPerjalananBisnis = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->join('tb_lampiran', 'tb_lampiran.id_reimbursement', '=', 'tb_reimbursement.id_reimbursement')
        ->join('tb_proyek', 'tb_proyek.id_proyek', '=', 'tb_lampiran.id_proyek')
        ->select('users.nama_karyawan', 'users.status_active', 'tb_reimbursement.*', 'tb_status_pengajuan.nama_status_pengajuan')
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 2)
        ->where('users.hapus', '=', 0)
        ->where('tb_status_pengajuan.hapus', '=', 0)
        ->where('tb_reimbursement.hapus', '=', 0)
        ->where('tb_lampiran.hapus', '=', 0)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('tb_reimbursement.id_reimbursement', 'desc')
        ->orderBy('tb_reimbursement.updated_at', 'desc')
        ->distinct('tb_reimbursement.id_reimbursement')
        ->count();
        
       




        $MenungguReimbursementPerjalananBisnis1= DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [28])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();

        $MenungguReimbursementPerjalananBisnis2= DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [41])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $MenungguReimbursementPerjalananBisnis =  $MenungguReimbursementPerjalananBisnis1 +  $MenungguReimbursementPerjalananBisnis2;
        $totalMenungguReimbursementPerjalananBisnis = $MenungguReimbursementPerjalananBisnis; 

        $SetujuReimbursementPerjalananBisnis1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [8,10]) 
        ->where('tb_reimbursement.id_status_pengajuan_ky', '=',null)
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $SetujuReimbursementPerjalananBisnis2 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [8,10]) 
        ->where('tb_reimbursement.id_status_pengajuan_ky', '=',null)
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $SetujuReimbursementPerjalananBisnis = $SetujuReimbursementPerjalananBisnis2;
        $totalSetujuReimbursementPerjalananBisnis = $SetujuReimbursementPerjalananBisnis; 

        $RevisiReimbursementPerjalananBisnis1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [34])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $RevisiReimbursementPerjalananBisnis2 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [35])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
       $totalRevisiReimbursementPerjalananBisnis =  $RevisiReimbursementPerjalananBisnis1 +  $RevisiReimbursementPerjalananBisnis2;
        // $totalRevisiReimbursementPerjalananBisnis = count($RevisiReimbursementPerjalananBisnis); 

        $TolakReimbursementPerjalananBisnis1  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $TolakReimbursementPerjalananBisnis2  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [9])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $totalTolakReimbursementPerjalananBisnis  =  $TolakReimbursementPerjalananBisnis1 +  $TolakReimbursementPerjalananBisnis2 ; 
        // $totalTolakReimbursementPerjalananBisnis  = count($TolakReimbursementPerjalananBisnis ); 


        
        $SelesaiReimbursementPerjalananBisnis  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_ky')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [17])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSelesaiReimbursementPerjalananBisnis  = count($SelesaiReimbursementPerjalananBisnis ); 

        $totalReimbursementPenunjangKantor = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->join('tb_lampiran', 'tb_lampiran.id_reimbursement', '=', 'tb_reimbursement.id_reimbursement')
        ->join('tb_supplier', 'tb_supplier.id_supplier', '=', 'tb_lampiran.id_supplier')
        ->select('users.nama_karyawan', 'users.status_active','tb_reimbursement.*', 'tb_status_pengajuan.nama_status_pengajuan')
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('tb_lampiran.hapus', '=', 0)
        ->orderBy('tb_reimbursement.id_reimbursement', 'desc')
        ->orderBy('tb_reimbursement.updated_at', 'desc')
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->distinct('tb_reimbursement.id_reimbursement')
        ->count();


        
        $MenungguReimbursementPenunjangKantor1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [28])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $MenungguReimbursementPenunjangKantor2 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [41])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $totalMenungguReimbursementPenunjangKantor =  $MenungguReimbursementPenunjangKantor1 +  $MenungguReimbursementPenunjangKantor2; 
        
        // $totalMenungguReimbursementPenunjangKantor = count($MenungguReimbursementPenunjangKantor); 
 

        $SetujuReimbursementPenunjangKantor1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10]) //10,21
        ->where('tb_reimbursement.id_status_pengajuan_ky', '=',null)
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $SetujuReimbursementPenunjangKantor2 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [8]) //10,21
        ->where('tb_reimbursement.id_status_pengajuan_ky', '=',null)
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $totalSetujuReimbursementPenunjangKantor =  $SetujuReimbursementPenunjangKantor2 ;
        // $totalSetujuReimbursementPenunjangKantor = count($SetujuReimbursementPenunjangKantor); 

        $RevisiReimbursementPenunjangKantor1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [34])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $RevisiReimbursementPenunjangKantor2 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [35])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $totalRevisiReimbursementPenunjangKantor =  $RevisiReimbursementPenunjangKantor1  +  $RevisiReimbursementPenunjangKantor2 ;
        // $totalRevisiReimbursementPenunjangKantor = count($RevisiReimbursementPenunjangKantor); 

        $TolakReimbursementPenunjangKantor1  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $TolakReimbursementPenunjangKantor2  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [9])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $totalTolakReimbursementPenunjangKantor =  $TolakReimbursementPenunjangKantor1 +  $TolakReimbursementPenunjangKantor2 ;
        // $totalTolakReimbursementPenunjangKantor = count($TolakReimbursementPenunjangKantor ); 
  
        $SelesaiReimbursementPenunjangKantor = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_ky')
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [17])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSelesaiReimbursementPenunjangKantor = count($SelesaiReimbursementPenunjangKantor ); 
        
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
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->count();
    
        $totalReimbursementMonth = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 2)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
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
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
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
        $MenungguKDreimbursement = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1, 28])
            ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        'tahun_terpilih',
        'tahun_options',
        'tahun_sekarang',
        'totalReimbursementMedical',
        'totalMenungguReimbursementMedical',
        'totalSetujuReimbursementMedical',
        'totalRevisiReimbursementMedical',
        'totalTolakReimbursementMedical',
        'totalSelesaiReimbursementMedical',
        'totalReimbursementPerjalananBisnis',
        'totalMenungguReimbursementPerjalananBisnis',
        'totalSetujuReimbursementPerjalananBisnis',
        'totalRevisiReimbursementPerjalananBisnis',
        'totalTolakReimbursementPerjalananBisnis',
        'totalSelesaiReimbursementPerjalananBisnis',
        'totalReimbursementPenunjangKantor',
        'totalMenungguReimbursementPenunjangKantor',
        'totalSetujuReimbursementPenunjangKantor',
        'totalRevisiReimbursementPenunjangKantor',
        'totalTolakReimbursementPenunjangKantor',
        'totalSelesaiReimbursementPenunjangKantor',
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


    public function exportExcel(Request $request)
    {

        $tahun_sekarang = date('Y');
        $tahun_terpilih = $request->input('tahun', $tahun_sekarang);
        $uniqueNumber = time();

        $fileName = 'Data Reimbursement_' .$tahun_terpilih . '_' .  $uniqueNumber . '.xlsx';
        
        return Excel::download(new ReimbursementExport($tahun_terpilih), $fileName);
    }
    
}