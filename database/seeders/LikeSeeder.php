<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Like;
use App\Models\Usuario;
use App\Models\Post;
use App\Models\Comentario;

class LikeSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::all();
        $posts = Post::all();
        $comentarios = Comentario::all();

        if ($usuarios->isEmpty()) {
            $this->command->info('No hay usuarios para crear likes.');
            return;
        }

        // Likes para posts
        if ($posts->isNotEmpty()) {
            foreach ($usuarios as $usuario) {
                $maxLikes = min(20, $posts->count());
                $likesCount = rand(1, $maxLikes);
                $postsAleatorios = $posts->random($likesCount);

                foreach ($postsAleatorios as $post) {
                    $likeExistente = Like::where('id_usuario', $usuario->id)
                        ->where('id_post', $post->id)
                        ->first();

                    if (!$likeExistente) {
                        Like::factory()
                            ->forIdUsuario($usuario->id)
                            ->forIdPost($post->id)
                            ->forIdComentario(null)
                            ->create();
                    }
                }
            }
        }

        // Likes para comentarios
        if ($comentarios->isNotEmpty()) {
            foreach ($usuarios as $usuario) {
                $maxLikes = min(20, $comentarios->count());
                $likesCount = rand(1, $maxLikes);
                $comentariosAleatorios = $comentarios->random($likesCount);

                foreach ($comentariosAleatorios as $comentario) {
                    $likeExistente = Like::where('id_usuario', $usuario->id)
                        ->where('id_comentario', $comentario->id)
                        ->first();

                    if (!$likeExistente) {
                        Like::factory()
                            ->forIdUsuario($usuario->id)
                            ->forIdComentario($comentario->id)
                            ->forIdPost(null)
                            ->create();
                    }
                }
            }
        }
    }
}
