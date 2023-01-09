<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requesttopup extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'status',
        'nominal',
        'seconduser',
        'topup_date',
        'description'
    ];


    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}
