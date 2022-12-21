<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User as User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function login (Request $request){
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Auth::attempt($validation)){
            return response([
                'message' => 'User tidak ditemukan'
            ],403);
        }
 
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);
    }


    public function getalluser()
    {
        $users = User::all();
        return response()->json(['message' => 'APInya AQILL BANGGG', 'data' => $users]);
    }


    //Register
    public function register (Request $request){
        $validation =$request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
        ]);

        $hashedPassword = Hash::make($validation['password']);

        $user = User::Create([
            'name'=>$validation['name'],
            'email'=>$validation['email'],
            'saldo'=>'0',
            'akses'=>'user',
            'image_user'=>'image',
            'password'=>$hashedPassword,
        ]);

        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ]);
    }


    public function registeradmin (Request $request){
        $validation =$request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
        ]);

        $hashedPassword = Hash::make($validation['password']);

        $user = User::Create([
            'name'=>$validation['name'],
            'email'=>$validation['email'],
            'saldo'=>'0',
            'akses'=>'admin',
            'password'=>$hashedPassword,
        ]);

        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ]);
    }


    

    
    public function logout()
    {
        auth()->user()->token()->delete();
        return response([
            'message' => 'Berhasil Logout'
        ], 200);
    }

    public function user(){
        return response([
            'user' => auth()->user()
        ],200);
    }

    public function topupSaldo(Request $request)
    {
        $validation = $request->validate([
            'saldo' => 'string'
        ]);

        auth()->user()->update([
            'saldo' => $validation['saldo'],
        ]);

        return response([
            'message' => 'Berhasil Topup Saldo',
            'user' => auth()->user()
        ], 200);
    }


}
