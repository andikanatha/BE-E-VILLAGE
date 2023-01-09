<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Egulias\EmailValidator\Parser\Comment;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        'deskripsi',
        'image',
        'created_date',
        'id_user'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }


    public function comments()
    {
        return $this->hasMany(commentrembug::class, 'id_post', 'id');
    }

    
}
