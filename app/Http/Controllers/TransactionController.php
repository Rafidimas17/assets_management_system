<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTransaction;
use App\Models\MasterBarang;
use App\Models\MasterCenterStorage;
use App\Mail\Notification;
use App\Models\MasterCabang;
use App\Models\MasterOfficeStorage;
use Illuminate\Support\Facades\Mail;
use App\Models\MasterUser;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request){
        $user=$request->user();

        $transactions = MasterTransaction::where('cabang_id', $user->cabang->id)->get();
        $data = [];

        foreach ($transactions as $transaction) {
            $data[] = [
                'id'=>$transaction->id,
                'nama' => $transaction->barang->nama,
                'cabang'=>$transaction->cabang->nama_cabang,
                'tanggal_transaksi'=>$transaction->tanggal_transaksi,
                'jumlah'=>$transaction->jumlah_pengajuan,
                'status'=>$transaction->status_transaksi,               
            ];
        }
        return response()->json([$user],200);
    }

    public function show(Request $request){
        $user = $request->user();
    
        $transactions = MasterTransaction::all();
    
        $data = [];
    
        foreach ($transactions as $transaction) {
            $namaBarang = $transaction->barang->nama;
    
            
            $namaCabang = MasterCabang::where('id', $transaction->cabang_id)->value('nama_cabang');
    
            $data[] = [
                'id' => $transaction->id,
                'nama' => $namaBarang,
                'nama_barang'=>$namaBarang,
                'cabang' => $namaCabang,
                'tanggal_transaksi' => $transaction->tanggal_transaksi,
                'jumlah' => $transaction->jumlah_pengajuan,
                'status' => $transaction->status_transaksi,               
            ];
        }
    
        // Return respons JSON dengan data yang telah disiapkan
        return response()->json($data, 200);
    }
    public function submit(Request $request){
        $user=$request->user();
        if($user->role->nama_role==="Office"){        
        $validator=Validator::make(request()->only('barang_id','user_id','jumlah','catatan'),[
            'barang_id'=>'required|exists:master_barang,id',     
            'jumlah'=>'required|number',
            'catatan'=>'string',
        ]);
        $barang = MasterBarang::where('id',$request->barang_id)->first();
        $pengguna = MasterUser::where('role_id', 2)
        ->where('cabang_id', $user->cabang->id)
        ->first();
        $nama_barang=$barang->nama;
        $transaction=MasterTransaction::create([
            'nama_pemohon'=>$user->nama,
            'barang_id'=>$request->barang_id,
            'cabang_id'=>$user->cabang->id,
            'user_id'=>$user->id,
            'tanggal_transaksi'=>Carbon::now(),
            'status_transaksi'=>'pending',
            'jumlah_pengajuan'=>$request->jumlah,
            'catatan'=>$request->catatan,
        ]);
        Mail::to($pengguna->email)->send(new Notification($user->nama, $user->cabang->nama_cabang, $request->jumlah,$request->catatan,$nama_barang));
        return response()->json([$transaction, $nama_barang],201); 
    }else{
        return response()->json(['message'=>"Anda tidak diijinkan untuk membuat pengajuan"],401); 
    }
    }
    public function update(Request $request, $id)
    {
        $user = $request->user();

        try {
            $transaction = MasterTransaction::findOrFail($id);
            $officeStock = MasterOfficeStorage::where([
                ['cabang_id', $transaction->cabang_id],
                ['barang_id', $transaction->barang_id]
            ])->first();
           
            switch ($user->role->nama_role) {
                case 'HQ':
                    if ($transaction->status_transaksi === 'drafted' && $request->status_transaksi === 'approved') {
                        // Periksa apakah entri sudah ada di MasterCenterStorage
                        $centerStock = MasterCenterStorage::where('barang_id', $transaction->barang_id)->first();
                        if ($centerStock) {
                            // Jika entri sudah ada, tambahkan jumlah_pengajuan ke jumlah_stock yang sudah ada
                            $centerStock->jumlah_stock -= $transaction->jumlah_pengajuan;
                        } else {
                            // Jika entri belum ada, buat entri baru di MasterCenterStorage
                            $centerStock = new MasterCenterStorage();
                            $centerStock->barang_id = $transaction->barang_id;
                            $centerStock->cabang_id = $transaction->cabang_id;
                            $centerStock->jumlah_stock = $transaction->jumlah_pengajuan;
                        }
                        $transaction->status_transaksi = "approved";
                        // Simpan perubahan pada stok barang di MasterCenterStorage
                        $centerStock->save();
                
                        // Periksa apakah entri sudah ada di MasterOfficeStorage
                        $officeStock = MasterOfficeStorage::where('barang_id', $transaction->barang_id)
                                                            ->where('cabang_id', $transaction->cabang_id)
                                                            ->first();
                        if ($officeStock) {
                            // Jika entri sudah ada, tambahkan jumlah_pengajuan ke jumlah_stock yang sudah ada
                            $officeStock->jumlah_stock += $transaction->jumlah_pengajuan;
                        } else {
                            // Jika entri belum ada, buat entri baru di MasterOfficeStorage
                            $officeStock = new MasterOfficeStorage();
                            $officeStock->barang_id = $transaction->barang_id;
                            $officeStock->cabang_id = $transaction->cabang_id;
                            $officeStock->jumlah_stock = $transaction->jumlah_pengajuan;
                        }
                        // Simpan perubahan pada stok barang di MasterOfficeStorage
                        $officeStock->save();
                    } elseif ($request->status_transaksi === 'rejected' && $transaction->status_transaksi === 'drafted') {
                        // Atur status transaksi menjadi ditolak
                        $transaction->status_transaksi = 'rejected';
                    } else {
                        return response()->json(['message' => 'Invalid transaction status'], 400);
                    }
                    break;                                
          
                    case 'Manager':
                        // Pastikan status transaksi adalah 'pending' dan request status adalah 'drafted'
                        if ($transaction->status_transaksi === 'pending' && $request->status_transaksi === 'drafted') {
                            // Jika request status adalah 'drafted', atur status transaksi menjadi 'drafted'
                            $transaction->user_id = $user->id;
                            $transaction->status_transaksi = 'drafted';
                        } elseif ($request->status_transaksi === 'rejected') {
                            // Jika request status adalah 'rejected', atur status transaksi menjadi 'rejected'
                            $transaction->user_id = $user->id;
                            $transaction->status_transaksi = 'rejected';
                        } else {
                            // Jika status transaksi tidak sesuai dengan kondisi yang diharapkan, kembalikan pesan kesalahan
                            return response()->json(['message' => 'Invalid transaction status'], 400);
                        }
                        break;
                    
                
                case 'Office':
                
                    if ($request->status_transaksi === 'pending'  && $request->status_transaksi === 'pending') {
                        $transaction->user_id = $user->id;
                        $transaction->status_transaksi = 'pending';
                        }else if($request->status_transaksi === 'rejected'){
                            $transaction->user_id = $user->id;
                            $transaction->status_transaksi = 'rejected';
                        }
                        break;
                    break;
                default:
                    return response()->json(['message' => 'User does not have permission to approve transactions'], 403);
            }

         
            $transaction->user_id = $user->id;
            $transaction->save();

            return response()->json(['message' => 'Transaction updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Transaction update failed','error'], 400);
            // return response()->json(['message' => 'Transaction update failed','error'=>$e->getMessage()], 400);
        }
    }
    public function showById(Request $request){
        $data_transaction = MasterTransaction::where('cabang_id', $request->user()->cabang->id)->get();
        $data = [];
        
        foreach ($data_transaction as $data_trans) {
            $barang = MasterBarang::find($data_trans->barang_id);
            $nama_barang = $barang ? $barang->nama : null; // Pastikan barang ditemukan sebelum mengambil namanya
            // Cari peran dari tabel MasterUser berdasarkan user_id dalam transaksi
            $user = MasterUser::find($data_trans->user_id);
            $role = $user ? $user->role->nama_role : null; // Pastikan user ditemukan sebelum mengambil peran
    
            $data[] = [
                'id' => $data_trans->id,
                'nama_pemohon' => $data_trans->nama_pemohon,
                'role' => $role,
                'nama_barang' => $nama_barang,
                "tanggal_transaksi" => $data_trans->tanggal_transaksi,
                "status_transaksi" => $data_trans->status_transaksi,
                "jumlah_pengajuan" => $data_trans->jumlah_pengajuan,
                "created_at" => $data_trans->created_at,
            ];
        }
    
        return response()->json($data);
    }

    public function history($id)
    {
        try {
            // Cari transaksi berdasarkan id yang diberikan
            $transaction = MasterTransaction::findOrFail($id);
    
            // Cari data cabang berdasarkan cabang_id yang ada pada transaksi
            $cabang = MasterCabang::find($transaction->cabang_id);
    
            // Cek apakah status transaksi adalah "approved" atau "rejected"
            if ($transaction->status_transaksi === 'approved' || $transaction->status_transaksi === 'rejected') {
                // Buat respons dengan data yang diinginkan
                $data = [
                    'nama_barang' => $transaction->barang->nama,
                    'tanggal_transaksi' => $transaction->tanggal_transaksi,
                    'nama_category' => $transaction->barang->category->nama,
                    'status' => $transaction->status_transaksi,
                    'nama_cabang' => $cabang->nama_cabang ? $cabang->nama_cabang : null, // Jika cabang ditemukan, ambil nama cabang. Jika tidak, set null.
                    'catatan' => $transaction->catatan,
                    'nama_pemohon' => $transaction->nama_pemohon
                ];
    
                // Kembalikan respons dalam format JSON
                return response()->json($data, 200);
            } else {
                // Jika status transaksi tidak valid, kembalikan pesan kesalahan
                return response()->json(['message' => 'Transaction status is not approved or rejected'], 400);
            }
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, kembalikan pesan kesalahan
            return response()->json(['message' => 'Transaction not found'], 404);
        }
    }
    
    
    
    

}
