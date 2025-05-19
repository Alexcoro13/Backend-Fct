<?php

namespace Tests\Feature;

use App\Models\Seguidores;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeguidoresControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Usuario $usuario;
    protected Usuario $usuarioASeguir;
    protected string $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->withMiddleware();

        // Crear usuarios de prueba
        $this->usuario = Usuario::factory()->create();
        $this->usuarioASeguir = Usuario::factory()->create();

        // Obtener token de autenticación
        $response = $this->postJson('/api/login', [
            'email' => $this->usuario->email,
            'password' => 'usuario'
        ], ['Accept' => 'application/json']);

        $this->token = $response->getCookie('laravel_token');
    }

    public function test_store_creates_new_seguidor()
    {
        $data = [
            'id_seguido' => $this->usuarioASeguir->id
        ];

        $response = $this->withCookie('laravel_token', $this->token)
            ->postJson('/api/seguidores', $data, ['Accept' => 'application/json']);

        $response->assertStatus(201);

        $this->assertDatabaseHas('seguidores', [
            'id_seguidor' => $this->usuario->id,
            'id_seguido' => $this->usuarioASeguir->id
        ]);
    }

    public function test_destroy_removes_seguidor()
    {
        // Crear un seguidor primero
        $seguidor = Seguidores::factory()->create([
            'id_seguidor' => $this->usuario->id,
            'id_seguido' => $this->usuarioASeguir->id
        ]);

        $response = $this->withCookie('laravel_token', $this->token)
            ->deleteJson("/api/seguidores/{$seguidor->id}", [], ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('seguidores', ['id' => $seguidor->id]);
    }

    public function test_get_seguidores_by_usuario()
    {
        // Crear algunos seguidores para el usuario
        Seguidores::factory()->count(3)->create([
            'id_seguido' => $this->usuario->id
        ]);

        $response = $this->withCookie('laravel_token', $this->token)
            ->getJson("/api/seguidores/{$this->usuario->id}", ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(3, 'data');
    }

    public function test_get_seguidos_by_usuario()
    {
        // Crear algunos usuarios que el usuario sigue
        Seguidores::factory()->count(3)->create([
            'id_seguidor' => $this->usuario->id
        ]);

        $response = $this->withCookie('laravel_token', $this->token)
            ->getJson("/api/seguidores/seguidos/{$this->usuario->id}", ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(3, 'data');
    }

    public function test_usuario_no_puede_seguirse_a_si_mismo()
    {
        $data = [
            'id_seguido' => $this->usuario->id
        ];

        $response = $this->withCookie('laravel_token', $this->token)
            ->postJson('/api/seguidores', $data, ['Accept' => 'application/json']);

        $response->assertStatus(409)
            ->assertJson(['message' => 'You cannot follow yourself']);
    }

    public function test_usuario_no_puede_seguir_dos_veces()
    {
        // Crear el seguidor primero
        Seguidores::factory()->create([
            'id_seguidor' => $this->usuario->id,
            'id_seguido' => $this->usuarioASeguir->id
        ]);

        $data = [
            'id_seguido' => $this->usuarioASeguir->id
        ];

        $response = $this->withCookie('laravel_token', $this->token)
            ->postJson('/api/seguidores', $data, ['Accept' => 'application/json']);

        $response2 = $this->withCookie('laravel_token', $this->token)
            ->postJson('/api/seguidores', $data, ['Accept' => 'application/json']);

        $response2->assertStatus(409)
            ->assertJson(['message' => 'You are already following this user']);
    }


    public function test_check_if_usuario_follows_otro()
    {
        Seguidores::factory()->create([
            'id_seguidor' => $this->usuario->id,
            'id_seguido' => $this->usuarioASeguir->id
        ]);

        $response = $this->withCookie('laravel_token', $this->token)
            ->getJson("/api/seguidores/verificarSeguido/{$this->usuarioASeguir->id}", ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJson(['seguido' => true]);
    }
}
