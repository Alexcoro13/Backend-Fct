<?php

namespace App\Http\Controllers;

use App\Http\Requests\Postrequest;
use App\Models\Post;
use Cloudinary\Cloudinary;
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


        if($request->imagen){
            $cloud = new Cloudinary([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ]
            ]);

            $upload = $cloud->uploadApi()->upload($request->file('imagen')->getRealPath(), ['quality' => 100]);
            $secure_url = $upload['secure_url'];

            $post->imagen = $secure_url;
        }

        $post->saveOrFail();

        return response()->json(['data' => $post], 201);
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

    public function getLatestPosts($number): JsonResponse
    {
        try{
            $posts = Post::inRandomOrder()->take($number)->get();

            return response()->json(['data' => $posts, 'message' => ''], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Error fetching posts', 'error' => $e->getMessage()], 500);
        }
    }

    public function getPostsByUser($id): JsonResponse
    {
        try{
            $posts = Post::where('id_usuario', $id)->get();

            if(!$posts){
                return response()->json(['data' => null, 'message' => 'No posts found for this user'], 404);
            }

            return response()->json(['data' => $posts, 'message' => ''], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Error fetching user posts', 'error' => $e->getMessage()], 500);
        }

    }
}
