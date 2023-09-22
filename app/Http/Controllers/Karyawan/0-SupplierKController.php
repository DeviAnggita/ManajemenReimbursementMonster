<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Alert;
use Illuminate\Support\Facades\Auth;


class SupplierKController extends Controller
{
    
    public function index()
    {
        $suppliers = DB::table('tb_supplier')
        ->orderBy('nama_supplier', 'asc')
        ->get();
        return view('karyawan/supplier.index', compact('suppliers'));
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
    
            $supplier = Supplier::create([
                'nama_supplier' => $request->nama_supplier,
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
        return view('karyawan/supplier.show', compact('suppliers'));
    }

    public function edit($id_supplier)
    {
        $supplier = Supplier::findOrFail($id_supplier);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id_supplier)
    {
        $supplier = Supplier::findOrFail($id_supplier);
        $supplier->nama_supplier = $request->nama_supplier;
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
    $supplier->delete();
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