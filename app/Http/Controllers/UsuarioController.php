<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioUpdateRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\Hash;

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

            $idToken = auth()->user()->id;

            if($usuario->id == $idToken){
                $usuario['propietario'] = true;
            }
            else{
                $usuario['propietario'] = false;
            }

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

            if($request->nombre) {
                $usuario->nombre = $request->nombre;
            }

            if($request->apellidos){
                $usuario->apellidos = $request->apellidos;
            }

            if($request->email){
                $usuario->email = $request->email;
            }

            if($request->nombre_usuario){
                $usuario->nombre_usuario = $request->nombre_usuario;
            }

            if($request->estado){
                $usuario->estado = $request->estado;
            }


            if($request->visibilidad){
                $usuario->visibilidad = $request->visibilidad;
            }

            if($request->avatar){
                $usuario->avatar = $request->avatar;
            }


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

    public function changePassword($request)
    {
        try{
            $usuario = Auth()->user();

            Hash::check($request->old_password, $usuario->password) ?
                $usuario->password = Hash::make($request->new_password) :
                throw new Exception('Old password does not match');

            $usuario->saveOrFail();

            return response()->json([
                'data' => $usuario,
                'message' => 'Password changed successfully'
            ]);
        }
        catch (Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error changing password'
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

