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
use Illuminate\Support\Facades\File;


class ReimbursementController extends Controller
{
        public function index()
    {
        $jenisReimbursement = JenisReimbursement::all();
        $user = User::whereHas('role', function ($query) {
            $query->where('id_role', 4);
        })->get();
        $supplier = Supplier::all();
        $proyek = Proyek::all();
        $statusPengajuan = StatusPengajuan::join('tb_role', 'tb_status_pengajuan.id_role', '=', 'tb_role.id_role')
            ->select('tb_status_pengajuan.*', 'tb_role.nama_role')
            ->where('tb_role.nama_role', 'Super Admin')
            ->get();
        $lampiran = new Lampiran(); // Inisialisasi variabel $lampiran
        return view('superadmin.reimbursement.index', compact('jenisReimbursement', 'supplier', 'proyek','user', 'statusPengajuan', 'lampiran'));
    }


    public function create()
    {
        $jenisReimbursement = JenisReimbursement::all();
        $user = User::whereHas('role', function ($query) {
            $query->where('id_role', 4);
        })->get();
        $supplier = Supplier::all();
        $proyek = Proyek::all();
        $statusPengajuan = StatusPengajuan::join('tb_role', 'tb_status_pengajuan.id_role', '=', 'tb_role.id_role')
            ->select('tb_status_pengajuan.*', 'tb_role.nama_role')
            ->where('tb_role.nama_role', 'Super Admin')
            ->get();
        $lampiran = new Lampiran(); // Inisialisasi variabel $lampiran
        return view('superadmin.reimbursement.index', compact('jenisReimbursement', 'supplier', 'proyek','user', 'statusPengajuan', 'lampiran'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        // Validate input data
        $request->validate([
            'id_jenis_reimbursement' => 'required',
            'id_user' => 'required',
            'tanggal_bayar' => 'required|date',
            'tanggal_reimbursement' => 'required|date',
            'keterangan' => 'required',
            'total' => 'required',
            'id_status_pengajuan' => 'required',
            // 'file' => 'required|file|mimes:pdf,png,jpeg|max:2048',
        ]);

        // Ambil user data
        $user = User::findOrFail($request->input('id_user'));
        $nama_karyawan = $user->nama_karyawan;
        $nomor_identitas_karyawan = $user->nomor_identitas_karyawan;

        // Membuat Reimbursement Baru
        $reimbursement = new Reimbursement();
        $reimbursement->id_jenis_reimbursement = $request->input('id_jenis_reimbursement');
        $reimbursement->id_user = $request->input('id_user');
        $reimbursement->nomor_identitas_karyawan = $nomor_identitas_karyawan;
        $reimbursement->nama_karyawan = $nama_karyawan;
        $reimbursement->tanggal_bayar = $request->input('tanggal_bayar');
        $reimbursement->tanggal_reimbursement = $request->input('tanggal_reimbursement');
        $reimbursement->keterangan = $request->input('keterangan');
        // $reimbursement->total = $request->input('total');
        $reimbursement->total = str_replace('.', '', $request->total);
        // 'gaji' =>  str_replace('.', '', $request->gaji),
        $reimbursement->id_status_pengajuan = $request->input('id_status_pengajuan');
        $reimbursement->save();

        // Dapatkan ID dari penggantian yang baru dibuat
        $reimbursementId = $reimbursement->id_reimbursement;


        // Mengatur id_jenis_reimbursement dari reimbursement yang baru dibuat
        $id_jenis_reimbursement = $reimbursement->id_jenis_reimbursement;

        // Membuat Lampiran Baru
        $lampiranData = $request->input('lampiran');
        if ($lampiranData) {
            $isLampiranAdded = false; // Deklarasi variabel flag

            foreach ($lampiranData as $index => $data) {
                if ($index === 0 && !$data['nomor_kwitansi']) {
                    // Jika lampiran 1 tidak diisi, berikan pesan kesalahan
                    return redirect()->back()->withErrors(['Lampiran 1 harus diisi.']);
                }

                if ($data['nomor_kwitansi'] || $data['tanggal_kwitansi'] || $data['judul_kwitansi'] || $data['nama_kwitansi'] ||  isset($data['file']) || $data['keterangan']) {
                    $lampiran = new Lampiran();
                    $lampiran->nomor_kwitansi = $data['nomor_kwitansi'];
                    $lampiran->tanggal_kwitansi = $data['tanggal_kwitansi'];
                    $lampiran->judul_kwitansi = $data['judul_kwitansi'];
                    $lampiran->nama_kwitansi = $data['nama_kwitansi'];
                   
                    // Ambil data file yang ada di database
                    $existingFiles = Lampiran::pluck('file')->toArray();

                    // for ($i = 0; $i < 3; $i++) {
                        if ($request->hasFile("lampiran.$index.file")) {
                            $uploadedFile = $request->file("lampiran.$index.file");
                            $extension = $uploadedFile->getClientOriginalExtension();
                            $allowedExtensions = ['png', 'jpeg', 'jpg', 'pdf'];

                            if (in_array($extension, $allowedExtensions)) {
                                $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                                $fileName = $originalFileName . '_' . uniqid() . '.' . $extension;

                                // Periksa apakah file sudah ada di database
                                if (in_array($fileName, $existingFiles)) {
                                    // File sudah ada, lewati proses penyimpanan
                                    continue;
                                }

                                // Lanjutkan dengan penyimpanan file
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
                            } else {
                                return redirect()->back()->withErrors(["lampiran.$index.file" => 'Hanya file PNG, JPEG, JPG, atau PDF yang diizinkan.']);
                            }
                        }
                    // }
     
                  
                    $lampiran->keterangan = $data['keterangan'];
                    $lampiran->id_reimbursement = $reimbursementId;
                    
                    // Set the id_jenis_reimbursement value from the newly created reimbursement
                    $lampiran->id_jenis_reimbursement = $id_jenis_reimbursement;

                    // Ambil data dari request
                    $idJenisReimbursement = $request->input('id_jenis_reimbursement');
                    $idSupplier = $request->input('id_supplier');

                    
                    // Set id_supplier berdasarkan pilihan pengguna
                    if ($idJenisReimbursement == 4 && $idSupplier) {
                        $lampiran->id_supplier = $idSupplier;
                    } else {
                        $lampiran->id_supplier = null;
                    }


                    $idProyek = $request->input('id_proyek');
                    // Set id_supplier berdasarkan pilihan pengguna
                    if ($idJenisReimbursement == 2 && $idProyek) {
                        $lampiran->id_proyek = $idProyek;
                    } else {
                        $lampiran->id_proyek = null;
                    }


                    $lampiran->save();
                    $isLampiranAdded = true; // Set flag menjadi true karena setidaknya satu lampiran ditambahkan 
                }
            }
            // Cek apakah setidaknya satu lampiran ditambahkan sebelum menyimpan data reimbursement
            if (!$isLampiranAdded) {
                // Hapus data reimbursement yang baru dibuat
                $reimbursement->delete();
                // Set pesan error
                return redirect()->back()->withErrors(['Setidaknya satu lampiran harus ditambahkan.']);
            }
        }
        // success
        Alert::success('Berhasil', 'Reimbursement record created successfully');

        // Redirect ke reimbursement index
        return redirect()->route('reimbursement.index')->with('success', 'Reimbursement record created successfully.');
    }
}