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
    public function index(){
        $users = MasterUser::all();
        $data = [];
    
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'nama' => $user->nama,
                'email' => $user->email,
                'username' => $user->username,
                'role' => $user->role->nama_role,
                'cabang' => $user->cabang->nama_cabang, 
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
            'cabang'=>$user->cabang->nama_cabang, 
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
    
}

