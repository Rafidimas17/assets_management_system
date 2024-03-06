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
    public function delete(Request $request,$id)
    {   
        $user = $request->user();        
        $barang = MasterOfficeStorage::find($id);
        if($user->cabang->id === $barang->cabang_id){

            
            if (! $barang) {
                return response()->json(['message' => 'id tidak ditemukan',$barang]);
            }
            
            $barang->delete();
            return response()->json(['message' => 'Berhasil menghapus data', 'id' => $id, 'error' => false]);
        }else{
            return response()->json(['message' => 'Anda tidak memiliki akses'],401);
        }

    }
    public function detailBarang(Request $request, $id)
    {
        $user = $request->user();
    
        try {
            $data_barang = MasterOfficeStorage::where('id', $id)->first();
    
            if ($data_barang) {
                $data = [
                    'nama' => $data_barang->barang->nama,
                    'deskripsi' => $data_barang->barang->deskripsi,
                    'pemilik' => $data_barang->cabang->nama_cabang,
                    'jumlah_stock' => $data_barang->jumlah_stock,
                    'kode_barang' => $data_barang->barang->kode_barang,
                    'tanggal_permintaan' => $data_barang->created_at,
                ];
    
                return response()->json($data, 200);
            } else {
                return response()->json(['message' => 'Barang tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }    
}