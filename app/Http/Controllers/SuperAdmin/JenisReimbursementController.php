<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisReimbursement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Alert;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class JenisReimbursementController extends Controller
{

    public function index()
    {
        $jenisreimbursements = DB::table('tb_jenis_reimbursement')
            ->orderBy('nama_jenis_reimbursement', 'asc')
            ->get();
        return view('superadmin/jenisreimbursement.index', compact('jenisreimbursements'));
    }

    public function store(Request $request)
    {
        $nama_jenis_reimbursement = JenisReimbursement::where('nama_jenis_reimbursement', $request->nama_jenis_reimbursement)->first();
        if ($nama_jenis_reimbursement == true) {
            return redirect()
                ->route('jenisreimbursement.index')
                ->with([
                    Alert::error('Gagal', 'Nama Jenis Reimbursement Sudah Ada')
                ]);
        } else {
            $this->validate($request, [
                'nama_jenis_reimbursement' => 'required',
            ]);

            $jenisreimbursement = JenisReimbursement::create([
                'memiliki_supplier' => '0',
                'memiliki_proyek' => '0',
                'nama_jenis_reimbursement' => $request->nama_jenis_reimbursement,
            ]);

            if ($jenisreimbursement) {
                return redirect()
                    ->route('jenisreimbursement.index')
                    ->with([
                        Alert::success('Berhasil', 'Jenis Reimbursement Berhasil Ditambahkan')
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Jenis Reimbursement Gagal Ditambahkan')
                    ]);
            }
        }
        // dd($request->all());
    }

    public function show($id_jenis_reimbursement)
    {
        $jenisreimbursements = DB::table('tb_jenis_reimbursement')
            ->where('id_jenis_reimbursement', $id_jenis_reimbursement)->first();
        return view('superadmin/jenisreimbursement.show', compact('jenisreimbursements'));
    }

    public function edit($id_jenis_reimbursement)
    {
        $jenisreimbursement = JenisReimbursement::findOrFail($id_jenis_reimbursement);
        return view('jenisreimbursement.edit', compact('jenisreimbursement'));
    }

    public function update(Request $request, $id_jenis_reimbursement)
    {
        $jenisreimbursement = JenisReimbursement::findOrFail($id_jenis_reimbursement);
        // $jenisreimbursement->memiliki_supplier = $request->memiliki_supplier;
        // $jenisreimbursement->memiliki_supplier = $request->memiliki_supplier;
        $jenisreimbursement->nama_jenis_reimbursement = $request->nama_jenis_reimbursement;
        $jenisreimbursement->save();
        if ($jenisreimbursement) {
            return redirect()
                ->route('jenisreimbursement.index')
                ->with([
                    Alert::success('Berhasil', 'Data Jenis Reimbursement Berhasil Diubah')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Jenis Reimbursement Gagal Diubah')
                ]);
        }
    }

    public function destroy($id_jenis_reimbursement)
    {
        $jenisreimbursement = JenisReimbursement::findOrFail($id_jenis_reimbursement);
        $jenisreimbursement->delete();
        if ($jenisreimbursement) {
            return redirect()
                ->route('jenisreimbursement.index')
                ->with([
                    Alert::success('Berhasil', 'Data Jenis Reimbursement Berhasil Dihapus')
                ]);
        } else {
            return redirect()
                ->route('jenisreimbursement.index')
                ->with([
                    Alert::error('Gagal', 'Data Jenis Reimbursement Gagal Dihapus')
                ]);
        }
        // dd($id_divisi);
    }
}