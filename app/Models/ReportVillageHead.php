<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportVillageHead extends Model
{
    use HasFactory;
    protected $fillable = [
        'tempat_kejadian',
        'deskripsi',
        'image',
        'tempat_kejadian',
        'id_user',
        'created_date'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
