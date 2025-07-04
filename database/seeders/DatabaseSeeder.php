<?php

namespace Database\Seeders;

use App\Models\Usuario;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario::factory(10)->create();
        $this->call([
            EjerciciosSeeder::class,
            PostsSeeder::class,
            ComentarioSeeder::class,
            LikeSeeder::class,
            SeguidoresSeeder::class,
            EntrenamientosSeeder::class
        ]);
    }
}
