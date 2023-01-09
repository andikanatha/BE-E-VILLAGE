<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class TransactionController extends Controller
{
    public function newtransaksi (Request $request){

        $validation =$request->validate([
            'name_second_user' => 'required',
            'description'=>'required',
            'total_trx'=>'required',
            'trx_date'=>'required',
        ]);

        $seconduserdata = User::where('username',$validation['name_second_user'])->get();

       

        if(!$seconduserdata)
        {
            return response([
                'message' => 'User Tidak Ditemukan.'
            ], 403);
        }

    
        
        else{
            $transaction = Transaction::Create([
                'trx_name'=>"Transfer",
                'status'=> "Dalam Proses",
                'description'=>$validation['description'],
                'total_trx'=>$validation['total_trx'],
                'trx_date' => $validation['trx_date'],
                'id_user'=> auth()->user()->id,
                'seconduser' => $seconduserdata[0]->id,
                'jenis' => "transfer"
            ]);
    
    
            if($transaction != null){
                if($seconduserdata[0]->username != auth()->user()->username){
                if(auth()->user()->saldo >= $validation['total_trx']){
                    
                    $sisasaldo = auth()->user()->saldo-$validation['total_trx'];
                    if($sisasaldo > -1){
                        $updateusersaldo = auth()->user()->update([
                            'saldo' => $sisasaldo,
                        ]);
                        if($updateusersaldo != null){
    
                            
                                $sisasaldoseconduser = $seconduserdata[0]->saldo + $validation['total_trx'];
                                $updateseconduser = $seconduserdata[0]->update([
                                    'saldo' => $sisasaldoseconduser
                                ]);
    
                                if($updateseconduser != null){
                                    $transaction->update([
                                        'status'=> "Berhasil",
                                    ]);
                                    return response([
                                        'massage' => "Transaksi Berhasil",
                                        'Transaction' => $transaction,
                                    ]);
                                }
                            
    
                            
                        }
                    }else{
                        $transaction->update([
                            'status'=> "Gagal",
                        ]);
                        return response([
                            'massage' => "Transaksi Gagal",
                            'Transaction' => $transaction,
                        ]);
                    }
                    
                }else{
                    $transaction->update([
                        'status'=> "Gagal",
                    ]);
                    return response([
                        'massage' => "Saldo Tidak Mencukupi",
                        'Transaction' => $transaction,
                    ]);
                }
            }
            
    
            else{
                $transaction->update([
                    'status'=> "Gagal",
                ]);
                return response([
                    'massage' => "Transaksi Gagal",
                    'Transaction' => $transaction,
                ]);
            }
        }
            else{
                $transaction->update([
                    'status'=> "Gagal",
                ]);
                return response([
                    'massage' => "Transaksi Gagal",
                    'Transaction' => $transaction,
                ]);
            }
    
        }
      

        
    }
    public function pembayaran (Request $request){

        $validation =$request->validate([
            'trx_name'=>'required|string',
            'description'=>'required',
            'total_trx'=>'required',
            'trx_date'=>'required',
            'datefor'=>'required'
        ]);

        $seconduseradmindata =User::where('akses','admin')->get();

        if(!$seconduseradmindata)
        {
            return response([
                'message' => 'User Tidak Ditemukan.'
            ], 403);
        }

    
        
        $transaction = Transaction::Create([
            'trx_name'=>$validation['trx_name'],
            'status'=> "Dalam Proses",
            'description'=>$validation['description'],
            'total_trx'=>$validation['total_trx'],
            'trx_date' => $validation['trx_date'],
            'datefor' => $validation['datefor'],
            'id_user'=> auth()->user()->id,
            'seconduser' => $seconduseradmindata[0]->id,
            'jenis' => "pembayaran"
        ]);


        if($transaction != null){
            if($seconduseradmindata[0]->username != auth()->user()->username){
            if(auth()->user()->saldo >= $validation['total_trx']){
                
                $sisasaldo = auth()->user()->saldo-$validation['total_trx'];
                if($sisasaldo > -1){
                    $updateusersaldo = auth()->user()->update([
                        'saldo' => $sisasaldo,
                    ]);
                    if($updateusersaldo != null){

                        
                            $sisasaldoseconduser = $seconduseradmindata[0]->saldo + $validation['total_trx'];
                            $updateseconduser = $seconduseradmindata[0]->update([
                                'saldo' => $sisasaldoseconduser
                            ]);

                            if($updateseconduser != null){
                                $transaction->update([
                                    'status'=> "Berhasil",
                                ]);
                                return response([
                                    'massage' => "Transaksi Berhasil",
                                    'Transaction' => $transaction,
                                ]);
                            }
                        

                        
                    }
                }else{
                    $transaction->update([
                        'status'=> "Gagal",
                    ]);
                    return response([
                        'massage' => "Transaksi Gagal",
                        'Transaction' => $transaction,
                    ]);
                }
                
            }else{
                $transaction->update([
                    'status'=> "Gagal",
                ]);
                return response([
                    'massage' => "Saldo Tidak Mencukupi",
                    'Transaction' => $transaction,
                ]);
            }
        }
        

        else{
            $transaction->update([
                'status'=> "Gagal",
            ]);
            return response([
                'massage' => "Transaksi Gagal",
                'Transaction' => $transaction,
            ]);
        }
    }
        else{
            $transaction->update([
                'status'=> "Gagal",
            ]);
            return response([
                'massage' => "Transaksi Gagal",
                'Transaction' => $transaction,
            ]);
        }

      

        
    }
    public function gettransaksi (){
        return response([
            'DataTransaksi' => Transaction::where('id_user', auth()->user()->id)->orderby('trx_date', 'DESC')->get()
        ], 200);
    }
    public function searchpemabayaran ($query){
        return response([
            'DataTransaksi' => Transaction::where('trx_date', 'LIKE', "%{$query}%" )->where('id_user', auth()->user()->id)->orderby('trx_date', 'DESC')->get()
        ], 200);
    }
    public function searchpemasukan ($query){
        return response([
            'DataTransaksi' => Transaction::where('trx_date', 'LIKE', "%{$query}%" )->where('seconduser', auth()->user()->id)->orderby('trx_date', 'DESC')->get()
        ], 200);
    }
    public function gettransaksiall (){
        return response([
            'DataTransaksi' => Transaction::where('id_user', auth()->user()->id)->orderby('trx_date', 'DESC')->orWhere('seconduser', auth()->user()->id)->get()
        ], 200);
    }
    public function getpemasukan (){
        return response([
            'DataTransaksi' => Transaction::where('seconduser', auth()->user()->id)->orderby('trx_date', 'DESC')->get()
        ], 200);
    }
    public function getdetailtrx ($id){
        return response(
             Transaction::where('id', $id)->with('users:id,name,image_user,username')->first()
        , 200);
    }
    public function getsampah (){
        return response([
             Transaction::where('trx_name', "Pembayaran sampah")->with('users:id,name,image_user,username')->get()
        ], 200);
    }
    public function getpdam (){
        return response([
             Transaction::where('trx_name', "Pembayaran PDAM")->with('users:id,name,image_user,username')->get()
        ], 200);
    }
  
}
