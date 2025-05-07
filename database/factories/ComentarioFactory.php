<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Post;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'texto' => fake()->sentence(),
            'id_post' => Post::factory(),
            'id_usuario' => Usuario::factory(),
        ];
    }

    /**
     * Personalizar el comentario para usar un id_post específico.
     */
    public function forPost($postId)
    {
        return $this->state([
            'id_post' => $postId, // Usar id del post pasado
        ]);
    }

    /**
     * Personalizar el comentario para usar un id_usuario específico.
     */
    public function forUsuario($usuarioId)
    {
        return $this->state([
            'id_usuario' => $usuarioId, // Usar id del usuario pasado
        ]);
    }
}
