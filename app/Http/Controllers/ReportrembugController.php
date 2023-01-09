<?php

namespace App\Http\Controllers;

use App\Models\reportrembug;
use Illuminate\Http\Request;

class ReportrembugController extends Controller
{
    public function reportrembug(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'deskripsi' => 'required|string',
            'id_post' => 'required',
            'id_user_posts' => 'required',
            'report_date' => 'required'
        ]);

       
        $data = reportrembug::create([
            'description' => $attrs['deskripsi'],
            'report_date' => $attrs['report_date'],
            'id_post' => $attrs['id_post'],
            'id_user_posts' => $attrs['id_user_posts'],
            'id_user' => auth()->user()->id
        ]);
       


        return response([
            'message' => 'Berhasil melakukan report.'
        ], 200);
    }

     
    public function getall (){
        return response([
            'Laporan' => reportrembug::orderBy('report_date', 'desc')->with('posts:image,id,created_date,deskripsi','usersreport:id,name,image_user,username','usersposts:id,name,image_user,username')->get()
        ], 200);
    }
}
