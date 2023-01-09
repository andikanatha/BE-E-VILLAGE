<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nominal',
        'date',
        'id_user',
        'description',
        'keperluan'
    ];


    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
