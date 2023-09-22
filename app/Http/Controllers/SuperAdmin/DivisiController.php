<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Divisi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Alert;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class DivisiController extends Controller
{

    public function index()
    {
        $divisis = DB::table('tb_divisi')
            ->orderBy('nama_divisi', 'asc')
            ->where('tb_divisi.hapus', '!=', 1)
            ->get();
        return view('superadmin.divisi.index', compact('divisis'));
    }

    public function store(Request $request)
    {
        $nama_divisi = Divisi::where('nama_divisi', $request->nama_divisi)->first();
        if ($nama_divisi == true) {
            return redirect()
                ->route('divisi.index')
                ->with([
                    Alert::error('Gagal', 'Nama Divisi Sudah Ada')
                ]);
        } else {
            $this->validate($request, [
                'nama_divisi' => 'required',
                // 'status_active' => 'required',
            ]);
            $status_active = $request->has('status_active') ? 1 : 0;

            $divisi = Divisi::create([
                'nama_divisi' => $request->nama_divisi,
                'status_active' => $status_active,
                // 'hapus' => 0,
            ]);
            if ($divisi) {
                return redirect()
                    ->route('divisi.index')
                    ->with([
                        Alert::success('Berhasil', 'Divisi Berhasil Ditambahkan')
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Divisi Gagal Ditambahkan')
                    ]);
            }
        }
        // dd($request->all());
    }

    public function show($id_divisi)
    {
        $divisis = DB::table('tb_divisi')
            ->where('id_divisi', $id_divisi)->first();
        return view('superadmin.divisi.show', compact('divisis'));
    }

    public function edit($id_divisi)
    {
        $divisi = Divisi::findOrFail($id_divisi);
        return view('divisi.edit', compact('divisi'));
    }

    public function update(Request $request, $id_divisi)
    {

        $nama_divisi = Divisi::where('nama_divisi', $request->nama_divisi)
        ->where('id_divisi', '!=', $id_divisi)
        ->first();

        if ($nama_divisi) {
            return redirect()
                ->route('divisi.index')
                ->with([
                    Alert::error('Gagal', 'Nama Divisi Sudah Ada')
                ]);
        }

        $this->validate($request, [
            'nama_divisi' => 'required',
        ]);

        $divisi = Divisi::findOrFail($id_divisi);
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->status_active = $request->has('status_active') ? 1 : 0;
        $divisi->save();
        if ($divisi) {
            return redirect()
                ->route('divisi.index')
                ->with([
                    Alert::success('Berhasil', 'Data Divisi Berhasil Diubah')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Divisi Gagal Diubah')
                ]);
        }
    }


    // public function destroy($id_divisi)
    // {
    //     $divisi = Divisi::findOrFail($id_divisi);
    //     $divisi->delete();
    //     if ($divisi) {
    //         return redirect()
    //             ->route('divisi.index')
    //             ->with([
    //                 Alert::success('Berhasil', 'Data karyawan Berhasil Dihapus')
    //             ]);
    //     } else {
    //         return redirect()
    //             ->route('divisi.index')
    //             ->with([
    //                 Alert::error('Gagal', 'Data karyawan Gagal Dihapus')
    //             ]);
    //     }
    //     // dd($id_divisi);
    // }

    public function destroy($id_divisi)
    {
        $divisi = Divisi::findOrFail($id_divisi);
        $divisi->hapus= 1;
        $divisi->save();
    
        if ($divisi) {
            return redirect()
                ->route('divisi.index')
                ->with([
                    Alert::success('Berhasil', 'Data karyawan Berhasil Dihapus')
                ]);
        } else {
            return redirect()
                ->route('divisi.index')
                ->with([
                    Alert::error('Gagal', 'Data karyawan Gagal Dihapus')
                ]);
        }
        // dd($id_divisi);
    }
}