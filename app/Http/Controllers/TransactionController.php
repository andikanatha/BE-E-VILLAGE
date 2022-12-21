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
            'nama_transaksi'=>'required|string',
            'catatan'=>'required|string',
            'total_transaksi'=>'required'
        ]);

        $transaction = Transaction::Create([
            'nama_transaksi'=>$validation['nama_transaksi'],
            'catatan'=>$validation['catatan'],
            'total_transaksi'=>$validation['total_transaksi'],
            'id_user'=> auth()->user()->id,
        ]);

        $sisasaldo = auth()->user()->saldo-$validation['total_transaksi'];
        auth()->user()->update([
            'saldo' => $sisasaldo,
        ]);

        return response([
            'user' => $transaction,
        ]);
    }
    public function gettransaksi ($id_user){
        return response([
            'workexpsuser' => Transaction::where('id_user', $id_user)->get()
        ], 200);
    }
}
