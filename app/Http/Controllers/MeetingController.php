<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function newrembug(Request $request)
        {
            //validate fields
            $attrs = $request->validate([
                'deskripsi' => 'required|string',
                'image' => 'required|string'
            ]);
    
            $rembugdata = Meeting::create([
                'deskripsi' => $attrs['deskripsi'],
                'image' => $attrs['image'],
                'id_user' => auth()->user()->id
            ]);
    
    
            return response([
                'message' => 'Berhasil Upload.',
                'data' => $rembugdata,
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
                'workexps' => Meeting::orderBy('created_at', 'desc')->with('user:id,name')->get()
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
