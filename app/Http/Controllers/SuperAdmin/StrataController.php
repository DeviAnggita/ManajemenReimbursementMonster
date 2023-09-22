<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Strata;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Alert;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class StrataController extends Controller
{

    public function index()
    {
        $stratas = DB::table('tb_strata')
            ->orderBy('nama_strata', 'asc')
            ->where('tb_strata.hapus', '!=', 1)
            ->get();
        return view('superadmin.strata.index', compact('stratas'));
    }

    public function store(Request $request)
    {
        $nama_strata = Strata::where('nama_strata', $request->nama_strata)->first();
        if ($nama_strata == true) {
            return redirect()
                ->route('strata.index')
                ->with([
                    Alert::error('Gagal', 'Nama Strata Sudah Ada')
                ]);
        } else {
            $this->validate($request, [
                'nama_strata' => 'required',
            ]);
            $status_active = $request->has('status_active') ? 1 : 0;

            $strata = Strata::create([
                'nama_strata' => $request->nama_strata,
                'status_active' => $status_active,
            ]);
            // dd($strata);

            if ($strata) {
                return redirect()
                    ->route('strata.index')
                    ->with([
                        Alert::success('Berhasil', 'Strata Berhasil Ditambahkan')
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Strata Gagal Ditambahkan')
                    ]);
            }
        }
        // dd($request->all());
    }

    public function update(Request $request, $id_strata)
    {
        $nama_strata = Strata::where('nama_strata', $request->nama_strata)
            ->where('id_strata', '!=', $id_strata)
            ->first();
    
        if ($nama_strata) {
            return redirect()
                ->route('strata.index')
                ->with([
                    Alert::error('Gagal', 'Nama Strata Sudah Ada')
                ]);
        }
    
        $this->validate($request, [
            'nama_strata' => 'required',
        ]);
    
        $strata = Strata::findOrFail($id_strata);
        $strata->nama_strata = $request->nama_strata;
        $strata->status_active = $request->has('status_active') ? 1 : 0;
        $strata->save();
    
        if ($strata) {
            return redirect()
                ->route('strata.index')
                ->with([
                    Alert::success('Berhasil', 'Data Strata Berhasil Diubah')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Strata Gagal Diubah')
                ]);
        }
    }
    
     public function destroy($id_strata)
    {
        $strata = Strata::findOrFail($id_strata);
        $strata->hapus = 1;
        $strata->save();

        if ($strata) {
            return redirect()
                ->route('strata.index')
                ->with([
                    Alert::success('Berhasil', 'Data Strata Berhasil Dihapus')
                ]);
        } else {
            return redirect()
                ->route('strata.index')
                ->with([
                    Alert::error('Gagal', 'Data Strata Gagal Dihapus')
                ]);
        }
        // dd($id_divisi);
    }

}