<?php

namespace App\Http\Controllers;

use App\Models\ReportVillageHead;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class ReportVillageHeadController extends Controller
{
    public function report(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'deskripsi' => 'required|string',
            'tempat_kejadian' => 'required|string',
            'created_date' => 'required'
        ]);


        $image = $this->saveImage($request->image, 'laporasset');

       if($request->image != ""){
            $rembugdata = ReportVillageHead::create([
                'image' => "$image",
                'deskripsi' => $attrs['deskripsi'],
                'created_date' => $attrs['created_date'],
                'tempat_kejadian' => $attrs['tempat_kejadian'],
                'id_user' => auth()->user()->id
            ]);
       } else{
        $rembugdata = ReportVillageHead::create([
            'deskripsi' => $attrs['deskripsi'],
            'created_date' => $attrs['created_date'],
            'tempat_kejadian' => $attrs['tempat_kejadian'],
            'id_user' => auth()->user()->id
        ]);
       }


        return response([
            'message' => 'Berhasil Upload.',
            'data' => $rembugdata,
            'users' => $rembugdata->id_user
        ], 200);
    }

    public function getreportuser ($id_user){
        return response([
            'DataTransaksi' => ReportVillageHead::where('id_user', $id_user)->get()
        ], 200);
    }
     
    public function getall (){
        return response([
            'Laporan' => ReportVillageHead::all()->orderBy('created_at', 'desc')->with('users:id,name,image_user,username')->get()
        ], 200);
    }
}
