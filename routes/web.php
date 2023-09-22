<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsStaffKeuangan;



// use App\Http\Controllers\DashboardController;

// SUPER ADMIN
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\ProfileController;
use App\Http\Controllers\SuperAdmin\KaryawanController;
use App\Http\Controllers\SuperAdmin\DivisiController;
use App\Http\Controllers\SuperAdmin\StrataController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\SupplierController;
use App\Http\Controllers\SuperAdmin\ProyekController;
use App\Http\Controllers\SuperAdmin\StatusPengajuanController;
use App\Http\Controllers\SuperAdmin\LampiranController;
use App\Http\Controllers\SuperAdmin\ReimbursementController;
use App\Http\Controllers\SuperAdmin\JenisReimbursementController;
use App\Http\Controllers\SuperAdmin\MedicalController;
use App\Http\Controllers\SuperAdmin\PerjalananBisnisController;
use App\Http\Controllers\SuperAdmin\PenunjangKantorController;

// KARYAWAN
use App\Http\Controllers\Karyawan\ProfileKaryawanController;
use App\Http\Controllers\Karyawan\DashboardKaryawanController;
use App\Http\Controllers\Karyawan\ReimbursementKaryawanController;
use App\Http\Controllers\Karyawan\MedicalKaryawanController;
use App\Http\Controllers\Karyawan\PenunjangKantorKaryawanController;
use App\Http\Controllers\Karyawan\PerjalananBisnisKaryawanController;

//Kepala Divisi 
use App\Http\Controllers\KepalaDivisi\ProfileKDController;
use App\Http\Controllers\KepalaDivisi\DashboardKDController;
use App\Http\Controllers\KepalaDivisi\ReimbursementKDController;
use App\Http\Controllers\KepalaDivisi\VerifikasiKDController;

use App\Http\Controllers\KepalaDivisi\MenungguVerifikasiKDController;
use App\Http\Controllers\KepalaDivisi\SetujuVerifikasiKDController;
use App\Http\Controllers\KepalaDivisi\RevisiVerifikasiKDController;
use App\Http\Controllers\KepalaDivisi\TolakVerifikasiKDController;

use App\Http\Controllers\KepalaDivisi\MedicalVerifikasiKDController;
use App\Http\Controllers\KepalaDivisi\PenunjangKantorVerifikasiKDController;
use App\Http\Controllers\KepalaDivisi\PerjalananBisnisVerifikasiKDController;


//Manajer Keuangan

use App\Http\Controllers\ManajerKeuangan\ProfileMKController;
use App\Http\Controllers\ManajerKeuangan\DashboardMKController;
use App\Http\Controllers\ManajerKeuangan\ReimbursementMKController;
use App\Http\Controllers\ManajerKeuangan\VerifikasiMKController;

use App\Http\Controllers\ManajerKeuangan\MenungguVerifikasiMKController;
use App\Http\Controllers\ManajerKeuangan\SetujuVerifikasiMKController;
use App\Http\Controllers\ManajerKeuangan\RevisiVerifikasiMKController;
use App\Http\Controllers\ManajerKeuangan\TolakVerifikasiMKController;
use App\Http\Controllers\ManajerKeuangan\SelesaiReimbursementMKController;

use App\Http\Controllers\ManajerKeuangan\MedicalVerifikasiMKController;
use App\Http\Controllers\ManajerKeuangan\PenunjangKantorVerifikasiMKController;
use App\Http\Controllers\ManajerKeuangan\PerjalananBisnisVerifikasiMKController;



//Staff Keuangan
use App\Http\Controllers\StaffKeuangan\ProfileSKController;
use App\Http\Controllers\StaffKeuangan\DashboardSKController;
use App\Http\Controllers\StaffKeuangan\VerifikasiSKController;

use App\Http\Controllers\StaffKeuangan\SudahTerbayarSKController;
use App\Http\Controllers\StaffKeuangan\BelumTerbayarSKController;
use App\Http\Controllers\StaffKeuangan\SelesaiReimbursementSKController;

use App\Http\Controllers\StaffKeuangan\MedicalVerifikasiSKController;
use App\Http\Controllers\StaffKeuangan\PenunjangKantorVerifikasiSKController;
use App\Http\Controllers\StaffKeuangan\PerjalananBisnisVerifikasiSKController;


// use App\Http\Controllers\ManajerKeuangan\SupplierMKController;
// use App\Http\Controllers\ManajerKeuangan\LampiranMKController;

// use App\Http\Controllers\KepalaDivisi\SupplierKDController;
// use App\Http\Controllers\KepalaDivisi\LampiranKDController;

// use App\Http\Controllers\Karyawan\SupplierKController;
// use App\Http\Controllers\Karyawan\LampiranKController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::group(['middleware' => ['role:Super Admin,Kepala Divisi,Manajer Keuangan,Karyawan']], function () {
//     // Rute yang dilindungi oleh middleware
//     Route::get('/superadmin/reimbursement', [ReimbursementController::class, 'index'])->name('reimbursement.index');
// })->middleware('auth');




// Route untuk menampilkan Dashbord
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('blog');
});

Route::get('/contact-us', function () {
    return view('contactUs');
});







// Route untuk menampilkan form login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route untuk proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Route untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');



    


