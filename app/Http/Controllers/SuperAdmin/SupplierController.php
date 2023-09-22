<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class SupplierController extends Controller
{

    public function index()
    {
        $suppliers = DB::table('tb_supplier')
            ->orderBy('nama_supplier', 'asc')
            ->where('tb_supplier.hapus', '!=', 1)
            ->get();
        return view('superadmin.supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $nama_supplier = Supplier::where('nama_supplier', $request->nama_supplier)->first();
        if ($nama_supplier == true) {
            return redirect()
                ->route('supplier.index')
                ->with([
                    Alert::error('Gagal', 'Nama Supplier Sudah Ada')
                ]);
        } else {
            $this->validate($request, [
                'nama_supplier' => 'required',
            ]);
            
            $status_active = $request->has('status_active') ? 1 : 0;
            $supplier = Supplier::create([
                'nama_supplier' => $request->nama_supplier,
                'status_active' => $status_active,
            ]);

            if ($supplier) {
                return redirect()
                    ->route('supplier.index')
                    ->with([
                        Alert::success('Berhasil', 'Supplier Berhasil Ditambahkan')
                    ]);
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with([
                        Alert::error('Gagal', 'Supplier Gagal Ditambahkan')
                    ]);
            }
        }
        // dd($request->all());
    }

    public function show($id_supplier)
    {
        $suppliers = DB::table('tb_supplier')
            ->where('id_supplier', $id_supplier)->first();
        return view('superadmin.supplier.show', compact('suppliers'));
    }

    public function edit($id_supplier)
    {
        $supplier = Supplier::findOrFail($id_supplier);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id_supplier)
    {
        $nama_supplier = Supplier::where('nama_supplier', $request->nama_supplier)
        ->where('id_supplier', '!=', $id_supplier)
        ->first();

        if ($nama_supplier) {
            return redirect()
                ->route('supplier.index')
                ->with([
                    Alert::error('Gagal', 'Nama Supplier Sudah Ada')
                ]);
        }

        $this->validate($request, [
            'nama_supplier' => 'required',
        ]);

        
        $supplier = Supplier::findOrFail($id_supplier);
        $supplier->nama_supplier = $request->nama_supplier;
        $supplier->status_active = $request->has('status_active') ? 1 : 0;
        $supplier->save();
        if ($supplier) {
            return redirect()
                ->route('supplier.index')
                ->with([
                    Alert::success('Berhasil', 'Data Supplier Berhasil Diubah')
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    Alert::error('Gagal', 'Data Supplier Gagal Diubah')
                ]);
        }
    }


    public function destroy($id_supplier)
    {
        $supplier = Supplier::findOrFail($id_supplier);
        $supplier->hapus= 1;
        $supplier->save();
        if ($supplier) {
            return redirect()
                ->route('supplier.index')
                ->with([
                    Alert::success('Berhasil', 'Data Supplier Berhasil Dihapus')
                ]);
        } else {
            return redirect()
                ->route('supplier.index')
                ->with([
                    Alert::error('Gagal', 'Data Supplier Gagal Dihapus')
                ]);
        }
        // dd($id_divisi);
    }
}