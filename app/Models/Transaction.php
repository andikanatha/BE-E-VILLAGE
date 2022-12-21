<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\CodeCleaner\ReturnTypePass;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_transaksi',
        'catatan',
        'total_transaksi',
        'id_user'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
