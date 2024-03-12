<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;
use App\Models\MasterRole;
use App\Models\MasterCabang;
use App\Models\MasterBarang;
use App\Models\MasterCategory;

class UserController extends Controller
{
    public function index()
    {
        $users = MasterUser::all();
        $data = [];
    
        foreach ($users as $user) {
            $cabangNama = null;
            if ($user->cabang) {
                $cabangNama = $user->cabang->nama_cabang;
            }
            
            $data[] = [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'username' => $user->username,
                'role' => $user->role->nama_role,
                'cabang' => $cabangNama,
            ];
        }
    
        return response()->json($data, 200);
    }
    
    
    public function show(Request $request)
    {        
        $user = $request->user();           
        $data=[
            'id'=>$user->id,
            'nama' => $user->nama,
            'email' => $user->email,
            'username' => $user->username,
            'role' => $user->role->nama_role,
            // 'cabang'=>$user->cabang->nama, 
        ];
        // Response dengan data pengguna, termasuk nama peran
        return response()->json([$data],200);
    }
    public function role(){
        $role=MasterRole::all();
        return response()->json([$role]);
    }
    public function cabang(){
        $cabang=MasterCabang::all();
        return response()->json([$cabang]);
    }
    public function category(){
        $category=MasterCategory::all();
        return response()->json([$category]);
    }
    public function barang(){
        $barang=MasterBarang::all();
        return response()->json([$barang]);
    }

    public function update(Request $request, $id){
        $user=$request->user();

        $data_users=MasterUser::findOrFail($id);

        $request->validate([
            'cabang_id'=>'required|exists:master_cabang,id',
            'role'=>'required|exists:master_role,id',
            'nama'=>'required|string',
            'username'=>'required|string',
            'email' => 'required|email',
        ]);

        $data_users->update([
            'nama'=>$request->nama,
            'username'=>$request->username,
            'email'=>$request->email,
            'role_id'=>$request->role,
            'cabang_id'=>$request->cabang_id,
        ]);
        

        return response()->json([$data_users],200);

    }
    public function destroy(Request $request,$id)
    {   
        $user = $request->user();        
        $users = MasterUser::find($id);
      

            
            if (! $users) {
                return response()->json(['message' => 'id tidak ditemukan',$barang]);
            }
            
            $users->delete();
            return response()->json(['message' => 'Berhasil menghapus data', 'id' => $id, 'error' => false]);       

    }

    public function showById(Request $request, $id)
{
    $user = $request->user();
    $user = MasterUser::findOrFail($id); // Menggunakan findOrFail agar melempar 404 jika data tidak ditemukan

    $cabangNama = null;
    if ($user->cabang) {
        $cabangNama = $user->cabang->nama_cabang;
    }
    
    $data = [
        'id' => $user->id,
        'nama' => $user->nama,
        'email' => $user->email,
        'username' => $user->username,
        'role' => $user->role->nama_role,
        'cabang' => $cabangNama,
    ];

    return response()->json($data, 200);
}

    
}