Route::middleware(['auth', 'IsSuperAdmin'])->group(function () {
    //RESOURCE SUPER ADMIN
    // Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
   
    Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/superadmin/export-excel', [DashboardController::class, 'exportExcel'])->name('superadmin.exportExcel');
    
    Route::get('/superadmin/profile', [ProfileController::class, 'index'])->name('superadmin.profile');
    Route::put('/superadmin/profile/updateFotoProfile/{id_user}', [ProfileController::class, 'updateFotoProfile'])->name('superadmin.profile.updateFotoProfile');
    Route::put('/superadmin/profile/updateKelolaPengguna/{id_user}', [ProfileController::class, 'updateKelolaPengguna'])->name('superadmin.profile.updateKelolaPengguna');
    Route::put('/superadmin/profile/updateKelolaAkun/{id_user}', [ProfileController::class, 'updateKelolaAkun'])->name('superadmin.profile.updateKelolaAkun');
    Route::put('/superadmin/profile/update/{id_user}', [ProfileController::class, 'update'])->name('superadmin.profile.update');

    Route::resource('superadmin/karyawan', KaryawanController::class);
    Route::resource('superadmin/divisi', DivisiController::class);
    Route::resource('superadmin/strata', StrataController::class);
    Route::resource('superadmin/role', RoleController::class);
    Route::resource('superadmin/supplier', SupplierController::class);
    Route::resource('superadmin/proyek', ProyekController::class);
    Route::resource('superadmin/status-pengajuan', StatusPengajuanController::class);
    Route::resource('superadmin/jenisreimbursement', JenisReimbursementController::class);
    Route::resource('superadmin/lampiran', LampiranController::class);

    Route::get('/superadmin/reimbursement', [ReimbursementController::class, 'index'])->name('reimbursement.index');
    Route::get('/superadmin/reimbursement/create', [ReimbursementController::class, 'create'])->name('reimbursement.create');
    Route::post('/superadmin/reimbursement/store', [ReimbursementController::class, 'store'])->name('reimbursement.store');

    Route::get('/superadmin/medical/', [MedicalController::class, 'index'])->name('medical.index');
    Route::get('/superadmin/medical-export-excel', [MedicalController::class, 'exportExcel'])->name('medical.exportExcel');
    
    Route::get('superadmin/medical/show/{id_reimbursement}', [MedicalController::class, 'show'])->name('medical.show');
    Route::get('superadmin/medical/showVerifikasi/{id_reimbursement}', [MedicalController::class, 'showVerifikasi'])->name('medical.showVerifikasi');
    Route::get('superadmin/medical/edit/{id_reimbursement}', [MedicalController::class, 'edit'])->name('medical.edit');
    Route::put('superadmin/medical/update/{id_reimbursement}', [MedicalController::class, 'update'])->name('medical.update');
    Route::delete('superadmin/medical/delete/{id_reimbursement}', [MedicalController::class, 'destroy'])->name('medical.destroy');
    Route::delete('/hapus-lampiran-medical', [MedicalController::class, 'hapusLampiran'])->name('lampiran.hapus-medical');

    Route::get('superadmin/perjalanan-bisnis/', [PerjalananBisnisController::class, 'index'])->name('perjalanan-bisnis.index');
    Route::get('/superadmin/perjalanan-bisnis-export-excel', [PerjalananBisnisController::class, 'exportExcel'])->name('perjalanan-bisnis.exportExcel');
    Route::get('superadmin/perjalanan-bisnis/showVerifikasi/{id_reimbursement}', [PerjalananBisnisController::class, 'showVerifikasi'])->name('perjalanan-bisnis.showVerifikasi');
    Route::get('superadmin/perjalanan-bisnis/show/{id_reimbursement}', [PerjalananBisnisController::class, 'show'])->name('perjalanan-bisnis.show');
    Route::get('superadmin/perjalanan-bisnis/edit/{id_reimbursement}', [PerjalananBisnisController::class, 'edit'])->name('perjalanan-bisnis.edit');
    Route::put('superadmin/perjalanan-bisnis/update/{id_reimbursement}', [PerjalananBisnisController::class, 'update'])->name('perjalanan-bisnis.update');
    Route::delete('superadmin/perjalanan-bisnis/delete/{id_reimbursement}', [PerjalananBisnisController::class, 'destroy'])->name('perjalanan-bisnis.destroy');
    Route::delete('/hapus-lampiran-perjalanan-bisnis', [PerjalananBisnisController::class, 'hapusLampiran'])->name('lampiran.hapus-perjalanan-bisnis');

    Route::get('superadmin/penunjang-kantor/', [PenunjangKantorController::class, 'index'])->name('penunjang-kantor.index');
    Route::get('/superadmin/penunjang-kantor-export-excel', [PenunjangKantorController::class, 'exportExcel'])->name('penunjang-kantor.exportExcel');
    
    Route::get('superadmin/penunjang-kantor/show/{id_reimbursement}', [PenunjangKantorController::class, 'show'])->name('penunjang-kantor.show');
    Route::get('superadmin/penunjang-kantor/edit/{id_reimbursement}', [PenunjangKantorController::class, 'edit'])->name('penunjang-kantor.edit');
    Route::get('superadmin/penunjang-kantor/showVerifikasi/{id_reimbursement}', [PenunjangKantorController::class, 'showVerifikasi'])->name('penunjang-kantor.showVerifikasi');
    Route::put('superadmin/penunjang-kantor/update/{id_reimbursement}', [PenunjangKantorController::class, 'update'])->name('penunjang-kantor.update');
    Route::delete('superadmin/penunjang-kantor/delete/{id_reimbursement}', [PenunjangKantorController::class, 'destroy'])->name('penunjang-kantor.destroy');
    Route::delete('/hapus-lampiran-penunjang-kantor', [PenunjangKantorController::class, 'hapusLampiran'])->name('lampiran.hapus-penunjang-kantor');

});




