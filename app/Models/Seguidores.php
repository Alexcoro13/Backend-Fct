<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguidores extends Model
{
    use HasFactory;

    protected $table = 'seguidores';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_seguidor',
        'id_seguido',
    ];

}
