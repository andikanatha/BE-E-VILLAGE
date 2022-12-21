<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'deskripsi',
        'image',
        'id_user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
