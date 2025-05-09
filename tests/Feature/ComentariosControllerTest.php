<?php

namespace Tests\Feature;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComentariosControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Usuario $usuarioPost;
    protected Usuario $usuarioComentario;
    protected Post $post;
    protected Comentario $comentario;
    protected String $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->usuarioPost = Usuario::factory()->create();

        $response = $this->postJson('/api/login', ['email' => $this->usuarioPost->email, 'password' => 'usuario'], ["Accept" => 'application/json',])->json();

        $this->token = explode("|", $response['access_token'])[1];

        $this->usuarioComentario = Usuario::factory()->create();

        $this->post = Post::factory()->create([
            'id_usuario' => $this->usuarioPost->id,
        ]);

        $this->comentario = Comentario::factory()->create([
            'id_post' => $this->post->id,
            'id_usuario' => $this->usuarioComentario->id,
        ]);
    }

    public function test_index_returns_all_comentarios(){
        $response = $this->getJson('/api/comentarios', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => [['id', 'texto', 'id_post', 'id_usuario']]]);
    }

    public function test_store_creates_a_new_comentario(){
        $data = [
            'texto' => 'Comentario de prueba',
            'id_post' => $this->post->id,
            'id_usuario' => $this->usuarioComentario->id,
        ];

        $response = $this->postJson('/api/comentarios', $data, [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Comment created successfully']);

        $this->assertDatabaseHas('comentarios', ['texto' => 'Comentario de prueba']);
    }

    public function test_show_returns_a_specific_comentario(){
        $response = $this->getJson("/api/comentarios/{$this->comentario->id}", [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['data' => ['id' => $this->comentario->id]]);
    }

    public function test_update_modifies_an_existing_comentario(){
        $data = [
            'texto' => 'Comentario actualizado',
            'id_post' => $this->post->id
        ];

        $response = $this->putJson("/api/comentarios/{$this->comentario->id}", $data, [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Comment updated successfully']);

        $this->assertDatabaseHas('comentarios', ['texto' => 'Comentario actualizado']);
    }

    public function test_destroy_deletes_a_comentario(){
        $response = $this->deleteJson("/api/comentarios/{$this->comentario->id}", [], [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Comment deleted successfully']);
    }

    public function test_get_post_comments()
    {
        $response = $this->getJson("/api/comentarios/posts/{$this->post->id}", [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => [['id', 'texto', 'id_post', 'id_usuario']]]);
    }
}
