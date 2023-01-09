<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reportrembug extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'report_date',
        'id_post',
        'id_user_posts',
        'id_user'
    ];


    public function usersreport()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function usersposts()
    {
        return $this->belongsTo(User::class, 'id_user_posts', 'id');
    }
    public function posts()
    {
        return $this->belongsTo(Meeting::class, 'id_post', 'id');
    }
}
