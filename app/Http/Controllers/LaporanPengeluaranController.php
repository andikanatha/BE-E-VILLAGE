<?php

namespace App\Http\Controllers;

use App\Models\LaporanPengeluaran;
use Illuminate\Http\Request;

class LaporanPengeluaranController extends Controller
{
    public function report(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'nominal' => 'required',
            'date' => 'required',
            'description' => 'required',
            'keperluan' => 'required'
        ]);

       
        $data = LaporanPengeluaran::create([
            'nominal' => $attrs['nominal'],
            'date' => $attrs['date'],
            'description' => $attrs['description'],
            'keperluan' => $attrs['keperluan'],
            'id_user' => auth()->user()->id
        ]);
       
        if ($data) {
            $saldosisa =auth()->user()->saldo - $attrs['nominal'];

            if ($saldosisa >= 0) {
                auth()->user()->update([
                    'saldo' => $saldosisa
                ]);
    
                return response([
                    'message' => 'Berhasil melakukan laporan.'
                ], 200);
            } else {
                return response([
                    'message' => 'Saldo Anda Tidak Cukup'
                ], 200);
            }
            
        } else {
            return response([
                'message' => 'Gagal melakukan laporan.'
            ], 200);
        }
        


        
    }

     
    public function getall (){
        return response([
            'Laporan' => LaporanPengeluaran::orderBy('date', 'desc')->with('users:id,name,image_user,username')->get()
        ], 200);
    }
}