Route::middleware(['auth', 'IsKaryawan'])->group(function () {
    // //RESOURCE KARYAWAN 
    Route::get('/karyawan/dashboard', [DashboardKaryawanController::class, 'index'])->name('karyawan.dashboard');
    Route::put('karyawan/dashboard/updateStatus/{id_reimbursement}', [DashboardKaryawanController::class, 'updateStatus'])->name('kdashboard.updateStatus');
    Route::get('/karyawan/export-excel', [DashboardKaryawanController::class, 'exportExcel'])->name('karyawan.exportExcel');

    Route::get('/karyawan/profile', [ProfileKaryawanController::class, 'index'])->name('karyawan.profile');
    Route::put('/karyawan/profile/updateFotoProfile/{id_user}', [ProfileKaryawanController::class, 'updateFotoProfile'])->name('karyawan.profile.updateFotoProfile');
    Route::put('/karyawan/profile/updateKelolaPengguna/{id_user}', [ProfileKaryawanController::class, 'updateKelolaPengguna'])->name('karyawan.profile.updateKelolaPengguna');
    Route::put('/karyawan/profile/updateKelolaAkun/{id_user}', [ProfileKaryawanController::class, 'updateKelolaAkun'])->name('karyawan.profile.updateKelolaAkun');
    Route::put('/karyawan/profile/update/{id_user}', [ProfileKaryawanController::class, 'update'])->name('karyawan.profile.update');



    
    Route::get('/karyawan/reimbursement', [ReimbursementKaryawanController::class, 'index'])->name('kreimbursement.index');
    Route::get('/karyawan/reimbursement/create', [ReimbursementKaryawanController::class, 'create'])->name('kreimbursement.create');
    Route::post('/karyawan/reimbursement/store', [ReimbursementKaryawanController::class, 'store'])->name('kreimbursement.store');

    Route::get('karyawan/medical/', [MedicalKaryawanController::class, 'index'])->name('kmedical.index');
    Route::get('karyawan/medical/showVerifikasi/{id_reimbursement}', [MedicalKaryawanController::class, 'showVerifikasi'])->name('kmedical.showVerifikasi');
    Route::get('/karyawan/medical-export-excel', [MedicalKaryawanController::class, 'exportExcel'])->name('kmedical.exportExcel');
    Route::get('/karyawan/medical-export-excel-sort', [MedicalKaryawanController::class, 'exportExcelSort'])->name('kmedical.exportExcelSort');
    Route::get('karyawan/medical/show/{id_reimbursement}', [MedicalKaryawanController::class, 'show'])->name('kmedical.show');
    Route::get('karyawan/medical/edit/{id_reimbursement}', [MedicalKaryawanController::class, 'edit'])->name('kmedical.edit');
    Route::put('karyawan/medical/update/{id_reimbursement}', [MedicalKaryawanController::class, 'update'])->name('kmedical.update');
    Route::delete('karyawan/medical/delete/{id_reimbursement}', [MedicalKaryawanController::class, 'destroy'])->name('kmedical.destroy');
    Route::put('karyawan/medical/updateStatus/{id_reimbursement}', [MedicalKaryawanController::class, 'updateStatus'])->name('kmedical.updateStatus');
    Route::delete('/hapus-lampiran-kmedical', [MedicalKaryawanController::class, 'hapusLampiran'])->name('lampiran.hapus-kmedical');

    Route::get('karyawan/perjalanan-bisnis/', [PerjalananBisnisKaryawanController::class, 'index'])->name('kperjalanan-bisnis.index');
    Route::get('karyawan/perjalanan-bisnis/showVerifikasi/{id_reimbursement}', [PerjalananBisnisKaryawanController::class, 'showVerifikasi'])->name('kperjalanan-bisnis.showVerifikasi');
    Route::get('/karyawan/perjalanan-bisnis-export-excel', [PerjalananBisnisKaryawanController::class, 'exportExcel'])->name('kperjalanan-bisnis.exportExcel');
    Route::get('karyawan/perjalanan-bisnis/show/{id_reimbursement}', [PerjalananBisnisKaryawanController::class, 'show'])->name('kperjalanan-bisnis.show');
    Route::get('karyawan/perjalanan-bisnis/edit/{id_reimbursement}', [PerjalananBisnisKaryawanController::class, 'edit'])->name('kperjalanan-bisnis.edit');
    Route::put('karyawan/perjalanan-bisnis/update/{id_reimbursement}', [PerjalananBisnisKaryawanController::class, 'update'])->name('kperjalanan-bisnis.update');
    Route::delete('karyawan/perjalanan-bisnis/delete/{id_reimbursement}', [PerjalananBisnisKaryawanController::class, 'destroy'])->name('kperjalanan-bisnis.destroy');
    Route::put('karyawan/perjalanan-bisnis/updateStatus/{id_reimbursement}', [PerjalananBisnisKaryawanController::class, 'updateStatus'])->name('kperjalanan-bisnis.updateStatus');
    Route::delete('/hapus-lampiran-kperjalanan-bisnis', [PerjalananBisnisKaryawanController::class, 'hapusLampiran'])->name('lampiran.hapus-kperjalanan-bisnis');
    
    Route::get('karyawan/penunjang-kantor/', [PenunjangKantorKaryawanController::class, 'index'])->name('kpenunjang-kantor.index');
    Route::get('karyawan/penunjang-kantor/showVerifikasi/{id_reimbursement}', [PenunjangKantorKaryawanController::class, 'showVerifikasi'])->name('kpenunjang-kantor.showVerifikasi');
    Route::get('/karyawan/penunjang-kantor-export-excel', [PenunjangKantorKaryawanController::class, 'exportExcel'])->name('kpenunjang-kantor.exportExcel');
    Route::get('karyawan/penunjang-kantor/show/{id_reimbursement}', [PenunjangKantorKaryawanController::class, 'show'])->name('kpenunjang-kantor.show');
    Route::get('karyawan/penunjang-kantor/edit/{id_reimbursement}', [PenunjangKantorKaryawanController::class, 'edit'])->name('kpenunjang-kantor.edit');
    Route::put('karyawan/penunjang-kantor/update/{id_reimbursement}', [PenunjangKantorKaryawanController::class, 'update'])->name('kpenunjang-kantor.update');
    Route::delete('karyawan/penunjang-kantor/delete/{id_reimbursement}', [PenunjangKantorKaryawanController::class, 'destroy'])->name('kpenunjang-kantor.destroy');
    Route::put('karyawan/penunjang-kantor/updateStatus/{id_reimbursement}', [PenunjangKantorKaryawanController::class, 'updateStatus'])->name('kpenunjang-kantor.updateStatus');
    Route::delete('/hapus-lampiran-kpenunjang-kantor', [PerjalananBisnisKaryawanController::class, 'hapusLampiran'])->name('lampiran.hapus-kpenunjang-kantor');
    });
    



