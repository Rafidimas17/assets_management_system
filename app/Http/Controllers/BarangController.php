<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterBarang;
use App\Models\MasterCenterStorage;

class BarangController extends Controller
{
    // Mendapatkan semua barang
    public function index()
    {
        $barang = MasterBarang::all();
        return response()->json($barang, 200);
    }

    // Mendapatkan detail barang berdasarkan ID
    public function show($id)
    {
        $barang = MasterBarang::findOrFail($id);
        $barang_center = MasterCenterStorage::where('barang_id', $id)->first();
    
        $response = [
            'barang' => $barang,
            'jumlah_stock' => $barang_center ? $barang_center->jumlah_stock : null
        ];
    
        return response()->json($response, 200);
    }
    

    // Membuat barang baru
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:master_category,id',
            'nama' => 'required',
            'deskripsi' => 'required',
            'kode_barang' => 'required',
            'jumlah_stock' => 'required', // Pastikan jumlah_stock ada dalam validasi
        ]);
    
        // Ambil nilai jumlah_stock dari request
        $jumlah_stock = $request->jumlah_stock;
    
        // Buat instance MasterBarang tanpa jumlah_stock
        $barang = MasterBarang::create($request->except('jumlah_stock'));
    
        // Buat instance MasterCenterStorage dan masukkan data
        $centerStore = MasterCenterStorage::create([
            'barang_id' => $barang->id,
            'jumlah_stock' => $jumlah_stock,
        ]);
    
        // Beri respons dengan data barang yang dibuat
        return response()->json($barang, 201);
    }
    

    // Memperbarui barang berdasarkan ID
    public function update(Request $request, $id)
    {
        $barang = MasterBarang::findOrFail($id);
        $barang->update($request->all());
    
        // Mengambil data stok dari request
        $stock = $request->jumlah_stock;
    
        // Memperbarui stok di MastercenterStorage
        $storage = MasterCenterStorage::where('barang_id', $id)->first();
     
            $storage->jumlah_stock = $stock;
            $storage->save();
      
    
        return response()->json($barang, 200);
    }

    public function destroy($id)
    {
        // Hapus entri dari MasterBarang
        $barang = MasterBarang::find($id);
        if ($barang) {
            $barang->delete();
        }
    
        // Hapus entri dari MasterCenterStorage
        $storage = MasterCenterStorage::where('barang_id', $id)->first();
        if ($storage) {
            $storage->delete();
        }
    
        // Memberikan respons bahwa penghapusan berhasil dilakukan
        return response()->json(['message' => 'Berhasil menghapus data', 'id' => $id], 200);
    }
    
    
}
