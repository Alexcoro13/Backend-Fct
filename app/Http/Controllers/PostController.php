<?php

namespace App\Http\Controllers;

use App\Http\Requests\Postrequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): JsonResponse{
        $posts = Post::all();

        return response()->json(['data' => $posts, 'message' => ''], 200);
    }

    public function show($id): JsonResponse{
        try {

            $post = Post::findOrFail($id);

            return response()->json(['data' => $post, 'message' => ''], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Post not found', 'error' => $e->getMessage()], 404);
        }
    }

    public function store(Postrequest $request){
        $post = new Post();

        $post->titulo = $request->titulo;
        $post->texto = $request->texto;
        $post->id_usuario = auth()->user()->id;
        $post->imagen = $request->imagen;

        $post->saveOrFail();

        return response()->json(['data' => $post], 201);
    }

    public function update(Postrequest $request, $id): JsonResponse{
        try{
            $post = Post::findOrFail($id);

            $post->titulo = $request->titulo;
            $post->texto = $request->texto;
            $post->id_usuario = auth()->user()->id;
            $post->imagen = $request->imagen;

            $post->saveOrFail();

            return response()->json([
                'data' => $post,
                'message' => 'Post updated successfully'
            ], 200);
        }
        catch (Exception $e){
            return response()->json(['message' => 'Error updating post', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse{
        try{
            $post = Post::findOrFail($id);

            $post->delete();

            return response()->json(['message' => 'Post deleted successfully'], 200);
        }
        catch (Exception $e){
            return response()->json(['message' => 'Error deleting post', 'error' => $e->getMessage()], 500);
        }
    }
}
