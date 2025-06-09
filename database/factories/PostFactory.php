<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->title(),
            'texto' => fake()->realText(),
            'imagen' => fake()->optional(0.5)->randomElement([
                "https://picsum.photos/3000/1000",
                "https://picsum.photos/2500/1200",
                "https://picsum.photos/3200/800"
            ]),
            'id_usuario' => Usuario::factory(), // Esto creará un usuario automáticamente si no se pasa un id_usuario
        ];
    }

    /**
     * Personalizar el post para usar un id_usuario específico.
     */
    public function forUsuario($usuarioId)
    {
        return $this->state([
            'id_usuario' => $usuarioId, // Usar id del usuario pasado
        ]);
    }
}
