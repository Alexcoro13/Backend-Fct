<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
    use HasFactory;

    protected $table = 'entrenamientos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ejercicios',
        'descripcion',
        'duracion',
        'id_usuario',
    ];

    protected $casts = [
        'ejercicios' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
