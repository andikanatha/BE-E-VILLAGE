<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User as User;
use Illuminate\Support\Facades\Crypt;
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
        // $users = User::all()->with('meetings:image')->get();
        // return response()->json(['message' => 'APInya AQILL BANGGG', 'data' => $users]);
        return response([
            'users' => User::orderBy('id', 'desc')->with('meetings')->get(),
        ], 200);
    }


    //Register
    public function register (Request $request){
        $validation =$request->validate([
            'name'=>'required|string',
            'username'=>'required|string|unique:users,username',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6',
            'pin'=>'required',
        ]);

        $hashedPassword = Hash::make($validation['password']);

        $user = User::Create([
            'username'=>$validation['username'],
            'name'=>$validation['name'],
            'email'=>$validation['email'],
            'pin'=>$validation['pin'],
            'saldo'=>'0',
            'akses'=>'user',
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
            'username'=>'required|string|unique:users,username',
            'password'=>'required|min:6',
            'pin'=>'required',
        ]);

        $hashedPassword = Hash::make($validation['password']);

        $user = User::Create([
            'username'=>$validation['username'],
            'name'=>$validation['name'],
            'email'=>$validation['email'],
            'saldo'=>'0',
            'akses'=>'admin',
            'pin'=>$validation['pin'],
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

  

    public function updateuserimg(Request $request)
    {

      
        $image_user = $this->saveImage($request->image_user, 'profiles');

       

        auth()->user()->update([
            'image_user' => "$image_user"
        ]);

        return response([
            'message' => 'Berhasil Update User'
        ], 200);
    }

    public function update(Request $request)
    {


        $validation =$request->validate([
            'name'=>'required|string',
           
        ]);
       

        auth()->user()->update([
            'name'=>$validation['name'],
        ]);

        return response([
            'message' => 'Berhasil Update User'
        ], 200);
    }
    
    public function updateusername(Request $request)
    {

        $validation =$request->validate([
            'username'=>'required|string|unique:users,username',
        ]);
       

        auth()->user()->update([
            'username'=>$validation['username'],
        ]);

        return response([
            'message' => 'Berhasil Update User'
        ], 200);
    }
    public function updatepin(Request $request)
    {

        $validation =$request->validate([
            'pin'=>'required',
        ]);
       

        auth()->user()->update([
            'pin'=>$validation['pin'],
        ]);

        return response([
            'message' => 'Berhasil Update Pin'
        ], 200);
    }
    public function updatepassword(Request $request)
    {

        $validation =$request->validate([
            'password'=>'required|min:6',
            'currentpw'=>'required',
        ]);
       
        
        if (Hash::check($validation['currentpw'], auth()->user()->password)) {
            $hashedPassword = Hash::make($validation['password']);
            auth()->user()->update([
                'password'=>    $hashedPassword,
            ]);

            return response([
                'message' => 'Berhasil Update Password'
            ], 200);
    
        } else {
            return response([
                'message' =>'Password lama yang anda masukkan tidak sesuai'
            ], 403);
        }
        
       
    }

    public function searchuser($username){
        return response([
            'users' => User::query()->where('username', 'LIKE', "%{$username}%" )->where('akses', 'user')->get()
        ], 200);
    }

}
