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
            $liked = false;
            foreach ($likes as $like) {
                if($like->id_usuario == auth()->user()->id){
                    $liked = true;
                } else {
                    $liked = false;
                }
            }

            return response()->json([
                'message' => 'Likes obtained successfully',
                'data' => $likes,
                'liked' => $liked
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

            $liked = false;
            foreach ($likes as $like) {
                if($like->id_usuario == auth()->user()->id){
                    $liked = true;
                } else {
                    $liked = false;
                }
            }

            return response()->json([
                'message' => 'Likes obtained successfully',
                'data' => $likes,
                'liked' => $liked
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Error fetching likes',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function toggleLike(LikeRequest $request): JsonResponse
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

            $previousLike = Like::where('id_usuario', $like->id_usuario)
                ->where(function ($query) use ($like) {
                    if($like->id_post != null)
                        $query->where('id_post', $like->id_post);
                    else{
                        $query->where('id_comentario', $like->id_comentario);
                    }
                })->first();

            if(!$previousLike){
                $like->saveOrFail();
                return response()->json([
                    'message' => 'Like creado correctamente',
                    'data' => $like,
                    'liked' => true
                ]);
            }
            else{
                $previousLike->delete();
                return response()->json([
                    'message' => 'Se ha borrado el like anterior',
                    'data' => $like,
                    'liked' => false
                ]);
            }



        }
        catch (Exception $e){
            return response()->json([
                'message' => 'Error al crear el like',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
