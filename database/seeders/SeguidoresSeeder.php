<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Seguidores;

class SeguidoresSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::all();

        if ($usuarios->count() < 2) {
            $this->command->info('Se necesitan al menos 2 usuarios para crear seguidores.');
            return;
        }

        foreach ($usuarios as $usuario) {
            // Cada usuario sigue entre 1 y 5 usuarios distintos
            $posiblesSeguidos = $usuarios->where('id', '!=', $usuario->id);

            $maxSeguidores = min(10, $posiblesSeguidos->count());
            $cantidadASeguir = rand(10, $maxSeguidores);

            $usuariosASeguir = $posiblesSeguidos->random($cantidadASeguir);

            foreach ($usuariosASeguir as $usuarioSeguido) {
                $existeRelacion = Seguidores::where('id_seguidor', $usuario->id)
                    ->where('id_seguido', $usuarioSeguido->id)
                    ->exists();

                if (!$existeRelacion) {
                    Seguidores::factory()
                        ->forSeguidor($usuario->id)
                        ->forSeguido($usuarioSeguido->id)
                        ->create();
                }
            }
        }
    }
}
