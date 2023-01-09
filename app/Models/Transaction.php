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
        'trx_name',
        'status',
        'total_trx',
        'description',
        'id_user',
        'trx_date',
        'seconduser',
        'jenis',
        'datefor'
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