Route::middleware(['auth', 'IsKepalaDivisi'])->group(function () {
    // //RESOURCE KEPALA DIVISI
    Route::get('/kepala-divisi/dashboard', [DashboardKDController::class, 'index'])->name('kepaladivisi.dashboard');
    Route::get('/kepala-divisi/export-excel', [DashboardKDController::class, 'exportExcel'])->name('kepaladivisi.exportExcel');

    
    Route::get('/kepala-divisi/profile', [ProfileKDController::class, 'index'])->name('kd.profile');
    Route::put('/kepala-divisi/profile/updateFotoProfile/{id_user}', [ProfileKDController::class, 'updateFotoProfile'])->name('kd.profile.updateFotoProfile');
    Route::put('/kepala-divisi/profile/updateKelolaPengguna/{id_user}', [ProfileKDController::class, 'updateKelolaPengguna'])->name('kd.profile.updateKelolaPengguna');
    Route::put('/kepala-divisi/profile/updateKelolaAkun/{id_user}', [ProfileKDController::class, 'updateKelolaAkun'])->name('kd.profile.updateKelolaAkun');
    Route::put('/kepala-divisi/profile/update/{id_user}', [ProfileKDController::class, 'update'])->name('kd.profile.update');

    
    Route::get('/kepala-divisi/verifikasi/', [VerifikasiKDController::class, 'index'])->name('verifikasi-kd.index');
    Route::get('/kepala-divisi/verifikasi-export-excel', [VerifikasiKDController::class, 'exportExcel'])->name('verifikasi-kd.exportExcel');
    Route::get('/kepala-divisi/verifikasi/showVerifikasi/{id_reimbursement}', [VerifikasiKDController::class, 'showVerifikasi'])->name('verifikasi-kd.showVerifikasi');
    Route::get('/kepala-divisi/verifikasi/show/{id_reimbursement}', [VerifikasiKDController::class, 'show'])->name('verifikasi-kd.show');
    Route::get('/kepala-divisi/verifikasi/edit/{id_reimbursement}', [VerifikasiKDController::class, 'edit'])->name('verifikasi-kd.edit');
    Route::put('/kepala-divisi/verifikasi/update/{id_reimbursement}', [VerifikasiKDController::class, 'update'])->name('verifikasi-kd.update');
    
    // Route::get('/kepala-divisi/menunggu-verifikasi/', [MenungguVerifikasiKDController::class, 'index'])->name('menunggu-verifikasi-kd.index');
    // Route::get('/kepala-divisi/menunggu-verifikasi-export-excel', [MenungguVerifikasiKDController::class, 'exportExcel'])->name('menunggu-verifikasi-kd.exportExcel');
    // Route::get('/kepala-divisi/menunggu-verifikasi/show/{id_reimbursement}', [MenungguVerifikasiKDController::class, 'show'])->name('menunggu-verifikasi-kd.show');
    // Route::get('/kepala-divisi/menunggu-verifikasi/edit/{id_reimbursement}', [MenungguVerifikasiKDController::class, 'edit'])->name('menunggu-verifikasi-kd.edit');
    // Route::put('/kepala-divisi/menunggu-verifikasi/update/{id_reimbursement}', [MenungguVerifikasiKDController::class, 'update'])->name('menunggu-verifikasi-kd.update');

    Route::get('/kepala-divisi/setuju-verifikasi/', [SetujuVerifikasiKDController::class, 'index'])->name('setuju-verifikasi-kd.index');
    Route::get('/kepala-divisi/setuju-verifikasi/showVerifikasi/{id_reimbursement}', [SetujuVerifikasiKDController::class, 'showVerifikasi'])->name('setuju-verifikasi-kd.showVerifikasi');
    Route::get('/kepala-divisi/setuju-verifikasi-export-excel', [SetujuVerifikasiKDController::class, 'exportExcel'])->name('setuju-verifikasi-kd.exportExcel');
    Route::get('/kepala-divisi/setuju-verifikasi/show/{id_reimbursement}', [SetujuVerifikasiKDController::class, 'show'])->name('setuju-verifikasi-kd.show');
    Route::get('/kepala-divisi/setuju-verifikasi/edit/{id_reimbursement}', [SetujuVerifikasiKDController::class, 'edit'])->name('setujU-verifikasi-kd.edit');
    Route::put('/kepala-divisi/setuju-verifikasi/update/{id_reimbursement}', [SetujuVerifikasiKDController::class, 'update'])->name('setuju-verifikasi-kd.update');

    Route::get('/kepala-divisi/revisi-verifikasi/', [RevisiVerifikasiKDController::class, 'index'])->name('revisi-verifikasi-kd.index');
    Route::get('/kepala-divisi/revisi-verifikasi/showVerifikasi/{id_reimbursement}', [RevisiVerifikasiKDController::class, 'showVerifikasi'])->name('revisi-verifikasi-kd.showVerifikasi');
    Route::get('/kepala-divisi/revisi-verifikasi-export-excel', [RevisiVerifikasiKDController::class, 'exportExcel'])->name('revisi-verifikasi-kd.exportExcel');
    Route::get('/kepala-divisi/revisi-verifikasi/show/{id_reimbursement}', [RevisiVerifikasiKDController::class, 'show'])->name('revisi-verifikasi-kd.show');
    Route::get('/kepala-divisi/revisi-verifikasi/edit/{id_reimbursement}', [RevisiVerifikasiKDController::class, 'edit'])->name('revisi-verifikasi-kd.edit');
    Route::put('/kepala-divisi/revisi-verifikasi/update/{id_reimbursement}', [RevisiVerifikasiKDController::class, 'update'])->name('revisi-verifikasi-kd.update');

    Route::get('/kepala-divisi/tolak-verifikasi/', [TolakVerifikasiKDController::class, 'index'])->name('tolak-verifikasi-kd.index');
    Route::get('/kepala-divisi/tolak-verifikasi/showVerifikasi/{id_reimbursement}', [TolakVerifikasiKDController::class, 'showVerifikasi'])->name('tolak-verifikasi-kd.showVerifikasi');
    Route::get('/kepala-divisi/tolak-verifikasi-export-excel', [TolakVerifikasiKDController::class, 'exportExcel'])->name('tolak-verifikasi-kd.exportExcel');
    Route::get('/kepala-divisi/tolak-verifikasi/show/{id_reimbursement}', [TolakVerifikasiKDController::class, 'show'])->name('tolak-verifikasi-kd.show');
    Route::get('/kepala-divisi/tolak-verifikasi/edit/{id_reimbursement}', [TolakVerifikasiKDController::class, 'edit'])->name('tolak-verifikasi-kd.edit');
    Route::put('/kepala-divisi/tolak-verifikasi/update/{id_reimbursement}', [TolakVerifikasiKDController::class, 'update'])->name('tolak-verifikasi-kd.update');

    Route::get('/kepala-divisi/medical-verifikasi/', [MedicalVerifikasiKDController::class, 'index'])->name('medical-verifikasi-kd.index');
    Route::get('/kepala-divisi/medical-verifikasi/showVerifikasi/{id_reimbursement}', [MedicalVerifikasiKDController::class, 'showVerifikasi'])->name('medical-verifikasi-kd.showVerifikasi');
    Route::get('/kepala-divisi/medical-export-excel', [MedicalVerifikasiKDController::class, 'exportExcel'])->name('medical-verifikasi-kd.exportExcel');
    Route::get('kepala-divisi/medical-verifikasi/show/{id_reimbursement}', [MedicalVerifikasiKDController::class, 'show'])->name('medical-verifikasi-kd.show');
    Route::get('kepala-divisi/medical-verifikasi/edit/{id_reimbursement}', [MedicalVerifikasiKDController::class, 'edit'])->name('medical-verifikasi-kd.edit');
    Route::put('kepala-divisi/medical-verifikasi/update/{id_reimbursement}', [MedicalVerifikasiKDController::class, 'update'])->name('medical-verifikasi-kd.update');
   
    Route::get('/kepala-divisi/perjalanan-bisnis-verifikasi/', [PerjalananBisnisVerifikasiKDController::class, 'index'])->name('perjalanan-bisnis-verifikasi-kd.index');
    Route::get('/kepala-divisi/perjalanan-bisnis-verifikasi/showVerifikasi/{id_reimbursement}', [PerjalananBisnisVerifikasiKDController::class, 'showVerifikasi'])->name('perjalanan-bisnis-verifikasi-kd.showVerifikasi');
    Route::get('/kepala-divisi/perjalanan-bisnis-export-excel', [PerjalananBisnisVerifikasiKDController::class, 'exportExcel'])->name('perjalanan-bisnis-verifikasi-kd.exportExcel');
    Route::get('/kepala-divisi/perjalanan-bisnis-verifikasi/show/{id_reimbursement}', [PerjalananBisnisVerifikasiKDController::class, 'show'])->name('perjalanan-bisnis-verifikasi-kd.show');
    Route::get('/kepala-divisi/perjalanan-bisnis-verifikasi/edit/{id_reimbursement}', [PerjalananBisnisVerifikasiKDController::class, 'edit'])->name('perjalanan-bisnis-verifikasi-kd.edit');
    Route::put('/kepala-divisi/perjalanan-bisnis-verifikasi/update/{id_reimbursement}', [PerjalananBisnisVerifikasiKDController::class, 'update'])->name('perjalanan-bisnis-verifikasi-kd.update');
  
    Route::get('/kepala-divisi/penunjang-kantor-verifikasi/', [PenunjangKantorVerifikasiKDController::class, 'index'])->name('penunjang-kantor-verifikasi-kd.index');
    Route::get('/kepala-divisi/penunjang-kantor-verifikasi/showVerifikasi/{id_reimbursement}', [PenunjangKantorVerifikasiKDController::class, 'showVerifikasi'])->name('penunjang-kantor-verifikasi-kd.showVerifikasi');
    Route::get('/kepala-divisi/penunjang-kantor-export-excel', [PenunjangKantorVerifikasiKDController::class, 'exportExcel'])->name('penunjang-kantor-verifikasi-kd.exportExcel');
    Route::get('/kepala-divisi/penunjang-kantor-verifikasi/show/{id_reimbursement}', [PenunjangKantorVerifikasiKDController::class, 'show'])->name('penunjang-kantor-verifikasi-kd.show');
    Route::get('/kepala-divisi/penunjang-kantor-verifikasi/edit/{id_reimbursement}', [PenunjangKantorVerifikasiKDController::class, 'edit'])->name('penunjang-kantor-verifikasi-kd.edit');
    Route::put('/kepala-divisi/penunjang-kantor-verifikasi/update/{id_reimbursement}', [PenunjangKantorVerifikasiKDController::class, 'update'])->name('penunjang-kantor-verifikasi-kd.update');
});




