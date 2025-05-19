<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\SeguidoresRequest;
use App\Models\Seguidores;
use Exception;


class SeguidoresController extends Controller
{
    public function store(SeguidoresRequest $request): JsonResponse
    {
        try{
            $seguidores = new Seguidores();

            $comprobar_seguimiento = Seguidores::where('id_seguidor', auth()->user()->getAuthIdentifier())
                ->where('id_seguido', $request->id_seguido)
                ->first();

            if($comprobar_seguimiento) {
                return response()->json([
                    'message' => 'You are already following this user',
                ], 409);
            }

            if($request->id_seguido == auth()->user()->getAuthIdentifier()) {
                return response()->json([
                    'message' => 'You cannot follow yourself',
                ], 409);
            }

            $seguidores->id_seguidor = auth()->user()->getAuthIdentifier();
            $seguidores->id_seguido = $request->id_seguido;

            $seguidores->saveOrFail();

            return response()->json([
                'data' => $seguidores,
                'message' => 'Follower created successfully',
            ], 201);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => 'Error creating follower',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try{
            $seguidores = Seguidores::findOrFail($id);
            $seguidores->delete();

            return response()->json([
                'message' => 'Follower deleted successfully',
            ], 200);
        }
        catch (Exception) {
            return response()->json([
                'message' => 'Error deleting follower',
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try{
            $seguidores = Seguidores::where('id_seguido', $id)->get();

            return response()->json([
                'data' => $seguidores,
                'message' => 'Followers retrieved successfully',
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving followers',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSeguidos(): JsonResponse
    {
        try{
            $seguidos = Seguidores::where('id_seguidor', auth()->user()->getAuthIdentifier())->get();
            return response()->json([
                'data' => $seguidos,
                'message' => 'Followed users retrieved successfully',
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving followed users',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkSeguir($idUsuario)
    {
        try{
            $seguido = Seguidores::where('id_seguidor', auth()->user()->getAuthIdentifier())
                ->where('id_seguido', $idUsuario)
                ->exists();

            return response()->json([
                'seguido' => $seguido,
            ], 200);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => 'Error checking follow status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
