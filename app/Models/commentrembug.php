<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commentrembug extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'comment',
        'commentdate',
        'id_post'
    ];


    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
