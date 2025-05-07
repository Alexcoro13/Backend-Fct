<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Entrenamiento;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntrenamientoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Usuario $usuario;
    protected Entrenamiento $entrenamiento;
    protected String $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->usuario = Usuario::factory()->create();
        $response = $this->postJson('/api/login', ['email' => $this->usuario->email, 'password' => 'usuario'], [
            'Accept' => 'application/json',
        ])->json();

        $this->token = explode("|", $response['access_token'])[1];

        $this->entrenamiento = Entrenamiento::factory()->create(['id_usuario' => $this->usuario->id]);
    }

    public function test_index_returns_all_entrenamientos()
    {
        $response = $this->getJson('/api/entrenamientos', ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => [['id', 'nombre', 'descripcion', 'duracion', 'id_usuario']]]);
    }

    public function test_store_creates_a_new_entrenamiento()
    {
        $data = [
            'nombre' => 'Entrenamiento 1',
            'descripcion' => 'Descripción del entrenamiento',
            'ejercicios' => ['ejercicio1', 'ejercicio2'],
            'duracion' => 60,
            'id_usuario' => $this->usuario->id,
        ];

        $response = $this->postJson('/api/entrenamientos', $data,
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Entrenamiento created successfully']);
        $this->assertDatabaseHas('entrenamientos', ['nombre' => 'Entrenamiento 1']);
    }

    public function test_show_returns_a_specific_entrenamiento()
    {
        $response = $this->getJson("/api/entrenamientos/{$this->entrenamiento->id}", ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['id' => $this->entrenamiento->id]]);
    }

    public function test_update_modifies_an_existing_entrenamiento()
    {
        $data = [
            'nombre' => 'Entrenamiento Actualizado',
            'descripcion' => 'Nueva descripción',
            'ejercicios' => ['ejercicio3'],
            'duracion' => 90,
        ];

        $response = $this->putJson("/api/entrenamientos/{$this->entrenamiento->id}", $data,
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Entrenamiento updated successfully']);
        $this->assertDatabaseHas('entrenamientos', ['nombre' => 'Entrenamiento Actualizado']);
    }

    public function test_destroy_deletes_an_entrenamiento()
    {
        $response = $this->deleteJson("/api/entrenamientos/{$this->entrenamiento->id}", [],
            ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Entrenamiento deleted successfully']);
        $this->assertDatabaseMissing('entrenamientos', ['id' => $this->entrenamiento->id]);
    }
}
