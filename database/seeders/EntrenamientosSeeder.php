<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Entrenamiento;

class EntrenamientosSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener todos los usuarios existentes
        $usuarios = Usuario::all();

        foreach ($usuarios as $usuario) {
            // Crear 30 entrenamientos para cada usuario, asignando id_usuario
            Entrenamiento::factory()
                ->count(30)
                ->forUsuario($usuario->id)
                ->create();
        }
    }
}
