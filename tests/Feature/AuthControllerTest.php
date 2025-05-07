<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Usuario $usuario;
    protected string $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->withMiddleware();

        $this->usuario = Usuario::factory()->create();

        $response = $this->postJson('/api/login', ['email' => $this->usuario->email, 'password' => 'usuario'], [
            'Accept' => 'application/json',
        ])->json();

        $this->token = explode("|", $response['access_token'])[1];
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

    public function test_login_returns_a_token()
    {
        $response = $this->postJson('/api/login', ['email' => $this->usuario->email, 'password' => 'usuario'], ['Accept' => 'application/json']);

        $this->token = explode("|", $response->json()['access_token'])[1];


        $response->assertStatus(200)->assertJsonStructure(['access_token', 'token_type', 'user']);
        $response->assertJson(['token_type' => 'Bearer']);

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
        $response = $this->getJson('/api/logout', ['Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)->assertJson(['message' => 'Successfully logged out']);
    }
}
