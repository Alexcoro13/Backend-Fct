<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;
use App\Models\Post;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    protected static array $postData = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        if (!self::$postData) {
            $json = file_get_contents(database_path('seeders/data/posts.json'));
            $data = json_decode($json, true);
            self::$postData = $data['posts'];
        }

        // Seleccionar uno aleatorio
        $randomPost = fake()->randomElement(self::$postData);

        return [
            'texto' => $randomPost['texto'],
            'id_post' => Post::factory(),
            'id_usuario' => Usuario::factory(),
        ];
    }

    /**
     * Personalizar el comentario para usar un id_post específico.
     */
    public function forPost($postId)
    {
        return $this->state([
            'id_post' => $postId, // Usar id del post pasado
        ]);
    }

    /**
     * Personalizar el comentario para usar un id_usuario específico.
     */
    public function forUsuario($usuarioId)
    {
        return $this->state([
            'id_usuario' => $usuarioId, // Usar id del usuario pasado
        ]);
    }
}
