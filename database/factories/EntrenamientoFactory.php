<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrenamiento>
 */
class EntrenamientoFactory extends Factory
{
    public function definition(): array
    {
        $ejerciciosOpciones = [
            [
                [
                    "name" => "Barbell Full Squat",
                    "primaryMuscles" => ["quadriceps"],
                    "series" => [
                        ["peso" => 120, "repeticiones" => 6, "acabado" => false],
                        ["peso" => 130, "repeticiones" => 7, "acabado" => false],
                        ["peso" => 150, "repeticiones" => 3, "acabado" => false],
                        ["peso" => 160, "repeticiones" => 1, "acabado" => false],
                    ],
                    "image" => "Barbell_Full_Squat/0.jpg"
                ],
                [
                    "name" => "Cable Incline Pushdown",
                    "primaryMuscles" => ["lats"],
                    "series" => [
                        ["peso" => 30, "repeticiones" => 10, "acabado" => false],
                        ["peso" => 30, "repeticiones" => 8, "acabado" => false],
                        ["peso" => 30, "repeticiones" => 7, "acabado" => false],
                        ["peso" => 30, "repeticiones" => 6, "acabado" => false],
                    ],
                    "image" => "Cable_Incline_Pushdown/0.jpg"
                ],
            ],
            [
                [
                    "name" => "Around The Worlds",
                    "primaryMuscles" => ["chest"],
                    "series" => [
                        ["peso" => 20, "repeticiones" => 10, "acabado" => false],
                        ["peso" => 30, "repeticiones" => 15, "acabado" => false],
                        ["peso" => 40, "repeticiones" => 20, "acabado" => false],
                        ["peso" => 50, "repeticiones" => 10, "acabado" => false],
                    ],
                    "image" => "Around_The_Worlds/0.jpg"
                ],
                [
                    "name" => "Alternate Hammer Curl",
                    "primaryMuscles" => ["biceps"],
                    "series" => [
                        ["peso" => 15, "repeticiones" => 10, "acabado" => false],
                        ["peso" => 15, "repeticiones" => 8, "acabado" => false],
                        ["peso" => 9, "repeticiones" => 10, "acabado" => false],
                        ["peso" => 9, "repeticiones" => 8, "acabado" => false],
                    ],
                    "image" => "Alternate_Hammer_Curl/0.jpg"
                ],
                [
                    "name" => "Cable Incline Triceps Extension",
                    "primaryMuscles" => ["triceps"],
                    "series" => [
                        ["peso" => 22, "repeticiones" => 10, "acabado" => false],
                        ["peso" => 20, "repeticiones" => 10, "acabado" => false],
                        ["peso" => 18, "repeticiones" => 10, "acabado" => false],
                        ["peso" => 16, "repeticiones" => 10, "acabado" => false],
                    ],
                    "image" => "Cable_Incline_Triceps_Extension/0.jpg"
                ],
                [
                    "name" => "Alternating Cable Shoulder Press",
                    "primaryMuscles" => ["shoulders"],
                    "series" => [
                        ["peso" => 30, "repeticiones" => 10, "acabado" => false],
                        ["peso" => 30, "repeticiones" => 20, "acabado" => false],
                        ["peso" => 30, "repeticiones" => 8, "acabado" => false],
                    ],
                    "image" => "Alternating_Cable_Shoulder_Press/0.jpg"
                ],
            ],
        ];

        // Fecha aleatoria entre hoy y 30 de junio 2025
        $startDate = '2025-01-01 23:59:59';
        $endDate = '2025-06-12 23:59:59';

        return [
            'nombre' => fake()->randomElement(['Chest, Shoulders, Triceps', 'Legs, Back']),
            'ejercicios' => fake()->randomElement($ejerciciosOpciones),
            'descripcion' => fake()->sentence(),
            'duracion' => fake()->numberBetween(120, 3600),
            'id_usuario' => Usuario::factory(),
            'created_at' => fake()->dateTimeBetween($startDate, $endDate),
            'updated_at' => fake()->dateTimeBetween($startDate, $endDate),
        ];
    }

    public function forUsuario($usuarioId)
    {
        return $this->state([
            'id_usuario' => $usuarioId,
        ]);
    }
}
