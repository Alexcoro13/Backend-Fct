<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Models\Like;
use Exception;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function index():JsonResponse
    {
        try{
            $Like = Like::all();

            return response()->json([
                'message' => 'Likes obtained successfully',
                'data' => $Like
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Error fetching likes',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(LikeRequest $request): JsonResponse
    {
        try{
            $like =  new Like();

            $like->id_usuario = auth()->user()->id;

            $like->id_post = $request->id_post;

            if($request->id_comentario != null){
                $like->id_comentario = $request->id_comentario;

            }

            if($request->id_post != null){
                $like->id_post = $request->id_post;
            }

            $like->saveOrFail();

            return response()->json([
                'message' => 'Like creado correctamente',
                'data' => $like
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Error al crear el like',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function show($id): JsonResponse
    {
        try{
            $like = Like::findOrFail($id);

            return response()->json([
                'message' => 'Like obtained successfully',
                'data' => $like
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Error fetching like',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        try{
            $like = Like::findOrFail($id);

            $like->delete();

            return response()->json([
                'message' => 'Like deleted successfully',
                'data' => null
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Error deleting like',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function get_post_likes($id): JsonResponse
    {
        try{
            $likes = Like::where('id_post', $id)->get();

            return response()->json([
                'message' => 'Likes obtained successfully',
                'data' => $likes
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Error fetching likes',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function get_comentario_likes($id): JsonResponse
    {
        try{
            $likes = Like::where('id_comentario', $id)->get();

            return response()->json([
                'message' => 'Likes obtained successfully',
                'data' => $likes
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Error fetching likes',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
