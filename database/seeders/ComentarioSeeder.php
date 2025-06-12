<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comentario;
use App\Models\Post;
use App\Models\Usuario;

class ComentarioSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::all();
        $posts = Post::all();

        if ($usuarios->isEmpty() || $posts->isEmpty()) {
            $this->command->info('No hay usuarios o posts para crear comentarios.');
            return;
        }

        foreach ($posts as $post) {
            // Crear entre 1 y 30 comentarios por post
            $cantidadComentarios = rand(5, 30);

            for ($i = 0; $i < $cantidadComentarios; $i++) {
                // Elegir usuario aleatorio para el comentario
                $usuario = $usuarios->random();

                Comentario::factory()
                    ->forPost($post->id)
                    ->forUsuario($usuario->id)
                    ->create();
            }
        }
    }
}
