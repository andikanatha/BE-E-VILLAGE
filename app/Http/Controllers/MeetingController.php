<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\reportrembug;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function newrembug(Request $request)
        {
            //validate fields
            $attrs = $request->validate([
                'deskripsi' => 'required|string',
                'created_date' => 'required'
            ]);


            $image = $this->saveImage($request->image, 'rembugpost');
    
           if($request->image != ""){
                $rembugdata = Meeting::create([
                    'image' => "$image",
                    'deskripsi' => $attrs['deskripsi'],
                    'created_date' => $attrs['created_date'],
                    'id_user' => auth()->user()->id
                ]);
           } else{
            $rembugdata = Meeting::create([
                'deskripsi' => $attrs['deskripsi'],
                'created_date' => $attrs['created_date'],
                'id_user' => auth()->user()->id
            ]);
           }
    
    
            return response([
                'message' => 'Berhasil Upload.',
                'data' => $rembugdata,
                'users' => $rembugdata->id_user
            ], 200);
        }
    public function update(Request $request, $id)
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

            //validate fields
            $attrs = $request->validate([
                'deskripsi' => 'required|string',
            ]);


            $image = $this->saveImage($request->image, 'rembugpost');
    
           if($request->image != ""){
                $rembugdata->update([
                    'image' => "$image",
                    'deskripsi' => $attrs['deskripsi'],
                   
                ]);
           } else{
            $rembugdata->update([
                'deskripsi' => $attrs['deskripsi'],
           
            ]);
           }
    
    
            return response([
                'message' => 'Berhasil Update.',
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
        public function deleterembugbyadmin($id)
        {
            $rembugdata = Meeting::find($id);
           reportrembug::where('id_post',$id)->delete();
    
            if(!$rembugdata)
            {
                return response([
                    'message' => 'Not Found'
                ], 403);
            }
        
            if(auth()->user()->akses != "admin")
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
                'rembug' => Meeting::orderBy('created_at', 'desc')->with('users:id,name,image_user,username')->withCount('comments')->get(),
            ], 200);
        }

        public function getrembugusers()
        {
            return response([
                'rembug' => Meeting::where('id_user', auth()->user()->id)->orderBy('created_at', 'desc')->with('users:id,name,image_user,username')->withCount('comments')->get(),
            ], 200);
        }
    
        // get single post
        public function getrembug($date)
        {
            return response([
                'data' => Meeting::where('created_date', $date)->get()
            ], 200);
        }      

        
}
