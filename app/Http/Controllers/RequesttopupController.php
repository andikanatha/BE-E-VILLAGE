<?php

namespace App\Http\Controllers;

use App\Models\requesttopup;
use App\Models\User;
use Illuminate\Http\Request;

class RequesttopupController extends Controller
{
    public function requesttopup (Request $request){

        $validation =$request->validate([
            'nominal'=>'required',
            'description'=>'required',
            'topup_date'=>'required',
        ]);

        $seconduseradmindata =User::where('akses','admin')->get();

        if(!$seconduseradmindata)
        {
            return response([
                'message' => 'User Tidak Ditemukan.'
            ], 200);
        }

    
        
        $transaction = requesttopup::Create([
            'status'=> "Menuggu persetujuan",
            'description'=>$validation['description'],
            'nominal'=>$validation['nominal'],
            'topup_date' => $validation['topup_date'],
            'id_user'=> auth()->user()->id,
            'seconduser' => $seconduseradmindata[0]->id,
        ]);

        return response([
            'massage' => "Request Berhasil",
            'Transaction' => $transaction,
        ]);

    }
    public function konfirmtopup ($id){

        $topup = requesttopup::find($id);
        $seconduseradmindata =User::where('akses','admin')->get();
        $user = User::where('id', $topup->id_user)->get();

        if(!$topup)
        {
            return response([
                'message' => 'Request not found.'
            ], 403);
        }

        if($topup->seconduser !=  $seconduseradmindata[0]->id)
        {
            return response([
                'message' => 'Permission denied.'
            ], 403);
        }

        if($topup->status =="Telah Dikonfirmasi" ){
            return response([
                'message' => 'Telah dikonfirmasi sebelumnya'
            ], 200);
        }
        else{
        $update = $topup->update([
            'status' => "Telah Dikonfirmasi"
        ]);
        
         $nominal = $topup->nominal;
         $saldouser =  $user[0]->saldo;
         $newsaldo = $saldouser+$nominal;

        if($update != null){
            $user[0]->update([
               'saldo' => $newsaldo
            ]);
            return response([
                'message' => 'Berhasil konfirmasi topup saldo'
            ], 200);
        }}
       

    }


    public function getlisttopup (){
        return response([
            'DataTransaksi' => requesttopup::where('id_user', auth()->user()->id)->orderby('topup_date', 'DESC')->get()
        ], 200);
    }
    public function getlisttopupberhasil (){
        return response([
            'DataTransaksi' => requesttopup::where('status', "Telah Dikonfirmasi")->orderby('topup_date', 'DESC')->with('users:id,name,image_user,username')->get()
        ], 200);
    }
    public function getlisttopupbelumdikonfirm (){
        return response([
            'DataTransaksi' => requesttopup::where('status', "Menuggu persetujuan")->orderby('topup_date', 'DESC')->with('users:id,name,image_user,username')->get()
        ], 200);
    }
}
