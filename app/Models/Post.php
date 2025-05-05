<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $primaryKey = 'id';


    protected $fillable = [
        'titulo',
        'texto',
        'id_usuario',
        'imagen'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
