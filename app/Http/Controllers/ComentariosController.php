<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComentarioRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Comentario;
use Exception;

class ComentariosController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            // Lógica para mostrar todos los comentarios
            $comentarios = Comentario::all();

            return response()->json(['data' => $comentarios, 'message' => ''], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Failed to fetch all the comments', 'error' => $e->getMessage()], 404);
        }
    }

    public function show($id): JsonResponse
    {
        // Lógica para mostrar un comentario específico

        try{
            $comentario = Comentario::findOrFail($id);

            return response()->json(['data' => $comentario, 'message' => ''], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=> null, 'message' => 'Comment not found', 'error' => $e->getMessage()], 404);
        }
    }

    public function getComentarioByPost($id): JsonResponse
    {
        try {
            $comentarios = Comentario::where('id_post', $id)->get();

            return response()->json(['data' => $comentarios,
                'message' => ''],
                200);
        }
        catch (Exception $e){
            return response()->json(
                ['data'=> null,
                'message' => 'Failed to fetch comments by post',
                'error' => $e->getMessage()],
                404);
        }

    }

    public function store(ComentarioRequest $request)
    {
        // Lógica para almacenar un nuevo comentario
        try{
            $comentario = new Comentario();

            $comentario->texto = $request->texto;
            $comentario->id_post = $request->id_post;
            $comentario->id_usuario = auth()->user()->id;

            $comentario->saveOrFail();

            return response()->json(['data' => $comentario, 'message' => 'Comment created successfully'], 201);
        }
        catch (Exception $e){
            return response()->json(['data'=>null, 'message' => 'Error creating comment', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un comentario específico
        try{
            $comentario = Comentario::findOrFail($id);

            $comentario->texto = $request->texto;
            $comentario->id_post = $request->id_post;
            $comentario->id_usuario = auth()->user()->id;

            $comentario->saveOrFail();

            return response()->json(['data' => $comentario, 'message' => 'Comment updated successfully'], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=>null, 'message' => 'Error updating comment', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        // Lógica para eliminar un comentario específico
        try{
            $comentario = Comentario::findOrFail($id);

            $comentario->delete();

            return response()->json(['data' => null, 'message' => 'Comment deleted successfully'], 200);
        }
        catch (Exception $e){
            return response()->json(['data'=>null, 'message' => 'Error deleting comment', 'error' => $e->getMessage()], 500);
        }
    }
}
