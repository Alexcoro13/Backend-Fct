<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicios extends Model
{
    protected $table = 'ejercicios';


    protected function casts(): array
    {
        return [
            'primaryMuscles' => 'array',
            'secondaryMuscles' => 'array',
            'instructions' => 'array',
            'images' => 'array',
        ];
    }
}
