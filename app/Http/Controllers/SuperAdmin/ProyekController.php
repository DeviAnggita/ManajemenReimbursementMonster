<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyek;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class ProyekController extends Controller
{

    public function index()
    {
        $proyeks = DB::table('tb_proyek')
            ->orderBy('nomor_proyek', 'asc')
            ->where('tb_proyek.hapus', '!=', 1)
            ->get();
        return view('superadmin.proyek.index', compact('proyeks'));
    }

    public function store(Request $request)
    {
        $nomor_proyek = Proyek::where('nomor_proyek', $request->nomor_proyek)->first();
        
        if ($nomor_proyek == true) {
            return redirect()
                ->route('proyek.index')
                ->with([
                    Alert::error('Gagal', 'Nomor Proyek Sudah Ada')
                ]);
        } else {


            $this->validate($request, [
                'nomor_proyek' => 'required|numeric|unique:tb_proyek,nomor_proyek',
                'nama_proyek' => 'required|unique:tb_proyek,nama_proyek',
            ]);
             
            $status_active = $request->has('status_active') ? 1 : 0;


            $proyek = Proyek::create([
                'nomor_proyek' => $request->nomor_proyek,
                'nama_proyek' => $request->nama_proyek,
                'status_active' => $status_active,
            ]);

            if ($proyek) {
                return redirect()
                    ->route('proyek.index')
                    ->with([
                        Alert::success('Berhasil', 'Proyek Berhasil Ditambahkan')
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Proyek Gagal Ditambahkan')
                    ]);
            }
        }
    }

    public function show($id_proyek)
    {
        $proyeks = DB::table('tb_proyek')
            ->where('id_proyek', $id_proyek)->first();
        return view('superadmin.proyek.show', compact('proyeks'));
    }

    public function edit($id_proyek)
    {
        $proyek = Proyek::findOrFail($id_proyek);
        return view('proyek.edit', compact('proyek'));
    }

    public function update(Request $request, $id_proyek)
    {
        $existingProyek = Proyek::where(function ($query) use ($request, $id_proyek) {
            $query->where('nama_proyek', $request->nama_proyek)
                ->orWhere('nomor_proyek', $request->nomor_proyek);
        })->where('id_proyek', '!=', $id_proyek)->first();
        
        if ($existingProyek) {
            return redirect()
                ->route('proyek.index')
                ->with([
                    Alert::error('Gagal', 'Nama Proyek atau Nomor Proyek Sudah Ada')
                ]);
        }
        
        $proyek = Proyek::findOrFail($id_proyek);
        $proyek->nomor_proyek = $request->nomor_proyek;
        $proyek->nama_proyek = $request->nama_proyek;
        $proyek->status_active = $request->has('status_active') ? 1 : 0;
        $proyek->save();
        if ($proyek) {
            return redirect()
                ->route('proyek.index')
                ->with([
                    Alert::success('Berhasil', 'Data Proyek Berhasil Diubah')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Proyek Gagal Diubah')
                ]);
        }
    }


    public function destroy($id_proyek)
    {
        $proyek = Proyek::findOrFail($id_proyek);
        $proyek->hapus= 1;
        $proyek->save();
        if ($proyek) {
            return redirect()
                ->route('proyek.index')
                ->with([
                    Alert::success('Berhasil', 'Data Proyek Berhasil Dihapus')
                ]);
        } else {
            return redirect()
                ->route('proyek.index')
                ->with([
                    Alert::error('Gagal', 'Data Proyek Gagal Dihapus')
                ]);
        }
    }
}