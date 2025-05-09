<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioUpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Usuario;
use Exception;

class UsuarioController extends Controller
{
    //
    public function index(): JsonResponse{
        try{
            $usuarios = Usuario::all();

            return response()->json([
                'data' => $usuarios,
                'message' => 'Users obtained successfully'
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error. Users not found'
            ], 404);
        }
    }

    public function show($id): JsonResponse{
        try{
            $usuario = Usuario::findOrFail($id);

            return response()->json([
                'data' => $usuario,
                'message' => 'User obtained successfully'
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'User not found'
            ], 404);
        }
    }

    public function update(UsuarioUpdateRequest $request, $id): JsonResponse{
        try{
            $usuario = Usuario::findOrFail($id);

            $usuario->nombre = $request->nombre;
            $usuario->apellidos = $request->apellidos;

            if($request->email){
                $usuario->email = $request->email;
            }

            if($request->nombre_usuario){
                $usuario->nombre_usuario = $request->nombre_usuario;
            }

            $usuario->estado = $request->estado;


            $usuario->visibilidad = $request->visibilidad;

            $usuario->saveOrFail();

            return response()->json([
                'data' => $usuario,
                'message' => 'User updated successfully'
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error updating user'
            ], 409);
        }
    }

    public function destroy($id): JsonResponse
    {
        try{
            $usuario = Usuario::findOrFail($id);

            $usuario->delete();

            return response()->json([
                'data' => null,
                'message' => 'User deleted successfully'
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error deleting user'
            ], 409);
        }
    }
}

