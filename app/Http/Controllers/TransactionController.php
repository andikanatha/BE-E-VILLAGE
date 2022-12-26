<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function newtransaksi (Request $request){

        $validation =$request->validate([
            'trx_name'=>'required|string',
            'description'=>'required',
            'name_second_user' => 'required',
            'total_trx'=>'required'
        ]);

        $seconduserdata = User::where('username',$validation['name_second_user'])->get();

        if(!$seconduserdata)
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
            'id_user'=> auth()->user()->id,
        ]);
        
        $transaction = Transaction::Create([
            'trx_name'=>$validation['trx_name'],
            'status'=> "Dalam Proses",
            'description'=>$validation['description'],
            'total_trx'=>$validation['total_trx'],
            'id_user'=> auth()->user()->id,
        ]);


        if($transaction != null){
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
    public function gettransaksi ($id_user){
        return response([
            'DataTransaksi' => Transaction::where('id_user', $id_user)->get()
        ], 200);
    }
}
