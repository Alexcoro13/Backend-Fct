<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Usuario $usuario;
    protected string $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->withMiddleware();

        $this->usuario = Usuario::factory()->create();

        $response = $this->postJson('/api/login', ['email' => $this->usuario->email, 'password' => 'usuario'], ['Accept' => 'application/json']);
        $this->token = $response->getCookie('laravel_token');
    }

    public function test_index_returns_users_list()
    {
        $response = $this->getJson('/api/usuarios', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }

    public function test_show_returns_single_user()
    {
        $response = $this->getJson("/api/usuarios/{$this->usuario->id}", [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200)
            ->assertJson(['data' => ['id' => $this->usuario->id]]);
    }

    public function test_delete_removes_user()
    {
        $response = $this->deleteJson("/api/usuarios/{$this->usuario->id}", [], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('usuarios', ['id' => $this->usuario->id]);
    }
}

