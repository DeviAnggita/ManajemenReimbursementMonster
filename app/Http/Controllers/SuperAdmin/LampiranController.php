<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lampiran;
use App\Models\Reimbursement;
use App\Models\Supplier;
use App\Models\JenisReimbursement;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Alert;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class LampiranController extends Controller
{

    public function index()
    {
        $lampirans = DB::table('tb_lampiran')
            ->join('tb_reimbursement', 'tb_reimbursement.id_reimbursement', '=', 'tb_lampiran.id_reimbursement')
            ->join('tb_supplier', 'tb_supplier.id_supplier', '=', 'tb_lampiran.id_supplier')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_lampiran.id_jenis_reimbursement')
            ->orderBy('nomor_kwitansi', 'asc')
            ->get();
        $reimbursements = Reimbursement::get();
        $suppliers = Supplier::get();
        $jenis_reimbursements = JenisReimbursement::get();
        return view('superadmin/lampiran.index', compact('lampirans', 'reimbursements', 'suppliers', 'jenis_reimbursements'));
    }

    public function create()
    {
        $reimbursements = Reimbursement::get();
        $suppliers = Supplier::get();
        $jenis_reimbursements = JenisReimbursement::get();
        return view('superadmin/lampiran.create', compact('reimbursements, suppliers, jenis_reimbursements'));
    }

    public function store(Request $request)
    {
        // validasi jumlah lampiran yang telah ditambahkan
        if (Lampiran::count() >= 3) {
            return redirect()->back()->with('error', 'Tidak dapat menambahkan data lampiran lagi.');
        }

        // kode untuk menyimpan data lampiran ke dalam database

        $nomor_kwitansi = Lampiran::where(
            'nomor_kwitansi',
            $request->nomor_kwitansi
        )->first();

        if ($nomor_kwitansi == true) {
            return redirect()
                ->route('lampiran.index')
                ->with([
                    Alert::error('Gagal', 'Nomor Identitas Karyawan Sudah Ada')
                ]);
        } else {
            $this->validate($request, [
                'id_reimbursement' => 'required',
                'id_supplier' => 'required',
                'id_jenis_reimbursement' => 'required',
                'nomor_kwitansi' => 'required|min:10|max:10',
                'tanggal_kwitansi' => 'required',
                'judul_kwitansi' => 'required',
                'nama_kwitansi' => 'required',
                'file' => 'mimes:doc,docx,pdf',
                'keterangan' => 'required',
            ]);

            // $dokumen =$request->file('dokumen');
            // $nama_dokumen = 'FT'.date('Ymdhis').'.'.$request->file('dokumen')->getClientOriginalExtension();

            $lampiran = Lampiran::create([
                'id_reimbursement' => $request->id_reimbursement,
                'id_supplier'  => $request->id_supplier,
                'id_jenis_reimbursement'  => $request->id_jenis_reimbursement,
                'nomor_kwitansi' => $request->nomor_kwitansi,
                'tanggal_kwitansi' => $request->tanggal_kwitansi,
                'judul_kwitansi' => $request->judul_kwitansi,
                'nama_kwitansi' => $request->nama_kwitansi,
                'file'  => $request->file('dokumen')->getClientOriginalExtension(),
                'keterangan'  => $request->keterangan,
            ]);
            if ($lampiran) {
                return redirect()
                    ->route('lampiran.index')
                    ->with([
                        Alert::success('Berhasil', 'Data Karyawan Berhasil Ditambahkan')
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Data Karyawan Gagal Ditambahkan')
                    ]);
            }
        }
        // dd($request->all());
    }

    public function show($id_lampiran)
    {
        $lampirans = DB::table('tb_lampiran')
            ->join('tb_reimbursement', 'tb_reimbursement.id_reimbursement', '=', 'tb_lampiran.id_reimbursement')
            ->join('tb_supplier', 'tb_supplier.id_supplier', '=', 'tb_lampiran.id_supplier')
            ->join('tb_jenis_reimbursement', 'tb_jenis_reimbursement.id_jenis_reimbursement', '=', 'tb_lampiran.id_jenis_reimbursement')
            ->where('id_lampiran', $id_lampiran)->first();
        return view('superadmin/lampiran.show', compact('lampirans'));
    }

    public function edit($id_lampiran)
    {
        $lampiran = Lampiran::findOrFail($id_lampiran);
        return view('lampiran.edit', compact('lampiran'));
    }

    public function update(Request $request, $id_lampiran)
    {
        $lampiran = Lampiran::findOrFail($id_lampiran);
        $lampiran->nama_lampiran = $request->nama_lampiran;
        $lampiran->save();
        if ($lampiran) {
            return redirect()
                ->route('lampiran.index')
                ->with([
                    Alert::success('Berhasil', 'Data lampiran Berhasil Diubah')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data lampiran Gagal Diubah')
                ]);
        }
    }

    // public function destroy($id_lampiran)
    // {
    //     $lampiran = Lampiran::findOrFail($id_lampiran);
    //     $lampiran->delete();
    //     if ($lampiran) {
    //         return redirect()
    //             ->route('lampiran.index')
    //             ->with([
    //                 Alert::success('Berhasil', 'Data lampiran Berhasil Dihapus')
    //             ]);
    //     } else {
    //         return redirect()
    //             ->route('lampiran.index')
    //             ->with([
    //                 Alert::error('Gagal', 'Data lampiran Gagal Dihapus')
    //             ]);
    //     }
    //     // dd($id_divisi);
    // }

    public function destroyLampiran2 ($id_lampiran)
    {
        $lampiran = Lampiran::findOrFail($id_lampiran);
    
        if ($lampiran) {
            $lampiran->delete();
    
            return redirect()
                ->route('perjalanan-bisnis.index')
                ->with([
                    'success' => 'Data lampiran berhasil dihapus.'
                ]);
        } else {
            return redirect()
                ->route('perjalanan-bisnis.index')
                ->with([
                    'error' => 'Gagal menghapus data lampiran.'
                ]);
        }
    }
    
    public function destroyLampiran3 ($id_lampiran)
    {
        $lampiran = Lampiran::findOrFail($id_lampiran);
    
        if ($lampiran) {
            $lampiran->delete();
    
            return redirect()
                ->route('perjalanan-bisnis.index')
                ->with([
                    'success' => 'Data lampiran berhasil dihapus.'
                ]);
        } else {
            return redirect()
                ->route('perjalanan-bisnis.index')
                ->with([
                    'error' => 'Gagal menghapus data lampiran.'
                ]);
        }
    }
}