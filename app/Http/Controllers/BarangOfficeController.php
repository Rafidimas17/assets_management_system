<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterOfficeStorage;
use App\Models\MasterBarang;
    

class BarangOfficeController extends Controller
{
    public function show()
    {
        // Mengambil ID cabang dari pengguna saat ini
        $cabangId = auth()->user()->cabang->id;
    
        // Mengambil data barang dari tabel MasterOfficeStorage berdasarkan cabangId
        $barangs = MasterOfficeStorage::where('cabang_id', $cabangId)->get();
        $data = [];
    
        foreach ($barangs as $barang) {
            // Mengambil MasterBarang berdasarkan id barang
            $masterBarang = MasterBarang::find($barang->barang_id);
    
            // Memeriksa jika MasterBarang ditemukan
            if ($masterBarang) {
                $data[] = [
                    'id' => $barang->id,
                    'nama' => $masterBarang->nama,
                    'category' => $masterBarang->category->nama,
                    'tanggal_penambahan' => $barang->created_at,
                    'kode_barang' => $masterBarang->kode_barang,
                    'stock' => $barang->jumlah_stock,
                ];
            }
        }
        
        // Response dengan data barang beserta kategori
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