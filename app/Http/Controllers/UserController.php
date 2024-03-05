<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;

class UserController extends Controller
{
    public function show(Request $request)
    {        
        $user = $request->user();           
        $data=[
            'nama' => $user->nama,
            'email' => $user->email,
            'username' => $user->username,
            'role' => $user->role->nama_role 
        ];
        // Response dengan data pengguna, termasuk nama peran
        return response()->json([$data],200);
    }
    
}

