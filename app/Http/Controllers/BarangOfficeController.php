<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterOfficeStorage;

class BarangOfficeController extends Controller
{
    public function show(Request $request)
    {        
        $user = $request->user();           
        
        $data_barang = MasterOfficeStorage::where('cabang_id', $user->cabang->id)->get();
        $data = [];

        foreach ($data_barang as $barang) {
            $data[] = [
                'id'=>$barang->id,
                'nama' => $barang->barang->nama,
                'cabang' => $barang->cabang->nama_cabang,
                'stock' => $barang->jumlah_stock,
            ];
        }
        
        // Response dengan data pengguna, termasuk nama peran
        return response()->json($data, 200);
    }
    
}