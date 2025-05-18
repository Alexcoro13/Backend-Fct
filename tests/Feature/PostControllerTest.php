<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Usuario $usuario;
    protected Post $post;
    protected string $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->withMiddleware();

        // Crear usuario y obtener token
        $this->usuario = Usuario::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $this->usuario->email,
            'password' => 'usuario'
        ]);
        $this->token = explode('|', $response->json()['access_token'])[1];

        // Crear post de prueba
        $this->post = Post::factory()->create([
            'id_usuario' => $this->usuario->id
        ]);
    }

    public function test_index_returns_all_posts()
    {
        $response = $this->getJson('/api/posts', [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['data', 'message']);
    }

    public function test_show_returns_specific_post()
    {
        $response = $this->getJson("/api/posts/{$this->post->id}", [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['data', 'message'])
                ->assertJson(['data' => ['id' => $this->post->id]]);
    }

    public function test_show_returns_404_for_nonexistent_post()
    {
        $response = $this->getJson('/api/posts/99999', [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(404)
                ->assertJsonStructure(['message', 'error']);
    }

    public function test_store_creates_new_post()
    {
        $postData = [
            'titulo' => 'Nuevo Post de Prueba',
            'texto' => 'Contenido del post de prueba',
            'imagen' => 'ruta/imagen.jpg'
        ];

        $response = $this->postJson('/api/posts', $postData, [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('post', [
            'titulo' => 'Nuevo Post de Prueba',
            'id_usuario' => $this->usuario->id
        ]);
    }

    public function test_update_modifies_existing_post()
    {
        $updateData = [
            'titulo' => 'Título Actualizado',
            'texto' => 'Contenido actualizado',
            'imagen' => 'nueva/ruta/imagen.jpg'
        ];

        $response = $this->putJson("/api/posts/{$this->post->id}", $updateData, [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Post updated successfully']);

        $this->assertDatabaseHas('post', [
            'id' => $this->post->id,
            'titulo' => 'Título Actualizado'
        ]);
    }

    public function test_destroy_deletes_post()
    {
        $response = $this->deleteJson("/api/posts/{$this->post->id}", [], [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Post deleted successfully']);

        $this->assertDatabaseMissing('post', ['id' => $this->post->id]);
    }

    public function test_get_latest_posts_returns_random_posts()
    {
        // Crear varios posts adicionales
        Post::factory(30)->create();

        $response = $this->getJson('/api/posts/latest/20', [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure(['data', 'message']);

        $this->assertEquals(20, count($response->json()['data']));
    }
}
