<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterTransaction;
use App\Models\MasterCenterStorage;
use App\Models\MasterOfficeStorage;
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
        return response()->json([$data],200);
    }
    public function submit(Request $request){
        $user=$request->user();
        if($user->role->nama_role==="Office"){        
        $validator=Validator::make(request()->only('barang_id','user_id','jumlah','catatan'),[
            'barang_id'=>'required|exists:master_barang,id',     
            'jumlah'=>'required|number',
            'catatan'=>'string',
        ]);
        $transaction=MasterTransaction::create([
            'barang_id'=>$request->barang_id,
            'cabang_id'=>$user->cabang->id,
            'user_id'=>$user->id,
            'tanggal_transaksi'=>Carbon::now(),
            'status_transaksi'=>'pending',
            'jumlah_pengajuan'=>$request->jumlah,
            'catatan'=>$request->catatan,
        ]);
        return response()->json([$transaction],201); 
    }else{
        return response()->json(['message'=>"Anda tidak diijinkan untuk membuat pengajuan"],401); 
    }
    }
    public function update(Request $request, $id)
    {
        $user = $request->user();

        try {
            $transaction = MasterTransaction::findOrFail($id);

            switch ($user->role->nama_role) {
                case 'HQ':
                    if ($request->status_transaksi === 'approved' && $transaction->status_transaksi === "drafted" ) {
                        $transaction->status_transaksi === 'approved';
                        $transaction->user_id = $user->id;                   
                        $officeStock = MasterOfficeStorage::where([
                            ['cabang_id', $transaction->cabang_id],
                            ['barang_id', $transaction->barang_id]
                        ])->first();

                        $officeStock = MasterOfficeStorage::where([
                            ['cabang_id', $transaction->cabang_id],
                            ['barang_id', $transaction->barang_id]
                        ])->first();                    
                        if($officeStock === null) {                       
                            MasterOfficeStorage::create([
                                'cabang_id' => $transaction->cabang_id,
                                'barang_id' => $transaction->barang_id,
                                'jumlah_stock' => $transaction->jumlah_pengajuan
                            ]);
                        } else {                      
                            $officeStock->jumlah_stock += $transaction->jumlah_pengajuan;
                            $officeStock->save();
                        
                        
                            $centerStock = MasterCenterStorage::where('barang_id', $transaction->barang_id)->first();
                            $centerStock->jumlah_stock -= $transaction->jumlah_pengajuan;
                            $centerStock->save();
                        }                        
                    } elseif ($request->status_transaksi === 'rejected'  && $transaction->status_transaksi === "drafted" ) {
                        $transaction->status_transaksi = 'rejected';
                    } else {
                    
                        return response()->json(['message' => 'Invalid transaction status'], 400);
                    }                
                    break;
                case 'Manager':
                    if ($request->status_transaksi === 'drafted'  && $transaction->status_transaksi === "pending" ) {
                    
                    $transaction->status_transaksi = 'drafted';
                    }else if($request->status_transaksi === 'rejected'  && $transaction->status_transaksi === "pending" ){
                        $transaction->status_transaksi = 'rejected';
                    }
                    break;
                case 'Office':
                
                    if ($request->status_transaksi === 'pending') {
                    
                        $transaction->status_transaksi = 'pending';
                        }else if($request->status_transaksi === 'rejected'){
                            $transaction->status_transaksi = 'rejected';
                        }
                        break;
                    break;
                default:
                    // Jika peran tidak sesuai, kembalikan respons dengan pesan kesalahan
                    return response()->json(['message' => 'User does not have permission to approve transactions'], 403);
            }

            // Mengatur user_id dan menyimpan transaksi
            $transaction->user_id = $user->id;
            $transaction->save();

            return response()->json(['message' => 'Transaction updated successfully',$officeStock], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Transaction update failed'], 400);
        }
    }

}
