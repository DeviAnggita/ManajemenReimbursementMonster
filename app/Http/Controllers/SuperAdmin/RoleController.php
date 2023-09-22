<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Alert;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class RoleController extends Controller
{

    public function index()
    {
        $roles = DB::table('tb_role')
            ->orderBy('nama_role', 'asc')
            ->where('tb_role.hapus', '!=', 1)
            ->get();
        return view('superadmin.role.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $nama_role = Role::where('nama_role', $request->nama_role)->first();
        if ($nama_role == true) {
            return redirect()
                ->route('role.index')
                ->with([
                    Alert::error('Gagal', 'Nama Role Sudah Ada')
                ]);
        } else {
            $this->validate($request, [
                'nama_role' => 'required',
            ]);

            $status_active = $request->has('status_active') ? 1 : 0;

            $role = Role::create([
                'nama_role' => $request->nama_role,
                'status_active' => $status_active,
            ]);
            

            if ($role) {
                return redirect()
                    ->route('role.index')
                    ->with([
                        Alert::success('Berhasil', 'Role Berhasil Ditambahkan')
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Role Gagal Ditambahkan')
                    ]);
            }
        }
        // dd($request->all());
    }

    public function show($id_role)
    {
        $roles = DB::table('tb_role')
            ->where('id_role', $id_role)->first();
        return view('superadmin/role.show', compact('roles'));
    }

    public function edit($id_role)
    {
        $role = Role::findOrFail($id_role);
        return view('role.edit', compact('role'));
    }

    public function update(Request $request, $id_role)
    {

        $nama_role = Role::where('nama_role', $request->nama_role)
        ->where('id_role', '!=', $id_role)
        ->first();

        if ($nama_role) {
            return redirect()
                ->route('role.index')
                ->with([
                    Alert::error('Gagal', 'Nama Role Sudah Ada')
                ]);
        }

        $role = Role::findOrFail($id_role);
        $role->nama_role = $request->nama_role;
        $role->status_active = $request->has('status_active') ? 1 : 0;
        $role->save();

        // $status
        if ($role) {
            return redirect()
                ->route('role.index')
                ->with([
                    Alert::success('Berhasil', 'Data Role Berhasil Diubah')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Role Gagal Diubah')
                ]);
        }
    }


    // public function destroy($id_role)
    // {
    //     $role = Role::findOrFail($id_role);
    //     $role->delete();
    //     if ($role) {
    //         return redirect()
    //             ->route('role.index')
    //             ->with([
    //                 Alert::success('Berhasil', 'Data Role Berhasil Dihapus')
    //             ]);
    //     } else {
    //         return redirect()
    //             ->route('role.index')
    //             ->with([
    //                 Alert::error('Gagal', 'Data Role Gagal Dihapus')
    //             ]);
    //     }
    //     // dd($id_divisi);
    // }


    public function destroy($id_role)
    {
        $role = Role::findOrFail($id_role);
        $role->hapus= 1;
        $role->save();
        if ($role) {
            return redirect()
                ->route('role.index')
                ->with([
                    Alert::success('Berhasil', 'Data Role Berhasil Dihapus')
                ]);
        } else {
            return redirect()
                ->route('role.index')
                ->with([
                    Alert::error('Gagal', 'Data Role Gagal Dihapus')
                ]);
        }
        // dd($id_divisi);
    }
}