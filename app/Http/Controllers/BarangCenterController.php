<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterCenterStorage;
use App\Models\MasterOfficeStorage;
use App\Models\MasterBarang;
use App\Models\MasterCabang;

class BarangCenterController extends Controller
{
    // CRUD untuk barang di pusat
    public function index()
    {
        $barangs = MasterCenterStorage::all();
        $data = [];
    
        foreach ($barangs as $barang) {
            // Mengambil MasterBarang berdasarkan id
            $masterBarang = MasterBarang::find($barang->id);
    
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
    
    public function show($id)
    {
        $barang = MasterCenterStorage::find($id);
        $data = [];
    
        if ($barang) {
            // Mengambil MasterBarang berdasarkan id
            $masterBarang = MasterBarang::find($barang->id);
    
            // Memeriksa jika MasterBarang ditemukan
            if ($masterBarang) {
                $data = [
                    'id' => $barang->id,
                    'nama' => $masterBarang->nama,
                    'deskripsi' => $masterBarang->deskripsi,
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
    

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:master_barang,id', // Pastikan kolom barang_id tidak boleh kosong
            'jumlah_stock' => 'required|integer', // Contoh validasi untuk jumlah_stock
            
        ]);
        $barang = MasterCenterStorage::create($request->all());
        return response()->json($barang, 201);
    }

    public function update(Request $request, $id)
    {
        $barang = MasterCenterStorage::findOrFail($id);
        $barang->update($request->all());
        return response()->json($barang, 200);
    }

    public function destroy(Request $request,$id)
    {   
        $user = $request->user();        
        $barang = MasterCenterStorage::find($id);
      

            
            if (! $barang) {
                return response()->json(['message' => 'id tidak ditemukan',$barang]);
            }
            
            $barang->delete();
            return response()->json(['message' => 'Berhasil menghapus data', 'id' => $id, 'error' => false]);
       

    }
    

    public function showBarangByCabang($cabangId)
    {
        // Mengambil semua data barang berdasarkan cabang_id
        $barangs = MasterOfficeStorage::where('cabang_id', $cabangId)->get();
        $data = [];
    
        foreach ($barangs as $barang) {
            // Mengambil MasterBarang berdasarkan barang_id dari setiap entri MasterOfficeStorage
            $masterBarang = MasterBarang::find($barang->barang_id);
    
            // Jika MasterBarang ditemukan, tambahkan data ke dalam $data
            if ($masterBarang) {
                $data[] = [
                    'id' => $barang->id,
                    'nama' => $masterBarang->nama,
                    'deskripsi' => $masterBarang->deskripsi,
                    'category' => $masterBarang->category->nama,
                    'tanggal_penambahan' => $barang->created_at,
                    'kode_barang' => $masterBarang->kode_barang,
                    'stock' => $barang->jumlah_stock,
                ];
            }
        }
    
        // Mengembalikan data dalam bentuk respons JSON
        return response()->json($data, 200);
    }
    

    // Operasi untuk melihat daftar cabang
    public function indexCabang()
    {
        $cabangs = MasterCabang::all();
        return response()->json($cabangs, 200);
    }

    // CRUD untuk cabang
    public function storeCabang(Request $request)
    {
        $cabang = MasterCabang::create($request->all());
        return response()->json($cabang, 201);
    }

    public function updateCabang(Request $request, $id)
    {
        $cabang = MasterCabang::findOrFail($id);
        $cabang->update($request->all());
        return response()->json($cabang, 200);
    }

    public function destroyCabang(Request $request,$id)
    {   
        $user = $request->user();        
        $cabang = MasterCabang::find($id);
      

            
            if (! $cabang) {
                return response()->json(['message' => 'id tidak ditemukan',$cabang]);
            }
            
            $cabang->delete();
            return response()->json(['message' => 'Berhasil menghapus data', 'id' => $id, 'error' => false]);
       

    }
}
