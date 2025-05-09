<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\Entrenamiento;
use App\Models\Like;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LikeFactory extends Factory
{
    protected $model = Like::class;

    public function definition(): array
    {
        return [
            'id_usuario' => Usuario::factory(),
            'id_post' => Entrenamiento::factory(),
            'id_comentario' => Comentario::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function forIdUsuario($id_usuario)
    {
        return $this->state([
            'id_usuario' => $id_usuario,
        ]);
    }


    public function forIdPost($id_post)
    {
        return $this->state([
            'id_post' => $id_post,
        ]);
    }

    public function forIdComentario($id_comentario)
    {
        return $this->state([
            'id_comentario' => $id_comentario,
        ]);
    }
}
