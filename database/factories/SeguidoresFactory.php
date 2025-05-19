<?php

namespace Database\Factories;

use App\Models\Seguidores;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SeguidoresFactory extends Factory
{
    protected $model = Seguidores::class;

    public function definition(): array
    {
        return [
            'id_seguidor' => Usuario::factory(),
            'id_seguido' => Usuario::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function forSeguidor($id_seguidor)
    {
        return $this->state([
            'id_seguidor' => $id_seguidor, // Usar id del seguidor pasado
        ]);
    }
    public function forSeguido($id_seguido)
    {
        return $this->state([
            'id_seguido' => $id_seguido, // Usar id del seguidor pasado
        ]);
    }
}
