<?php

namespace App\Http\Controllers\KepalaDivisi;

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
use App\Exports\ReimbursementKDExport;


class DashboardKDController extends Controller
{

    public function index(Request $request)
    {
        $loggedInUserId = Auth::id();
        $tahun_sekarang = date('Y');
        $tahun_terpilih = $request->input('tahun', $tahun_sekarang);
        $tahun_options = [];
        for ($i = 0; $i < 5; $i++) {
            $tahun_options[] = $tahun_sekarang - $i;
        }
        $reimbursements = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_divisi', 'users.id_divisi', '=', 'tb_divisi.id_divisi') // Menambahkan join dengan tabel tb_divisi
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->select(
            'tb_reimbursement.*', // Menambahkan kolom-kolom dari tabel tb_reimbursement
            'users.nama_karyawan', // Menambahkan kolom nama_karyawan dari tabel users
            'tb_divisi.nama_divisi', // Menambahkan kolom nama_divisi dari tabel tb_divisi
            'tb_jenis_reimbursement.nama_jenis_reimbursement' ,// Menambahkan kolom nama_divisi dari tabel tb_divisi
            'tb_status_pengajuan.nama_status_pengajuan' // Menambahkan kolom nama_divisi dari tabel tb_divisi
        )
        ->orderBy('tanggal_reimbursement', 'asc')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_reimbursement.id_status_pengajuan', [28,34])
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->get();



      
    

        $allowedStatus = DB::table('tb_status_pengajuan')
        ->where('id_status_pengajuan', '=', 8)
        ->get();

        
        $totalReimbursementMedical = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
                    $query->select('id_divisi')
                    ->from('users')
                    ->where('id_user', $loggedInUserId);
                    })
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 1)
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('tb_reimbursement.id_reimbursement', 'asc')
            ->count();

        $totalReimbursementPerjalananBisnis = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
                $query->select('id_divisi')
                    ->from('users')
                    ->where('id_user', $loggedInUserId);
            })
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 2)
            // ->whereNotIn('tb_status_pengajuan.id_status_pengajuan', [8,9,35,26])
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->count();

        $totalReimbursementPenunjangKantor = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
                $query->select('id_divisi')
                    ->from('users')
                    ->where('id_user', $loggedInUserId);
            })
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
            // ->whereNotIn('tb_status_pengajuan.id_status_pengajuan', [8,9,35,26])
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->count();
        
            $totalReimbursementOverall = $totalReimbursementMedical + $totalReimbursementPerjalananBisnis + $totalReimbursementPenunjangKantor;

            $percentageMedical = ($totalReimbursementOverall != 0) ? round(($totalReimbursementMedical / $totalReimbursementOverall) * 100, 2) : 0;
            $percentagePerjalananBisnis = ($totalReimbursementOverall != 0) ? round(($totalReimbursementPerjalananBisnis / $totalReimbursementOverall) * 100, 2) : 0;
            $percentagePenunjangKantor = ($totalReimbursementOverall != 0) ? round(($totalReimbursementPenunjangKantor / $totalReimbursementOverall) * 100, 2) : 0;
        

            //RINCIAN MEDICAL 
    
        $MenungguReimbursementMedical1 = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
                $query->select('id_divisi')
                    ->from('users')
                    ->where('id_user', $loggedInUserId);
            })
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [28])
            ->where('tb_reimbursement.id_jenis_reimbursement', 1)
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->count();

        $totalMenungguReimbursementMedical  = $MenungguReimbursementMedical1; 
        // $totalMenungguReimbursementMedical  = count($MenungguReimbursementMedical); 

        $SetujuReimbursementMedical1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10]) 
        // ->whereIn('tb_reimbursement.id_status_pengajuan_mk', [41]) 
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();
        $totalSetujuReimbursementMedical = $SetujuReimbursementMedical1; 
        // $totalSetujuReimbursementMedical = count($SetujuReimbursementMedical); 

        $RevisiReimbursementMedical1 = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [20,34])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();

      

        $totalRevisiReimbursementMedical = $RevisiReimbursementMedical1; 
        // $totalRevisiReimbursementMedical = count($RevisiReimbursementMedical); 

        $TolakReimbursementMedical1  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11])
        ->where('tb_reimbursement.id_jenis_reimbursement', 1)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->count();

        $totalTolakReimbursementMedical  = $TolakReimbursementMedical1 ; 
        // $totalTolakReimbursementMedical  = count($TolakReimbursementMedical ); 


        // RINCIAN PERJALANAN BISNISS

        $MenungguReimbursementPerjalananBisnis= DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1, 28])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalMenungguReimbursementPerjalananBisnis = count($MenungguReimbursementPerjalananBisnis); 

        $SetujuReimbursementPerjalananBisnis = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10,21]) 
        // ->whereIn('tb_reimbursement.id_status_pengajuan_mk', [41]) 
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuReimbursementPerjalananBisnis = count($SetujuReimbursementPerjalananBisnis); 

        $RevisiReimbursementPerjalananBisnis = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [34])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiReimbursementPerjalananBisnis = count($RevisiReimbursementPerjalananBisnis); 

        $TolakReimbursementPerjalananBisnis  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11])
        ->where('tb_reimbursement.id_jenis_reimbursement', 2)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakReimbursementPerjalananBisnis  = count($TolakReimbursementPerjalananBisnis ); 



        //RINCIAN PENUNJANG KANTOR
        
        $MenungguReimbursementPenunjangKantor= DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1, 28])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalMenungguReimbursementPenunjangKantor = count($MenungguReimbursementPenunjangKantor); 

        $SetujuReimbursementPenunjangKantor = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10,21]) //
        // ->whereIn('tb_reimbursement.id_status_pengajuan_mk', [41]) 
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuReimbursementPenunjangKantor = count($SetujuReimbursementPenunjangKantor); 

        $RevisiReimbursementPenunjangKantor = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [34])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiReimbursementPenunjangKantor = count($RevisiReimbursementPenunjangKantor); 

        $TolakReimbursementPenunjangKantor  = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11])
        ->where('tb_reimbursement.id_jenis_reimbursement', 4)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakReimbursementPenunjangKantor = count($TolakReimbursementPenunjangKantor );

        
      
        //BAR CHART 
        // $totalReimbursement = DB::table('tb_reimbursement')
        // ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        // ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        // ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        // ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
        //     $query->select('id_divisi')
        //           ->from('users')
        //           ->where('id_user', $loggedInUserId);
        // })
        // ->count();
    
        $totalReimbursementMonth = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
                $query->select('id_divisi')
                    ->from('users')
                    ->where('id_user', $loggedInUserId);
            })
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy('month')
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
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
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 1)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
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
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 2)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
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
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->select(DB::raw('MONTH(tanggal_reimbursement) as month'), DB::raw('COUNT(*) as total'))
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
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
            ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
                $query->select('id_divisi')
                    ->from('users')
                    ->where('id_user', $loggedInUserId);
            })
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
            ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
            ->where('users.status_active', '=', 1) //aktif
            ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
            ->whereIn('tb_status_pengajuan.id_status_pengajuan', [1, 28])
            ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
            ->orderBy('id_reimbursement', 'asc')
            ->get();
        $totalMenungguKDReimbursement = count($MenungguKDreimbursement); 

        $SetujuKDreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [10,21])
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalSetujuKDReimbursement = count($SetujuKDreimbursement); 

        $RevisiKDreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [20,34])
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalRevisiKDReimbursement = count($RevisiKDreimbursement); 

        $TolakKDreimbursement = DB::table('tb_reimbursement')
        ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
        ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
        ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
        ->where('users.id_divisi', '=', function($query) use ($loggedInUserId) {
            $query->select('id_divisi')
                ->from('users')
                ->where('id_user', $loggedInUserId);
        })
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
        ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
        ->where('users.status_active', '=', 1) //aktif
        ->where('tb_status_pengajuan.status_active', '=', 1) //aktif
        ->whereIn('tb_status_pengajuan.id_status_pengajuan', [11,22])
        ->whereYear('tb_reimbursement.tanggal_reimbursement', '=', $tahun_terpilih)
        ->orderBy('id_reimbursement', 'asc')
        ->get();
        $totalTolakKDReimbursement = count($TolakKDreimbursement); 

        $totalKDReimbursement=$totalMenungguKDReimbursement+ $totalSetujuKDReimbursement+$totalRevisiKDReimbursement+$totalTolakKDReimbursement;
        
        $percentageMenungguKD = ($totalKDReimbursement != 0) ? round(($totalMenungguKDReimbursement / $totalKDReimbursement) * 100, 2) : 0;
        $percentageSetujuKD = ($totalKDReimbursement != 0) ? round(($totalSetujuKDReimbursement / $totalKDReimbursement) * 100, 2) : 0;
        $percentageRevisiKD = ($totalKDReimbursement != 0) ? round(($totalRevisiKDReimbursement / $totalKDReimbursement) * 100, 2) : 0;
        $percentageTolakKD = ($totalKDReimbursement != 0) ? round(($totalTolakKDReimbursement / $totalKDReimbursement) * 100, 2) : 0;
        
        
        
        return view('kepaladivisi.dashboard.index', compact(
        'tahun_terpilih',
        'tahun_options',
        'tahun_sekarang',
        'reimbursements',
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
        'totalReimbursementMedical',
        'totalReimbursementPerjalananBisnis',
        'totalReimbursementPenunjangKantor',
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
        'totalMenungguKDReimbursement',
        'totalSetujuKDReimbursement',
        'totalRevisiKDReimbursement',
        'totalTolakKDReimbursement',
        'percentageMedical', 
        'percentagePerjalananBisnis', 
        'percentagePenunjangKantor',
        'percentageMenungguKD',
        'percentageSetujuKD',
        'percentageRevisiKD',
        'percentageTolakKD'
    ));
    }

    // public function exportExcel()
    // {
    //     $currentYear = date('Y');
    //     $uniqueNumber = time();
    //     $fileName = 'Data Reimbursement_' .$currentYear . '_' .  $uniqueNumber . '.xlsx';
    
    //     return Excel::download(new ReimbursementKDExport, $fileName);
    // }
    

    public function exportExcel(Request $request)
    {

        $tahun_sekarang = date('Y');
        $tahun_terpilih = $request->input('tahun', $tahun_sekarang);
        $uniqueNumber = time();

        $fileName = 'Data Reimbursement_' .$tahun_terpilih . '_' .  $uniqueNumber . '.xlsx';
        
        return Excel::download(new ReimbursementKDExport($tahun_terpilih), $fileName);
    }
    
}