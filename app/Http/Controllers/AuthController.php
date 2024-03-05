<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterUser;
use App\Models\MasterRole; 
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make(request()->only('nama', 'email', 'password','username','role','cabang_id'), [
            'nama' => 'required',
            'email' => 'required|email|unique:master_user,email', // Perbaiki kolom 'email' menjadi 'email'
            'role' => 'required|exists:master_role,id', 
            'cabang_id'=>'required|exists:master_cabang,id',
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = MasterUser::create([
            'nama' => $request->nama,
            'email' => $request->email, 
            'role_id' => $request->role,
            'cabang_id' => $request->cabang_id,
            'username' => $request->username,
            'password' => Hash::make($request->password), 
        ]);
       

        $token = JWTAuth::fromUser($user);

       

        return response()->json(compact('user', 'token'), 201);
    }
  
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
            $user = MasterUser::where('email', $request->email)->first();
           
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
    
        return response()->json(compact('token'));
    }
    
    public function logout(Request $request)
    {

        $token = $request->header('Authorization');

        try {
            JWTAuth::parseToken()->invalidate($token);

            return response()->json([
                'error' => false,
                'message' => trans('auth.logged_out'),
            ]);
        } catch (TokenExpiredException $exception) {
            return response()->json([
                'error' => true,
                'message' => trans('auth.token.expired'),
            ], 401);
        } catch (TokenInvalidException $exception) {
            return response()->json([
                'error' => true,
                'message' => trans('auth.token.invalid'),
            ], 401);
        } catch (JWTException $exception) {
            return response()->json([
                'error' => true,
                'message' => trans('auth.token.missing'),
            ], 500);
        }
    }
}
