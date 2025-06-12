<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
            'titulo' => $randomPost['titulo'],
            'texto' => $randomPost['texto'],
            'imagen' => fake()->optional(0.2)->randomElement([
                "https://cdn.pixabay.com/photo/2017/08/07/14/02/man-2604149_1280.jpg",
                "https://cdn.pixabay.com/photo/2015/01/09/11/22/fitness-594143_1280.jpg",
                "https://cdn.pixabay.com/photo/2016/11/29/09/10/man-1868632_1280.jpg",
                "https://cdn.pixabay.com/photo/2016/11/22/22/24/adult-1850925_1280.jpg",
                "https://cdn.pixabay.com/photo/2016/03/31/03/23/fitness-1291997_1280.jpg",
                "https://cdn.pixabay.com/photo/2017/08/17/02/28/gym-2649824_1280.jpg",
                "https://cdn.pixabay.com/photo/2016/11/19/12/43/barbell-1839086_1280.jpg",
                "https://cdn.pixabay.com/photo/2016/11/29/09/11/fit-1868634_1280.jpg",
                "https://cdn.pixabay.com/photo/2016/11/22/22/25/abs-1850926_1280.jpg",
                "https://cdn.pixabay.com/photo/2020/04/09/16/35/fitness-5022191_1280.jpg",
                "https://cdn.pixabay.com/photo/2017/10/11/19/48/model-2842198_1280.jpg",
                "https://cdn.pixabay.com/photo/2017/08/02/16/06/people-2572265_1280.jpg",
                "https://cdn.pixabay.com/photo/2015/01/10/18/45/gym-595597_1280.jpg",
                "https://cdn.pixabay.com/photo/2023/03/12/16/10/man-7847245_1280.jpg",
                "https://cdn.pixabay.com/photo/2021/11/10/18/53/gym-6784623_1280.jpg",
                "https://cdn.pixabay.com/photo/2018/12/28/16/16/exercise-3899877_1280.jpg",
                "https://cdn.pixabay.com/photo/2015/11/16/01/21/kettlebell-1045067_1280.jpg",
                "https://cdn.pixabay.com/photo/2016/11/19/12/43/dark-1839088_1280.jpg"
            ]),
            'id_usuario' => Usuario::factory(),
        ];
    }

    /**
     * Personalizar el post para usar un id_usuario específico.
     */
    public function forUsuario($usuarioId)
    {
        return $this->state([
            'id_usuario' => $usuarioId, // Usar id del usuario pasado
        ]);
    }
}
