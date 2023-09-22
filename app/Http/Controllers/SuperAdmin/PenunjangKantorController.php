<?php

namespace App\Http\Controllers\SuperAdmin;

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
use App\Exports\ReimbursementPenunjangKantorExport;
use Maatwebsite\Excel\Facades\Excel;


class PenunjangKantorController extends Controller
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
         ->join('tb_lampiran', 'tb_lampiran.id_reimbursement', '=', 'tb_reimbursement.id_reimbursement')
         ->join('tb_supplier', 'tb_supplier.id_supplier', '=', 'tb_lampiran.id_supplier')
         ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
         ->leftjoin('tb_status_pengajuan as sp_sk', 'sp_sk.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_sk')        
         ->leftjoin('tb_status_pengajuan as sp_mk', 'sp_mk.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_mk')        
         ->leftjoin('tb_status_pengajuan as sp_ky', 'sp_ky.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan_ky')   
         ->select('users.nama_karyawan', 'users.status_active', 'tb_reimbursement.*', 'tb_reimbursement.id_status_pengajuan_sk','tb_jenis_reimbursement.*', 'users.*', 'tb_status_pengajuan.nama_status_pengajuan', 'sp_mk.nama_status_pengajuan as nama_status_pengajuan_mk','sp_sk.nama_status_pengajuan as nama_status_pengajuan_sk', 'sp_ky.nama_status_pengajuan as nama_status_pengajuan_ky')     
         ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
         ->where('users.hapus', '=', 0) //tidak terhapus
         ->where('tb_status_pengajuan.hapus', '=', 0) //tidak terhapus
         ->where('tb_reimbursement.hapus', '=', 0) //tidak terhapus
         ->where('tb_lampiran.hapus', '=', 0)
         ->orderBy('tb_reimbursement.id_reimbursement', 'desc')
         ->orderBy('tb_reimbursement.updated_at', 'desc')
         ->distinct('tb_reimbursement.id_reimbursement');
            // Filter berdasarkan tahun
            if ($tahun_terpilih !== 'all') {
                $reimbursements->whereYear('tb_reimbursement.tanggal_reimbursement', $tahun_terpilih);
            }
            // Filter berdasarkan bulan
            if ($bulan_terpilih !== 'all') {
                $reimbursements->whereMonth('tb_reimbursement.tanggal_reimbursement', $bulan_terpilih);
            }
            $reimbursements = $reimbursements->get();
        
        $lampirans = DB::table('tb_lampiran')
            ->join('tb_supplier', 'tb_lampiran.id_supplier', '=', 'tb_supplier.id_supplier')
            ->get();

        $allowedUpdate = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
            ->where('users.status_active', '=', 1)
            ->where('tb_status_pengajuan.status_active', '=', 1)
            ->pluck('tb_reimbursement.id_user')
            ->toArray();

        return view('superadmin.penunjang-kantor.index', compact(
            'lampirans',
        'reimbursements',
        'allowedUpdate',
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
        ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
        ->where('tb_reimbursement.id_reimbursement', '=', $id_reimbursement)
        ->where('users.hapus', '=', 0) //tidak terhapus
        ->where('tb_status_pengajuan.hapus', '=', 0) //tidal terhapus
        ->first();
        
        $userVerifikasiKD = DB::table('users')
            ->where('id_user', $reimbursement->id_user_verifikasi)
            ->first();
            
        $userVerifikasiMK = DB::table('users')
            ->where('id_user', $reimbursement->id_user_verifikasi_mk)
            ->first();

        //Buat memunculkan Nama Proyek 
        $lamp = DB::table('tb_lampiran')
            ->join('tb_supplier', 'tb_lampiran.id_supplier', '=', 'tb_supplier.id_supplier')
            ->where('tb_lampiran.id_reimbursement', $id_reimbursement)
            ->select('tb_supplier.nama_supplier')
            ->distinct()
            ->first();
            // dd($lamp);

        //Data Lampiran ynag memiliki id_Reimbursement tersebut
        $lampirans = DB::table('tb_lampiran')
            ->where('id_reimbursement', '=', $id_reimbursement)
            ->where('hapus', 0) //aktif
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
        // dd($lamp);
        return view('superadmin.penunjang-kantor.show', compact('reimbursement','lamp', 'lampirans', 'lampiranCount','userVerifikasiKD' ,'userVerifikasiMK'));
    }


    
    public function showVerifikasi($id_reimbursement)
    {
        $reimbursement = DB::table('tb_reimbursement')
            ->join('users', 'tb_reimbursement.id_user', '=', 'users.id_user')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
            ->join('tb_status_pengajuan', 'tb_status_pengajuan.id_status_pengajuan', '=', 'tb_reimbursement.id_status_pengajuan')
            ->select('tb_reimbursement.*', 'users.nama_karyawan', 'tb_jenis_reimbursement.nama_jenis_reimbursement', 'tb_status_pengajuan.nama_status_pengajuan')
            ->where('tb_jenis_reimbursement.id_jenis_reimbursement', '=', 4)
            ->where('tb_reimbursement.id_reimbursement', '=', $id_reimbursement)
            ->where('users.hapus', '=', 0) //tidak terhapus
            ->where('tb_status_pengajuan.hapus', '=', 0) //tidal terhapus
            ->first();
    
        $userVerifikasiKD = DB::table('users')
            ->where('id_user', $reimbursement->id_user_verifikasi)
            ->first();
    
        $userVerifikasiMK = DB::table('users')
            ->where('id_user', $reimbursement->id_user_verifikasi_mk)
            ->first();
    
        return view('superadmin.penunjang-kantor.showVerifikasi', compact('reimbursement', 'userVerifikasiKD', 'userVerifikasiMK'));
    }
    

    public function edit($id_reimbursement)
    {
        $reimbursement = Reimbursement::findOrFail($id_reimbursement);
        $jenisReimbursement = JenisReimbursement::all();
   
        //mengambil user yang active 
        $user = User::where('status_active', 1)
            ->where('id_role', 4)
            ->where('hapus', 0) //aktif
            ->get();
        $supplier = Supplier::where('status_active', 1)  //aktif
            ->where('hapus', 0) //aktif
            ->get();
        $proyek = Proyek::where('status_active', 1)  //aktif
            ->where('hapus', 0) //aktif
            ->get();
                    
        $countlampirans = Lampiran::where('id_reimbursement', $id_reimbursement)->where('hapus', 0)->count();   
        $lampirans = Lampiran::where('id_reimbursement', $id_reimbursement)->where('hapus', 0)->get();
        $lampiran = new Lampiran(); // Inisialisasi variabel $lampiran
        $newLampirans = [];
        // $newLampirans = isset($lampirans[2]["nama_kwitansi"]) ? $lampirans[2]["nama_kwitansi"] : null;
        for ($i = 0; $i < $countlampirans ; $i++) {
            $id_lampiran = isset($lampirans[$i]["id_lampiran"]) ? $lampirans[$i]["id_lampiran"] : null;
            $nomor_kwitansi = isset($lampirans[$i]["nomor_kwitansi"]) ? $lampirans[$i]["nomor_kwitansi"] : null;
            $tanggal_kwitansi = isset($lampirans[$i]["tanggal_kwitansi"]) ? $lampirans[$i]["tanggal_kwitansi"] : null;
            $judul_kwitansi = isset($lampirans[$i]["judul_kwitansi"]) ? $lampirans[$i]["judul_kwitansi"] : null;
            $nama_kwitansi = isset($lampirans[$i]["nama_kwitansi"]) ? $lampirans[$i]["nama_kwitansi"] : null;
            $file = isset($lampirans[$i]["file"]) ? $lampirans[$i]["file"] : null;
            
            if ($file === null){
                $fileUrl = null;
            } elseif (strpos($file, '.pdf') !== false) {

                $fileUrl = asset('LampiranPDFBaru/' .$file);
            } else {
                $fileUrl = asset('LampiranBaru/' . $file);
            }
            // dd($fileUrl);
            $total_kwitansi = isset($lampirans[$i]["total_kwitansi"]) ? $lampirans[$i]["total_kwitansi"] : null;
            $keterangan = isset($lampirans[$i]["keterangan"]) ? $lampirans[$i]["keterangan"] : null;
            
            $newLampirans[] = [
                "id_lampiran" => $id_lampiran,
                "nomor_kwitansi" => $nomor_kwitansi,
                "tanggal_kwitansi" => $tanggal_kwitansi,
                "judul_kwitansi" => $judul_kwitansi,
                "nama_kwitansi" => $nama_kwitansi,
                "file" => $file,
                "fileUrl" => $fileUrl,
                "keterangan" => $keterangan,
                "total_kwitansi" => $total_kwitansi,
            ];               
        }
        // dd($newLampirans);
        return view('superadmin.penunjang-kantor.update', compact('reimbursement', 'jenisReimbursement', 'supplier', 'user', 'lampirans','lampiran','proyek' ,'newLampirans'));
    }


    public function update(Request $request, $id_reimbursement)
    {
        // dd($request->all());
        // Validate input data
        $request->validate([
            'id_jenis_reimbursement' => 'required',
            'id_user' => 'required',
            'tanggal_bayar' => 'required|date',
        ]);

       // Ambil user data
       $user = User::findOrFail($request->input('id_user'));
       $nama_karyawan = $user->nama_karyawan;
       $nomor_identitas_karyawan = $user->nomor_identitas_karyawan;

       // Temukan dan perbarui Reimbursement yang ada
       $reimbursement = Reimbursement::findOrFail($id_reimbursement);
       $id_status_pengajuan = $reimbursement->id_status_pengajuan;
       $tanggal_reimbursement = $reimbursement->tanggal_reimbursement;

       $reimbursement->id_jenis_reimbursement = $request->input('id_jenis_reimbursement');
       $reimbursement->id_user = $request->input('id_user');
       $reimbursement->tanggal_bayar = $request->input('tanggal_bayar');
       $reimbursement->tanggal_reimbursement = $tanggal_reimbursement;
       $reimbursement->keterangan = $request->input('keterangan_reim') ?? $reimbursement->keterangan;
        //$reimbursement->total = str_replace('.', '', $request->total);
        $reimbursement->total = str_replace(',', '', $request->input('total_hidden'));
       $reimbursement->id_status_pengajuan = $id_status_pengajuan;
       $reimbursement->save();

        // Dapatkan ID dari penggantian yang diperbarui
        $reimbursementId = $reimbursement->id_reimbursement;

        // Mengambil data lampiran yang ada
        $existingLampirans = Lampiran::where('id_reimbursement', $reimbursementId)->get()->keyBy('id_lampiran');

        // Mengatur id_jenis_reimbursement dari reimbursement yang baru dibuat
        $id_jenis_reimbursement = $reimbursement->id_jenis_reimbursement;

        // Membuat atau memperbarui lampiran
        $newLampirans = $request->input('lampiran');

        if ($newLampirans) {

            foreach ($newLampirans as $index => $lampiranData) {
                $lampiranId = $lampiranData['id_lampiran'] ?? null;
                $lampiran = $existingLampirans->get($lampiranId);

                if (!$lampiranId && $lampiranData['nomor_kwitansi']) {
                    //  dd( $lampiranData['nomor_kwitansi']);
                    
                    // Jika lampiran belum ada, buat lampiran baru
                    $lampiran = new Lampiran();
                    $lampiran->id_reimbursement = $reimbursementId;
                
                        // Set nilai-nilai lampiran
                        $lampiran->id_jenis_reimbursement = $id_jenis_reimbursement;
                        $lampiran->nomor_kwitansi = $lampiranData['nomor_kwitansi'] ?? null;
                        $lampiran->tanggal_kwitansi = $lampiranData['tanggal_kwitansi'] ?? null;
                        $lampiran->judul_kwitansi = $lampiranData['judul_kwitansi'] ?? null;
                        $lampiran->nama_kwitansi = $lampiranData['nama_kwitansi'] ?? null;
                        $lampiran->keterangan = $lampiranData['keterangan'] ?? null;
                        $lampiran->total_kwitansi = str_replace('.', '', $lampiranData['total_kwitansi']) ?? null;

                        if (isset($lampiranData['file'])) {
                            $lampiran->file = $lampiranData['file'];
                        } else {
                            $lampiran->file = $lampiran->file; // Gunakan nilai file yang sudah ada
                        }
                    
                        $existingFiles = Lampiran::pluck('file')->toArray();

                        if ($request->hasFile("lampiran.$index.file")) {
                        $uploadedFile = $request->file("lampiran.$index.file");
                        $extension = $uploadedFile->getClientOriginalExtension();
                        $allowedExtensions = ['png', 'jpeg', 'jpg', 'pdf'];

                        if (in_array($extension, $allowedExtensions)) {
                            // $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                            // $fileName = $originalFileName . '_' . uniqid() . '.' . $extension;

                            
                            $reimbursement->id_user = $user->id_user;
                            $karyawan = User::findOrFail($id_user);
                            $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                            $extension = $uploadedFile->getClientOriginalExtension();
                            $bulan = date('m');
                            $tahun = date('Y');
                            $uniqenumber = uniqid();
                            $time = time();
                            $fileName = $karyawan->nama_karyawan . '_' . $originalFileName . '_' . $bulan . '_' . $tahun . '_' . $time  . '_' . $uniqenumber. '.' . $extension;
                            

                            if (in_array($fileName, $existingFiles)) {
                                continue;
                            }
                            $destinationPath = public_path('LampiranBaru');
                            if ($extension === 'pdf') {
                                $uploadedFile->move(public_path('LampiranPDFBaru'), $fileName);
                            } else {
                                $imageManager = new ImageManager();
                                $image = $imageManager->make($uploadedFile);
                                $image->resize(null, 2000, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });
                                $image->save($destinationPath . '/' . $fileName);
                            }
                            $lampiran->file = $fileName;
                            }
                        } elseif (!isset($lampiran->file) && !$request->hasFile("lampiran.$index.file")) {
                            $lampiran->file = null;
                        }

                        // Validasi field yang harus diisi
                        if ($index === 1 || $index === 2) {
                            if (
                                $lampiran->nomor_kwitansi === null ||
                                $lampiran->tanggal_kwitansi === null ||
                                $lampiran->judul_kwitansi === null ||
                                $lampiran->nama_kwitansi === null ||
                                $lampiran->file === null ||
                                $lampiran->keterangan === null ||
                                $lampiran->total_kwitansi === null
                            ) {
                                return redirect()
                                    ->route('penunjang-kantor.edit', ['id_reimbursement' => $id_reimbursement])
                                    ->withInput()
                                    ->with([
                                        Alert::error('Gagal', 'Data Reimbursement Penunjang Kantor Gagal Diperbarui')
                                    ]);
                            }
                        }

                        // Set id_supplier berdasarkan pilihan pengguna
                        if ($id_jenis_reimbursement == 4 && $idSupplier) {
                            $lampiran->id_supplier = $idSupplier;
                        } else {
                            $lampiran->id_supplier = null;
                        }

                        $idProyek = $request->input('id_proyek');
                        // Set id_supplier berdasarkan pilihan pengguna
                        if ($id_jenis_reimbursement == 2 && $idProyek) {
                            $lampiran->id_proyek = $idProyek;
                        } else {
                            $lampiran->id_proyek = null;
                        }
            
                        $lampiran->save(); 
                    } 
                    
                    
                    elseif ($lampiran && $lampiranId) {
                        // Lampiran sudah ada, update nilai-nilainya jika ada
                        $lampiran->id_jenis_reimbursement = $id_jenis_reimbursement;
                        $lampiran->id_lampiran = $lampiranData['id_lampiran'] ?? null;
                        $lampiran->nomor_kwitansi = $lampiranData['nomor_kwitansi'] ?? null;
                        $lampiran->tanggal_kwitansi = $lampiranData['tanggal_kwitansi'] ?? null;
                        $lampiran->judul_kwitansi = $lampiranData['judul_kwitansi'] ?? null;
                        $lampiran->nama_kwitansi = $lampiranData['nama_kwitansi'] ?? null;
                        $lampiran->keterangan = $lampiranData['keterangan'] ?? null;
                        $lampiran->total_kwitansi = str_replace('.', '', $lampiranData['total_kwitansi']) ?? null;

                        if (isset($lampiranData['file'])) {
                            $lampiran->file = $lampiranData['file'];
                        } else {
                            $lampiran->file = $lampiran->file; // Gunakan nilai file yang sudah ada
                        }
                
                    
                        $existingFiles = Lampiran::pluck('file')->toArray();

                        if ($request->hasFile("lampiran.$index.file")) {
                        $uploadedFile = $request->file("lampiran.$index.file");
                        $extension = $uploadedFile->getClientOriginalExtension();
                        $allowedExtensions = ['png', 'jpeg', 'jpg', 'pdf'];

                        if (in_array($extension, $allowedExtensions)) {
                            $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                            $fileName = $originalFileName . '_' . uniqid() . '.' . $extension;
                            if (in_array($fileName, $existingFiles)) {
                                continue;
                            }
                            $destinationPath = public_path('LampiranBaru');
                            if ($extension === 'pdf') {
                                $uploadedFile->move(public_path('LampiranPDFBaru'), $fileName);
                            } else {
                                $imageManager = new ImageManager();
                                $image = $imageManager->make($uploadedFile);
                                $image->resize(null, 2000, function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });
                                $image->save($destinationPath . '/' . $fileName);
                            }
                            $lampiran->file = $fileName;
                            }
                        } elseif (!isset($lampiran->file) && !$request->hasFile("lampiran.$index.file")) {
                            $lampiran->file = null;
                        }

                        $idSupplier = $request->input('id_supplier');
                        // Set id_supplier berdasarkan pilihan pengguna
                        if ($id_jenis_reimbursement == 4 && $idSupplier) {
                            $lampiran->id_supplier = $idSupplier;
                        } else {
                            $lampiran->id_supplier = null;
                        }

                        $idProyek = $request->input('id_proyek');
                        // Set id_supplier berdasarkan pilihan pengguna
                        if ($id_jenis_reimbursement == 2 && $idProyek) {
                            $lampiran->id_proyek = $idProyek;
                        } else {
                            $lampiran->id_proyek = null;
                        }

                        $lampiran->save();
                    }
            }
        }
        // Redirect ke halaman yang sesuai setelah berhasil memperbarui
        return redirect()->route('penunjang-kantor.index', $reimbursementId)->with('success', 'Reimbursement Penunjang Kantor berhasil diperbarui.');
    }

    public function destroy($id_reimbursement)
    {
        $reimbursement = Reimbursement::findOrFail($id_reimbursement);
        $reimbursement->hapus= 1;
        $reimbursement->save();
        if ($reimbursement) {
            return redirect()
                ->route('penunjang-kantor.index')
                ->with([
                    Alert::success('Berhasil', 'Data Berhasil Dihapus')
                ]);
        } else {
            return redirect()
                ->route('penunjang-kantor.index')
                ->with([
                    Alert::error('Gagal', 'Data Gagal Dihapus')
                ]);
        }
    }

    
    public function hapusLampiran(Request $request)
    {
        $lampiranId = $request->input('lampiranId');

        // Cek apakah lampiranId valid
        if ($lampiranId) {
            // Hapus data lampiran berdasarkan id_lampiran
            $lampiran = Lampiran::find($lampiranId);
            if ($lampiran) {
                // $lampiran->delete();
                $lampiran->hapus= 1;
                $lampiran->save();

                // Jika berhasil dihapus, berikan respons 200 OK
                return response()->json(['message' => 'Lampiran berhasil dihapus.'], 200);
            }
        }

            // Jika lampiranId tidak valid atau terjadi kesalahan, berikan respons 400 Bad Request
            return response()->json(['message' => 'Gagal menghapus lampiran.'], 400);
    }



    // public function exportExcel(Request $request)
    // {

    //     $bulan_terpilih = $request->input('bulan', 'all');
    //     $tahun_terpilih = $request->input('tahun', 'all');
    //     $uniqueNumber = time();
    //     $fileName = 'Data Reimbursement Penunjang Kantor_' . $bulan_terpilih . '_' . $tahun_terpilih . '_' . $uniqueNumber . '.xlsx';
        
    //     return Excel::download(new ReimbursementPenunjangKantorExport($bulan_terpilih, $tahun_terpilih),  $fileName);
    // }


    public function exportExcel(Request $request)
    {

        $bulan_terpilih = $request->input('bulan', 'all');
        $tahun_terpilih = $request->input('tahun', 'all');
        $searchValue = $request->input('search'); // Memperoleh nilai parameter 'search' dari URL
        // dd($searchValue);


        $uniqueNumber = time();
        $fileName = 'Data Reimbursement Penunjang Kantor_' . $bulan_terpilih . '_' . $tahun_terpilih . '_' . $uniqueNumber . '.xlsx';
        
        // return Excel::download(new ReimbursementPenunjangKantorExport($bulan_terpilih, $tahun_terpilih),  $fileName);

        try {
            return Excel::download(new ReimbursementPenunjangKantorExport($bulan_terpilih, $tahun_terpilih, $searchValue), $fileName);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengunduh file Excel: ' . $e->getMessage()]);
        }     
    
    
    }
  
}