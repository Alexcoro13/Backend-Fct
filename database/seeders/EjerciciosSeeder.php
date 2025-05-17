<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Exception;

class EjerciciosSeeder extends Seeder
{
    public function run(): void
    {
        $json_file = database_path('seeders/data/Exercises.json');

        try {
            // Leer el archivo JSON
            $content = file_get_contents($json_file);
            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
            }

            $total_rows = count($data['rows']);
            $this->command->info("Total de filas en el JSON: {$total_rows}");
            $inserted = 0;
            $errors = 0;

            // Usando un bucle for en lugar de foreach
            for ($i = 0; $i < $total_rows; $i++) {
                try {
                    $row = $data['rows'][$i];

                    if (!isset($row[1]) || !isset($row[3]) || !isset($row[9])) {
                        throw new Exception("Fila {$i} incompleta o mal formada");
                    }

                    DB::table('ejercicios')->insert([
                        'name' => $row[1],
                        'force' => $row[2],
                        'level' => $row[3],
                        'mechanic' => $row[4],
                        'equipment' => $row[5],
                        'primaryMuscles' => $row[6],
                        'secondaryMuscles' => $row[7],
                        'instructions' => $row[8],
                        'category' => $row[9],
                        'images' => $row[10]
                    ]);
                    $inserted++;

                    // Si estamos en las últimas 100 filas, mostramos información
                    if ($i >= $total_rows - 100) {
                        $this->command->info("Insertada fila {$i}: {$row[1]}");
                    }
                } catch (Exception $e) {
                    $errors++;
                    $this->command->error("Error en la fila {$i}: " . $e->getMessage());
                    $this->command->error("Datos de la fila: " . json_encode($row));
                }
            }

            $this->command->info("Total de filas en JSON: {$total_rows}");
            $this->command->info("Ejercicios insertados: {$inserted}");
            $this->command->info("Errores encontrados: {$errors}");

        } catch (Exception $e) {
            $this->command->error('Error al importar ejercicios: ' . $e->getMessage());
        }
    }
}
