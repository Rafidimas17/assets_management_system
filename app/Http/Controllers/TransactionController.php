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
            'nama_pemohon'=>$user->nama,
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
            $officeStock = MasterOfficeStorage::where([
                ['cabang_id', $transaction->cabang_id],
                ['barang_id', $transaction->barang_id]
            ])->first();
           
            switch ($user->role->nama_role) {
                case 'HQ':
                    if ($transaction->status_transaksi === "drafted" && $request->status_transaksi == 'approved') {                      
                       
                            $transaction->status_transaksi = 'approved';
                            $transaction->user_id = $user->id;
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
                        $transaction->user_id = $user->id;
                        $transaction->status_transaksi = 'rejected';
                    } else {
                        return response()->json(['message' => 'Invalid transaction status'], 400);
                    }
                    break;
                
          
                case 'Manager':
                   

                     if ($transaction->status_transaksi === 'pending' && $request->status_transaksi === 'drafted') {
                        if ($request->status_transaksi === 'drafted') {
                            $transaction->user_id = $user->id;
                            $transaction->status_transaksi = 'drafted';
                        } elseif ($request->status_transaksi === 'rejected') {
                            $transaction->user_id = $user->id;
                            $transaction->status_transaksi = 'rejected';
                        } else {
                            return response()->json(['message' => 'Invalid transaction status'], 400);
                        }
                    } else {
                        return response()->json(['message' => 'Transaction cannot be updated'], 400);
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
        $user=$request->user();
        $data_transaction=MasterTransaction::where('cabang_id',$user->cabang->id)->get();

        return response()->json($data_transaction);
    }

}
