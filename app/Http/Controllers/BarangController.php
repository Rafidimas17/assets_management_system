<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterBarang;

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
        return response()->json($barang, 200);
    }

    // Membuat barang baru
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'nama_barang' => 'required',
            'harga' => 'required',
            'stok' => 'required'
        ]);

        $barang = MasterBarang::create($request->all());
        return response()->json($barang, 201);
    }

    // Memperbarui barang berdasarkan ID
    public function update(Request $request, $id)
    {
        $barang = MasterBarang::findOrFail($id);
        $barang->update($request->all());
        return response()->json($barang, 200);
    }

    // Menghapus barang berdasarkan ID
    public function destroy($id)
    {
        $barang = MasterBarang::findOrFail($id);
        $barang->delete();
        return response()->json(['message' => 'Barang deleted successfully'], 204);
    }
}
