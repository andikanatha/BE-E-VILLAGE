<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function newrembug(Request $request)
        {
            //validate fields
            $attrs = $request->validate([
                'deskripsi' => 'required|string',
            ]);
    
            $rembugdata = Meeting::create([
                'deskripsi' => $attrs['deskripsi'],
                'id_user' => auth()->user()->id
            ]);
    
    
            return response([
                'message' => 'Berhasil Upload.',
                'data' => $rembugdata,
                'users' => $rembugdata->id_user
            ], 200);
        }

        public function deleterembug($id)
        {
            $rembugdata = Meeting::find($id);
    
            if(!$rembugdata)
            {
                return response([
                    'message' => 'Not Found'
                ], 403);
            }
    
            if($rembugdata->id_user != auth()->user()->id)
            {
                return response([
                    'message' => 'Kamu Tidak Memiliki Akses'
                ], 403);
            }
    
            $rembugdata->delete();
    
            return response([
                'message' => 'Berhasil Menghapus'
            ], 200);
        }

        public function getallrembug()
        {
            return response([
                'rembug' => Meeting::orderBy('created_at', 'desc')->with('users:id,name,image_user')->get(),
            ], 200);
        }
    
        // get single post
        public function getrembug($id_user)
        {
            return response([
                'workexpsuser' => Meeting::where('id_user', $id_user)->get()
            ], 200);
        }

        
}