Route::middleware(['auth', 'IsManajerKeuangan'])->group(function () {
// //RESOURCE MANAGER KEUANGAN
    Route::get('/manajer-keuangan/dashboard', [DashboardMKController::class, 'index'])->name('manajerkeuangan.dashboard');
    Route::get('/manajer-keuangan/export-excel', [DashboardMKController::class, 'exportExcel'])->name('manajerkeuangan.exportExcel');

    Route::get('/manajer-keuangan/profile', [ProfileMKController::class, 'index'])->name('mk.profile');
    Route::put('/manajer-keunagan/profile/updateFotoProfile/{id_user}', [ProfileMKController::class, 'updateFotoProfile'])->name('mk.profile.updateFotoProfile');
    Route::put('/manajer-keunagan/profile/updateKelolaPengguna/{id_user}', [ProfileMKController::class, 'updateKelolaPengguna'])->name('mk.profile.updateKelolaPengguna');
    Route::put('/manajer-keunagan/profile/updateKelolaAkun/{id_user}', [ProfileMKController::class, 'updateKelolaAkun'])->name('mk.profile.updateKelolaAkun');
    Route::put('/manajer-keunagan/profile/update/{id_user}', [ProfileMKController::class, 'update'])->name('mk.profile.update');

    Route::get('/manajer-keuangan/verifikasi/', [VerifikasiMKController::class, 'index'])->name('verifikasi-mk.index');
    Route::get('/manajer-keuangan/verifikasi-export-excel', [VerifikasiMKController::class, 'exportExcel'])->name('verifikasi-mk.exportExcel');
    Route::get('/manajer-keuangan/verifikasi/show/{id_reimbursement}', [VerifikasiMKController::class, 'show'])->name('verifikasi-mk.show');
    Route::get('/manajer-keuangan/verifikasi/edit/{id_reimbursement}', [VerifikasiMKController::class, 'edit'])->name('verifikasi-mk.edit');
    Route::put('/manajer-keuangan/verifikasi/update/{id_reimbursement}', [VerifikasiMKController::class, 'update'])->name('verifikasi-mk.update');

    Route::get('/manajer-keuangan/menunggu-verifikasi/', [MenungguVerifikasiMKController::class, 'index'])->name('menunggu-verifikasi-mk.index');
    Route::get('/manajer-keuangan/menunggu-verifikasi-export-excel', [MenungguVerifikasiMKController::class, 'exportExcel'])->name('menunggu-verifikasi-mk.exportExcel');
    Route::get('/manajer-keuangan/menunggu-verifikasi/show/{id_reimbursement}', [MenungguVerifikasiMKController::class, 'show'])->name('menunggu-verifikasi-mk.show');
    Route::get('/manajer-keuangan/menunggu-verifikasi/edit/{id_reimbursement}', [MenungguVerifikasiMKController::class, 'edit'])->name('menunggu-verifikasi-mk.edit');
    Route::put('/manajer-keuangan/menunggu-verifikasi/update/{id_reimbursement}', [MenungguVerifikasiMKController::class, 'update'])->name('menunggu-verifikasi-mk.update');

    Route::get('/manajer-keuangan/setuju-verifikasi/', [SetujuVerifikasiMKController::class, 'index'])->name('setuju-verifikasi-mk.index');
    Route::get('/manajer-keuangan/setuju-verifikasi-export-excel', [SetujuVerifikasiMKController::class, 'exportExcel'])->name('setuju-verifikasi-mk.exportExcel');
    Route::get('/manajer-keuangan/setuju-verifikasi/show/{id_reimbursement}', [SetujuVerifikasiMKController::class, 'show'])->name('setuju-verifikasi-mk.show');
    Route::get('/manajer-keuangan/setuju-verifikasi/edit/{id_reimbursement}', [SetujuVerifikasiMKController::class, 'edit'])->name('setuju-verifikasi-mk.edit');
    Route::put('/manajer-keuangan/setuju-verifikasi/update/{id_reimbursement}', [SetujuVerifikasiMKController::class, 'update'])->name('setuju-verifikasi-mk.update');

    Route::get('/manajer-keuangan/revisi-verifikasi/', [RevisiVerifikasiMKController::class, 'index'])->name('revisi-verifikasi-mk.index');
    Route::get('/manajer-keuangan/revisi-verifikasi-export-excel', [RevisiVerifikasiMKController::class, 'exportExcel'])->name('revisi-verifikasi-mk.exportExcel');
    Route::get('/manajer-keuangan/revisi-verifikasi/show/{id_reimbursement}', [RevisiVerifikasiMKController::class, 'show'])->name('revisi-verifikasi-mk.show');
    Route::get('/manajer-keuangan/revisi-verifikasi/edit/{id_reimbursement}', [RevisiVerifikasiMKController::class, 'edit'])->name('revisi-verifikasi-mk.edit');
    Route::put('/manajer-keuangan/revisi-verifikasi/update/{id_reimbursement}', [RevisiVerifikasiMKController::class, 'update'])->name('revisi-verifikasi-mk.update');

    Route::get('/manajer-keuangan/tolak-verifikasi/', [TolakVerifikasiMKController::class, 'index'])->name('tolak-verifikasi-mk.index');
    Route::get('/manajer-keuangan/tolak-verifikasi-export-excel', [TolakVerifikasiMKController::class, 'exportExcel'])->name('tolak-verifikasi-mk.exportExcel');
    Route::get('/manajer-keuangan/tolak-verifikasi/show/{id_reimbursement}', [TolakVerifikasiMKController::class, 'show'])->name('tolak-verifikasi-mk.show');
    Route::get('/manajer-keuangan/tolak-verifikasi/edit/{id_reimbursement}', [TolakVerifikasiMKController::class, 'edit'])->name('tolak-verifikasi-mk.edit');
    Route::put('/manajer-keuangan/tolak-verifikasi/update/{id_reimbursement}', [TolakVerifikasiMKController::class, 'update'])->name('tolak-verifikasi-mk.update');

    Route::get('/manajer-keuangan/selesai-reimbursement/', [SelesaiReimbursementMKController::class, 'index'])->name('selesai-reimbursement-mk.index');
    Route::get('/manajer-keuangan/selesai-reimbursement-export-excel', [SelesaiReimbursementMKController::class, 'exportExcel'])->name('selesai-reimbursement-mk.exportExcel');
    Route::get('/manajer-keuangan/selesai-reimbursement/show/{id_reimbursement}', [SelesaiReimbursementMKController::class, 'show'])->name('selesai-reimbursement-mk.show');
    Route::get('/manajer-keuangan/selesai-reimbursement/edit/{id_reimbursement}', [SelesaiReimbursementMKController::class, 'edit'])->name('selesai-reimbursement-mk.edit');
    Route::put('/manajer-keuangan/selesai-reimbursement/update/{id_reimbursement}', [SelesaiReimbursementMKController::class, 'update'])->name('selesai-reimbursement-mk.update');

    Route::get('/manajer-keuangan/medical-verifikasi/', [MedicalVerifikasiMKController::class, 'index'])->name('medical-verifikasi-mk.index');
    Route::get('/manajer-keuangan/medical-export-excel', [MedicalVerifikasiMKController::class, 'exportExcel'])->name('medical-verifikasi-mk.exportExcel');
    Route::get('/manajer-keuangan/medical-verifikasi/show/{id_reimbursement}', [MedicalVerifikasiMKController::class, 'show'])->name('medical-verifikasi-mk.show');
    Route::get('/manajer-keuangan/medical-verifikasi/edit/{id_reimbursement}', [MedicalVerifikasiMKController::class, 'edit'])->name('medical-verifikasi-mk.edit');
    Route::put('/manajer-keuangan/medical-verifikasi/update/{id_reimbursement}', [MedicalVerifikasiMKController::class, 'update'])->name('medical-verifikasi-mk.update');
   
    Route::get('/manajer-keuangan/perjalanan-bisnis-verifikasi/', [PerjalananBisnisVerifikasiMKController::class, 'index'])->name('perjalanan-bisnis-verifikasi-mk.index');
    Route::get('/manajer-keuangan/perjalanan-bisnis-export-excel', [PerjalananBisnisVerifikasiMKController::class, 'exportExcel'])->name('perjalanan-bisnis-verifikasi-mk.exportExcel');
    Route::get('/manajer-keuangan/perjalanan-bisnis-verifikasi/show/{id_reimbursement}', [PerjalananBisnisVerifikasiMKController::class, 'show'])->name('perjalanan-bisnis-verifikasi-mk.show');
    Route::get('/manajer-keuangan/perjalanan-bisnis-verifikasi/edit/{id_reimbursement}', [PerjalananBisnisVerifikasiMKController::class, 'edit'])->name('perjalanan-bisnis-verifikasi-mk.edit');
    Route::put('/manajer-keuangan/perjalanan-bisnis-verifikasi/update/{id_reimbursement}', [PerjalananBisnisVerifikasiMKController::class, 'update'])->name('perjalanan-bisnis-verifikasi-mk.update');
  
    Route::get('/manajer-keuangan/penunjang-kantor-verifikasi/', [PenunjangKantorVerifikasiMKController::class, 'index'])->name('penunjang-kantor-verifikasi-mk.index');
    Route::get('/manajer-keuangan/penunjang-kantor-export-excel', [PenunjangKantorVerifikasiMKController::class, 'exportExcel'])->name('penunjang-kantor-verifikasi-mk.exportExcel');
    Route::get('/manajer-keuangan/penunjang-kantor-verifikasi/show/{id_reimbursement}', [PenunjangKantorVerifikasiMKController::class, 'show'])->name('penunjang-kantor-verifikasi-mk.show');
    Route::get('/manajer-keuangan/penunjang-kantor-verifikasi/edit/{id_reimbursement}', [PenunjangKantorVerifikasiMKController::class, 'edit'])->name('penunjang-kantor-verifikasi-mk.edit');
    Route::put('/manajer-keuangan/penunjang-kantor-verifikasi/update/{id_reimbursement}', [PenunjangKantorVerifikasiMKController::class, 'update'])->name('penunjang-kantor-verifikasi-mk.update');
  
// Route::resource('manajerkeuangan/lampiran', LampiranMKController::class);
// Route::resource('manajerkeuangan/supplier', SupplierMKController::class);
});





