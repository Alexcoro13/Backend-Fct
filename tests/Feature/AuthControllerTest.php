<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Usuario $usuario;
    protected $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->withMiddleware();

        $this->usuario = Usuario::factory()->create();

        $response = $this->postJson('/api/login', ['email' => $this->usuario->email, 'password' => 'usuario'], ['Accept' => 'application/json']);
        $this->token = $response->getCookie('laravel_token');
    }

    public function test_register_creates_a_new_user()
    {
        $data = [
            'nombre' => 'Test User',
            'apellidos' => 'Test Apellidos',
            'email' => 'usera12@gmail.com',
            'password' => 'usuario',
            'nombre_usuario' => 'testuser123',
        ];

        $response = $this->postJson('/api/register', $data, ['Accept' => 'application/json']);

        $response->assertStatus(201);

        $this->assertDatabaseHas('usuarios', ['nombre' => 'Test User']);
    }

    public function test_login_returns_a_cookie()
    {
        $response = $this->postJson('/api/login', ['email' => $this->usuario->email, 'password' => 'usuario'], ['Accept' => 'application/json']);

        $response->assertCookie('laravel_token')
            ->assertStatus(200);

        $this->assertAuthenticated();
    }

    public function test_login_returns_invalid_credentials()
    {
        $response = $this->postJson('/api/login', ['email' => 'mailprueba@gmail.com', 'password' => 'usuario'], ['Accept' => 'application/json']);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthorized']);
    }

    public function test_logout_invalidates_the_token()
    {
        $response = $this->withCookie('laravel_token', $this->token)->getJson('/api/logout', ['Accept' => 'application/json']);

        $response->assertStatus(200)->assertJson(['message' => 'Successfully logged out']);
    }
}
