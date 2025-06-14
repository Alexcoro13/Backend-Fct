<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->Firstname(),
            'apellidos' => fake()->lastName(),
            'nombre_usuario' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('usuario'),
            'estado' => true,
            'visibilidad' => true,
            'remember_token' => Str::random(10),
            'avatar' => fake()->randomElement(
                [
                    'https://cdn.pixabay.com/photo/2019/11/29/21/30/girl-4662159_1280.jpg',
                    'https://cdn.pixabay.com/photo/2019/08/06/08/18/man-4387681_1280.jpg',
                    'https://cdn.pixabay.com/photo/2019/08/06/08/16/man-4387677_1280.jpg',
                    'https://cdn.pixabay.com/photo/2019/08/06/08/16/man-4387677_1280.jpg',
                    'https://cdn.pixabay.com/photo/2022/11/07/09/37/portuguese-man-o-war-7576019_1280.jpg',
                    'https://cdn.pixabay.com/photo/2020/03/13/07/45/aspiration-4927227_1280.jpg',
                    'https://cdn.pixabay.com/photo/2019/11/05/11/36/oldtimer-4603317_1280.jpg',
                    'https://cdn.pixabay.com/photo/2017/10/10/20/24/chevrolet-2838646_1280.jpg',
                    'https://cdn.pixabay.com/photo/2017/12/19/18/09/flowers-3028429_1280.jpg',
                    'https://cdn.pixabay.com/photo/2020/04/25/23/29/plans-5093012_1280.jpg',
                    'https://cdn.pixabay.com/photo/2020/04/28/15/16/sun-5105003_1280.jpg',
                    'https://cdn.pixabay.com/photo/2018/03/15/09/27/moscow-3227572_1280.jpg',
                    'https://cdn.pixabay.com/photo/2020/06/15/04/48/plane-5300325_1280.jpg',
                    'https://cdn.pixabay.com/photo/2017/06/10/11/30/bird-2389719_1280.jpg',
                    'https://cdn.pixabay.com/photo/2016/06/21/23/25/sunset-1472221_1280.jpg',
                    'https://cdn.pixabay.com/photo/2019/11/03/09/35/cockpit-4598188_1280.jpg',
                    'https://cdn.pixabay.com/photo/2012/10/10/05/07/combat-diver-60545_1280.jpg',
                    'https://cdn.pixabay.com/photo/2017/02/12/09/45/sh-60b-seahawk-2059611_1280.jpg',
                    'https://cdn.pixabay.com/photo/2022/08/16/19/10/oamtc-7390990_1280.jpg',
                    'https://cdn.pixabay.com/photo/2021/09/13/19/07/helicopter-6622214_1280.jpg',
                    'https://cdn.pixabay.com/photo/2010/12/06/22/helicopter-1003_1280.jpg'
                ]
            ),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
