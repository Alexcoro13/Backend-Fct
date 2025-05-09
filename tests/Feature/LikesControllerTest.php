<?php

namespace Tests\Feature;

use App\Models\Comentario;
use App\Models\Like;
use App\Models\Post;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikesControllerTest extends TestCase
{
    use RefreshDatabase;

    private Usuario $user;
    private Post $post;
    private Comentario $comment;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = Usuario::factory()->create();
        $this->post = Post::factory()->create();
        $this->comment = Comentario::factory()->create();
    }

    public function test_user_can_like_post(): void
    {
        $response = $this->actingAs($this->user)
            ->post("/api/likes", [
                'id_post' => $this->post->id,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', [
            'id_usuario' => $this->user->id,
            'id_post' => $this->post->id,
        ]);
    }

    public function test_user_can_unlike_post(): void
    {
        /** @var Like $like */

        $like = Like::factory()->create([
            'id_usuario' => $this->user->id,
            'id_post' => $this->post->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/api/likes/$like->id");

        $response->assertStatus(200);
        $this->assertNull(Like::find($like->id));
    }

    public function test_unauthenticated_user_cannot_like_post(): void
    {
        $response = $this->post("/api/likes", [
            'id_post' => $this->post->id,
        ],
        [
            'Accept' => 'application/json',
        ]
        );

        $response->assertStatus(401);
    }

    public function test_user_can_like_comment(): void
    {
        $response = $this->actingAs($this->user)
            ->post("/api/likes",
                [
                    'id_comentario' => $this->comment->id,
                ]
            );

        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', [
            'id_usuario' => $this->user->id,
            'id_comentario' => $this->comment->id,
        ]);
    }

    public function test_user_can_unlike_comment(): void
    {
        /** @var Like $like */

        $like = Like::factory()->create([
            'id_usuario' => $this->user->id,
            'id_post' => null,
            'id_comentario' => $this->comment->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/api/likes/$like->id");

        $response->assertStatus(200);
        $this->assertNull(Like::find($like->id));
    }

    public function test_unauthenticated_user_cannot_like_comment(): void
    {
        $response = $this->post("/api/likes", [
            'id_comentario' => $this->comment->id,
        ],
            [
                'Accept' => 'application/json',
            ]
        );

        $response->assertStatus(401);
    }

    public function test_get_likes_by_post(): void
    {
        $like = Like::factory()->create([
            'id_post' => $this->post->id,
        ]);

        $response = $this->actingAs($this->user)->get("/api/likes/post/{$this->post->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id_post' => $this->post->id,
                'id_usuario' => $like->id_usuario,
            ]);
    }

    public function test_get_likes_by_comment(): void{
        $like = Like::factory()->create([
            'id_usuario' => $this->user->id,
            'id_post' => null,
            'id_comentario' => $this->comment->id,
        ]);

        $response = $this->actingAs($this->user)->get("/api/likes/comentario/{$this->comment->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id_comentario' => $this->comment->id,
                'id_usuario' => $like->id_usuario,
            ]);
    }

    public function test_get_like()
    {
        /** @var Like $like */

        $like = Like::factory()->create([
            'id_usuario' => $this->user->id,
            'id_post' => $this->post->id,
        ]);

        $response = $this->actingAs($this->user)->get("/api/likes/$like->id");

        $response->assertStatus(200)
            ->assertJsonFragment(data: [
                'id' => $like->id,
                'id_usuario' => $this->user->id,
                'id_post' => $this->post->id,
            ]);
    }

    public function test_get_like_not_found(){
        $response = $this->actingAs($this->user)->get("/api/likes/999");

        $response->assertStatus(404)
            ->assertJsonFragment([
                'message' => 'Error fetching like',
            ]);
    }

}
