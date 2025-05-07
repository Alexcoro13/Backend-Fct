<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrenamiento>
 */

class EntrenamientoFactory extends Factory{
    /*
     *
     */
    public function definition(): array{
        return [
            'nombre' => fake()->word(),
            'ejercicios' => ['ejercicio1', 'ejercicio2', 'ejercicio3'],
            'descripcion' => fake()->sentence(),
            'duracion' => fake()->numberBetween(10, 120),
            'id_usuario' => Usuario::factory()// Esto creará un usuario automáticamente si no se pasa un id_usuario
        ];
    }

    /**
     * Personalizar el entrenamiento para usar un id_usuario específico.
     */
    public function forUsuario($usuarioId)
    {
        return $this->state([
            'id_usuario' => $usuarioId, // Usar id del usuario pasado
        ]);
    }
}
