<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusPengajuan;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Alert;
use RealRashid\SweetAlert\Facades\Alert;
use RealRashid\SweetAlert\Facades\Toaster;
use Illuminate\Support\Facades\Auth;


class StatusPengajuanController extends Controller
{

    public function index()
    {
        $statuspengajuans = DB::table('tb_status_pengajuan')
        ->join('tb_role', 'tb_status_pengajuan.id_role', '=', 'tb_role.id_role')
        ->select('tb_status_pengajuan.*', 'tb_role.status_active as role_status_active', 'tb_role.nama_role')
        ->orderBy('tb_role.nama_role', 'asc')
        ->where('tb_status_pengajuan.hapus', '!=', 1)
        // ->where('tb_role.status_active', '=', 1)
        ->get();
    
        $roles = Role::where('hapus', '!=', 1)->get();
        
        return view('superadmin.status-pengajuan.index', compact('statuspengajuans', 'roles'));
    }

   
    public function store(Request $request)
    {
        $existingStatusPengajuan = StatusPengajuan::where('nama_status_pengajuan', $request->nama_status_pengajuan)
            ->where('id_role', $request->id_role)
            ->first();

        if ($existingStatusPengajuan) {
            $existingRole = Role::find($existingStatusPengajuan->id_role);

            return redirect()
            ->route('status-pengajuan.index')
            ->with([
                Alert::error('Gagal', 'Nama dan Role Status Sudah Ada')
            ]);
        }

        $this->validate($request, [
            'id_role' => 'required',
            'nama_status_pengajuan' => 'required',
        ]);

        $status_active = $request->has('status_active') ? 1 : 0;

        $status_pengajuan = StatusPengajuan::create([
            'id_role' => $request->id_role,
            'nama_status_pengajuan' => $request->nama_status_pengajuan,
            'status_active' => $status_active,
        ]);

        if ($status_pengajuan) {
            return redirect()
                ->route('status-pengajuan.index')
                ->with([
                    Alert::success('Berhasil', 'Status Pengajuan Berhasil Ditambahkan')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Status Pengajuan Gagal Ditambahkan')
                ]);
        }
    }


 
    


    public function show($id_status_pengajuan)
    {
        $statuspengajuans = DB::table('tb_status_pengajuan')
            ->where('id_status_pengajuan', $id_status_pengajuan)->first();
        return view('superadmin/status-pengajuan.show', compact('statuspengajuans'));
    }

    public function edit(StatusPengajuan $statuspengajuan)
    {
        $roles = Role::all();
        return view('status-pengajuan.edit', compact('statuspengajuan', 'roles'));
    }

 

    public function update(Request $request, $id_status_pengajuan)
    {
        $status_pengajuan = StatusPengajuan::findOrFail($id_status_pengajuan);

        $existingStatusPengajuan = StatusPengajuan::where('nama_status_pengajuan', $request->nama_status_pengajuan)
            ->where('id_role', $request->id_role)
            ->where('id_status_pengajuan', '!=', $id_status_pengajuan)
            ->first();

        if ($existingStatusPengajuan) {
            return redirect()
                ->route('status-pengajuan.index')
                ->with([
                    Alert::error('Gagal', 'Nama dan Role Status Sudah Ada')
                ]);
        }

     
        $status_pengajuan->id_role = $request->id_role;
        $status_pengajuan->nama_status_pengajuan = $request->nama_status_pengajuan;
        $status_pengajuan->status_active = $request->has('status_active') ? 1 : 0;
        $status_pengajuan->save();

        return redirect()->route('status-pengajuan.index')->with('success', 'Status pengajuan berhasil diupdate.');
    }


    public function destroy($id_status_pengajuan)
    {
        $status_pengajuan = StatusPengajuan::findOrFail($id_status_pengajuan);
        $status_pengajuan->hapus= 1;
        $status_pengajuan->save();
        if ($status_pengajuan) {
            return redirect()
                ->route('status-pengajuan.index')
                ->with([
                    Alert::success('Berhasil', 'Data Status Pengajuan Berhasil Dihapus')
                ]);
        } else {
            return redirect()
                ->route('status-pengajuan.index')
                ->with([
                    Alert::error('Gagal', 'Data Status Pengajuan Gagal Dihapus')
                ]);
        }
        // dd($id_divisi);
    }
    
}