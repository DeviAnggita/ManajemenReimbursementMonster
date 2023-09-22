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
use Illuminate\Support\Facades\Mail;


class ReimbursementController extends Controller
{
        public function index()
    {
        $jenisReimbursement = JenisReimbursement::all();
        
        $user = User::where('id_role', 4)
            ->where('hapus', '!=', 1)
            ->where('status_active', '=', 1)
            ->get();

        $supplier = Supplier::where('hapus', '!=', 1)
        ->where('status_active', '=', 1)
        ->get();
        
        $proyek = Proyek::where('hapus', '!=', 1)
        ->where('status_active', '=', 1)
        ->get();
        
    
        $lampiran = new Lampiran(); // Inisialisasi variabel $lampiran
        return view('superadmin.reimbursement.index', compact('jenisReimbursement', 'supplier', 'proyek','user',  'lampiran'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate input data
        $request->validate([
            'id_jenis_reimbursement' => 'required',
            'id_user' => 'required',
            'tanggal_bayar' => 'required|date',
            'keterangan' => 'required',
            'total' => 'required',
        ]);

        // // Ambil user data
        // $user = User::findOrFail($request->input('id_user'));
        // $nama_karyawan = $user->nama_karyawan;
        // $email_karyawan = $user->email_karyawan; //role 4
        // $nomor_identitas_karyawan = $user->nomor_identitas_karyawan;

        // Retrieve the input value of id_user
        $id_user = $request->input('id_user');

        // Retrieve the user data based on id_user
        $user = User::find($id_user);

        // Check if the user exists
        if ($user) {
            // User found, extract the nama_karyawan
            $nama_karyawan = $user->nama_karyawan;
            $email_karyawan = $user->email_karyawan;
            $nomor_identitas_karyawan = $user->nomor_identitas_karyawan;
        } else {
            // Handle the case when the user is not found
            // You can throw an exception, redirect, or provide a default value
            $nama_karyawan = 'Unknown';  // Set a default value for nama_karyawan
            $email_karyawan = 'Unknown';  // Set a default value for nama_karyawan
            $nomor_identitas_karyawan = 'Unknown'; // Set a default value for nomor_identitas_karyawan
        }

       
      
      
        // $user_verifikasi = User::where('id_role', 2)
        //     ->where('id_divisi', '=', $user->id_divisi)
        //     ->pluck('users.id_user');

        // $user_verifikasi_mk = User::where('id_role', 3)
        //     ->pluck('users.id_user');

        // $id_user_verifikasi = $user_verifikasi[0];
        // $id_user_verifikasi_mk = $user_verifikasi_mk[0];
        // // dd($id_user_verifikasi_mk);

        // $reimbursement->id_user_verifikasi =  $id_user_verifikasi ;
        // $reimbursement->id_user_verifikasi =  $id_user_verifikasi_mk ;
        // dd($email_karyawan);
        

        // Membuat Reimbursement Baru
        $reimbursement = new Reimbursement();
        $reimbursement->id_jenis_reimbursement = $request->input('id_jenis_reimbursement');
        $reimbursement->id_user = $request->input('id_user');
        $reimbursement->nomor_identitas_karyawan = $nomor_identitas_karyawan;
        $reimbursement->nama_karyawan = $nama_karyawan;
        $reimbursement->tanggal_bayar = $request->input('tanggal_bayar');
        date_default_timezone_set('Asia/Jakarta');
        $reimbursement->tanggal_reimbursement = now()->format('Y-m-d');
        $reimbursement->keterangan = $request->input('keterangan');
        $reimbursement->total = str_replace('.', '', $request->total);
        $reimbursement->id_status_pengajuan = 28;
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
                    return redirect()->back()->withErrors(['Lampiran 1 harus diisi.'])->withInput();
                }
                
                if ($data['nomor_kwitansi'] || $data['tanggal_kwitansi'] || $data['judul_kwitansi'] || $data['nama_kwitansi'] ||  isset($data['file']) || $data['keterangan']) {
                    $lampiran = new Lampiran();
                    $lampiran->nomor_kwitansi = $data['nomor_kwitansi'];
                    $lampiran->tanggal_kwitansi = $data['tanggal_kwitansi'];
                    $lampiran->judul_kwitansi = $data['judul_kwitansi'];
                    $lampiran->nama_kwitansi = $data['nama_kwitansi'];
                   
                    // Ambil data file yang ada di database
                    $existingFiles = Lampiran::pluck('file')->toArray();

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
                    

                    $email_kepaladivisi = User::where('id_role', 2)
                    ->where('id_divisi', '=', $user->id_divisi)
                    ->pluck('users.email_karyawan');
                    
                    $receiver = $email_kepaladivisi[0];
                    $subject = "Mohon Verifikasi Status Pengajuan Reimbursment Karyawan";                    
                    $id_jenis_reimbursement = $reimbursement->id_jenis_reimbursement;
                    $jenis_reimbursement = DB::table('tb_reimbursement')
                    ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_reimbursement.id_jenis_reimbursement')
                    ->where('tb_reimbursement.id_jenis_reimbursement', $id_jenis_reimbursement)
                    ->select('tb_jenis_reimbursement.nama_jenis_reimbursement')
                    ->first();
                    $nama_jenis_reimbursement = $jenis_reimbursement->nama_jenis_reimbursement;
                    
                    $body = $nama_karyawan;
                    $body2 = $nama_jenis_reimbursement;
                    $body3 = number_format($reimbursement->total, 0, ',', '.');
                    $body3 = 'Rp. ' . $body3 . ',00';                    
                    $body4 = $reimbursement->keterangan; 
                                        
                    $lampiran->save();
                    $this->sendEmail($receiver, $subject, $body, $body2, $body3, $body4);                  
                    $isLampiranAdded = true; // Set flag menjadi true karena setidaknya satu lampiran ditambahkan 
                }
            }
            // Cek apakah setidaknya satu lampiran ditambahkan sebelum menyimpan data reimbursement
            if (!$isLampiranAdded) {
                // Hapus data reimbursement yang baru dibuat
                // $reimbursement->delete();
                $reimbursement->hapus= 1;
                $reimbursement->save();
                // Set pesan error
                return redirect()->back()->withErrors(['Setidaknya satu lampiran harus ditambahkan.']);
            }
        }
        // success
        Alert::success('Berhasil', 'Reimbursement record created successfully');

        // Redirect ke reimbursement index
        return redirect()->route('reimbursement.index')->with('success', 'Reimbursement record created successfully.');
    }

    
    public function sendEmail($receiver, $subject, $body, $body2, $body3, $body4)
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
            ];

            Mail::send('SuperAdmin.reimbursement.email', $email, function ($message) use ($email) {
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