Route::middleware(['auth', 'IsStaffKeuangan'])->group(function () {
    // //RESOURCE STAFF KEUANGAN
        Route::get('/staff-keuangan/dashboard', [DashboardSKController::class, 'index'])->name('staffkeuangan.dashboard');
        Route::get('/staff-keuangan/export-excel', [DashboardSKController::class, 'exportExcel'])->name('staffkeuangan.exportExcel');
    
        Route::get('/staff-keuangan/profile', [ProfileSKController::class, 'index'])->name('sk.profile');
        Route::put('/staff-keuangan/profile/updateFotoProfile/{id_user}', [ProfileSKController::class, 'updateFotoProfile'])->name('sk.profile.updateFotoProfile');
        Route::put('/staff-keuangan/profile/updateKelolaPengguna/{id_user}', [ProfileSKController::class, 'updateKelolaPengguna'])->name('sk.profile.updateKelolaPengguna');
        Route::put('/staff-keuangan/profile/updateKelolaAkun/{id_user}', [ProfileSKController::class, 'updateKelolaAkun'])->name('sk.profile.updateKelolaAkun');
        Route::put('/staff-keuangan/profile/update/{id_user}', [ProfileSKController::class, 'update'])->name('sk.profile.update');
    
    
        Route::get('/staff-keuangan/verifikasi/', [VerifikasiSKController::class, 'index'])->name('verifikasi-sk.index');
        Route::get('/staff-keuangan/verifikasi-export-excel', [VerifikasiSKController::class, 'exportExcel'])->name('verifikasi-sk.exportExcel');
        Route::get('/staff-keuangan/verifikasi/show/{id_reimbursement}', [VerifikasiSKController::class, 'show'])->name('verifikasi-sk.show');
        Route::get('/staff-keuangan/verifikasi/edit/{id_reimbursement}', [VerifikasiSKController::class, 'edit'])->name('verifikasi-sk.edit');
        Route::put('/staff-keuangan/verifikasi/update/{id_reimbursement}', [VerifikasiSKController::class, 'update'])->name('verifikasi-sk.update');
    
        Route::get('/staff-keuangan/belum-terbayar/', [BelumTerbayarSKController::class, 'index'])->name('belum-terbayar-sk.index');
        Route::get('/staff-keuangan/belum-terbayar-export-excel', [BelumTerbayarSKController::class, 'exportExcel'])->name('belum-terbayar-sk.exportExcel');
        Route::get('/staff-keuangan/belum-terbayar/show/{id_reimbursement}', [BelumTerbayarSKController::class, 'show'])->name('belum-terbayar-sk.show');
        Route::get('/staff-keuangan/belum-terbayar/edit/{id_reimbursement}', [BelumTerbayarSKController::class, 'edit'])->name('belum-terbayar-sk.edit');
        Route::put('/staff-keuangan/belum-terbayar/update/{id_reimbursement}', [BelumTerbayarSKController::class, 'update'])->name('belum-terbayar-sk.update');
    
        Route::get('/staff-keuangan/sudah-terbayar/', [SudahTerbayarSKController::class, 'index'])->name('sudah-terbayar-sk.index');
        Route::get('/staff-keuangan/sudah-terbayar-export-excel', [SudahTerbayarSKController::class, 'exportExcel'])->name('sudah-terbayar-sk.exportExcel');
        Route::get('/staff-keuangan/sudah-terbayar/show/{id_reimbursement}', [SudahTerbayarSKController::class, 'show'])->name('sudah-terbayar-sk.show');
        Route::get('/staff-keuangan/sudah-terbayar/edit/{id_reimbursement}', [SudahTerbayarSKController::class, 'edit'])->name('sudah-terbayar-sk.edit');
        Route::put('/staff-keuangan/sudah-terbayar/update/{id_reimbursement}', [SudahTerbayarSKController::class, 'update'])->name('sudah-terbayar-sk.update');
    
        Route::get('/staff-keuangan/selesai-reimbursement/', [SelesaiReimbursementSKController::class, 'index'])->name('selesai-reimbursement-sk.index');
        Route::get('/staff-keuangan/selesai-reimbursement-export-excel', [SelesaiReimbursementSKController::class, 'exportExcel'])->name('selesai-reimbursement-sk.exportExcel');
        Route::get('/staff-keuangan/selesai-reimbursement/show/{id_reimbursement}', [SelesaiReimbursementSKController::class, 'show'])->name('selesai-reimbursement-sk.show');
        Route::get('/staff-keuangan/selesai-reimbursement/edit/{id_reimbursement}', [SelesaiReimbursementSKController::class, 'edit'])->name('selesai-reimbursement-sk.edit');
        Route::put('/staff-keuangan/selesai-reimbursement/update/{id_reimbursement}', [SelesaiReimbursementSKController::class, 'update'])->name('selesai-reimbursement-sk.update');
        
        Route::get('/staff-keuangan/medical-verifikasi/', [MedicalVerifikasiSKController::class, 'index'])->name('medical-verifikasi-sk.index');
        Route::get('/staff-keuangan/medical-export-excel', [MedicalVerifikasiSKController::class, 'exportExcel'])->name('medical-verifikasi-sk.exportExcel');
        Route::get('/staff-keuangan/medical-verifikasi/show/{id_reimbursement}', [MedicalVerifikasiSKController::class, 'show'])->name('medical-verifikasi-sk.show');
        Route::get('/staff-keuangan/medical-verifikasi/edit/{id_reimbursement}', [MedicalVerifikasiSKController::class, 'edit'])->name('medical-verifikasi-sk.edit');
        Route::put('/staff-keuangan/medical-verifikasi/update/{id_reimbursement}', [MedicalVerifikasiSKController::class, 'update'])->name('medical-verifikasi-sk.update');
       
        Route::get('/staff-keuangan/perjalanan-bisnis-verifikasi/', [PerjalananBisnisVerifikasiSKController::class, 'index'])->name('perjalanan-bisnis-verifikasi-sk.index');
        Route::get('/staff-keuangan/perjalanan-bisnis-export-excel', [PerjalananBisnisVerifikasiSKController::class, 'exportExcel'])->name('perjalanan-bisnis-verifikasi-sk.exportExcel');
        Route::get('/staff-keuangan/perjalanan-bisnis-verifikasi/show/{id_reimbursement}', [PerjalananBisnisVerifikasiSKController::class, 'show'])->name('perjalanan-bisnis-verifikasi-sk.show');
        Route::get('/staff-keuangan/perjalanan-bisnis-verifikasi/edit/{id_reimbursement}', [PerjalananBisnisVerifikasiSKController::class, 'edit'])->name('perjalanan-bisnis-verifikasi-sk.edit');
        Route::put('/staff-keuangan/perjalanan-bisnis-verifikasi/update/{id_reimbursement}', [PerjalananBisnisVerifikasiSKController::class, 'update'])->name('perjalanan-bisnis-verifikasi-sk.update');
      
        Route::get('/staff-keuangan/penunjang-kantor-verifikasi/', [PenunjangKantorVerifikasiSKController::class, 'index'])->name('penunjang-kantor-verifikasi-sk.index');
        Route::get('/staff-keuangan/penunjang-kantor-export-excel', [PenunjangKantorVerifikasiSKController::class, 'exportExcel'])->name('penunjang-kantor-verifikasi-sk.exportExcel');
        Route::get('/staff-keuangan/penunjang-kantor-verifikasi/show/{id_reimbursement}', [PenunjangKantorVerifikasiSKController::class, 'show'])->name('penunjang-kantor-verifikasi-sk.show');
        Route::get('/staff-keuangan/penunjang-kantor-verifikasi/edit/{id_reimbursement}', [PenunjangKantorVerifikasiSKController::class, 'edit'])->name('penunjang-kantor-verifikasi-sk.edit');
        Route::put('/staff-keuangan/penunjang-kantor-verifikasi/update/{id_reimbursement}', [PenunjangKantorVerifikasiSKController::class, 'update'])->name('penunjang-kantor-verifikasi-sk.update');
      
    });