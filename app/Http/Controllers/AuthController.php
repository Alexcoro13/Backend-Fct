<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Models\Usuario;
use Throwable;

class AuthController extends Controller
{
    public function Register(UsuarioRequest $request): JsonResponse
    {
        try {
            $usuario = new Usuario();

            $usuario->nombre = $request->nombre;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->password);
            $usuario->apellidos = $request->apellidos;
            $usuario->nombre_usuario = $request->nombre_usuario;

            $usuario->saveOrFail();

            return response()->json(['data' => $usuario], 201);
        }
        catch (Throwable $error){
            return response()->json(['error' => 'Error al registrar al usuario', 'message' => $error->getMessage()], 500);
        }
    }

    public function LogIn(Request $request): JsonResponse
    {
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $usuario = Usuario::where('email', $request->email)->firstOrFail();

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json(
            [
                'access_token' => $token,
                'token_type' => "Bearer",
                'user' => $usuario
            ]
        );
    }

    public function logOut(): JsonResponse
    {
        try {
            if (auth()->check()) {
                auth()->user()->tokens()->delete(); // Revoca todos los tokens activos

                return response()->json([
                    'message' => "Successfully logged out"
                ]);
            }

            return response()->json([
                'error' => "Usuario no autenticado"
            ], 401);
        }
        catch (Throwable $error){
            return response()->json([
                'message' => 'Se ha producido un error'
            ], 500);
        }
    }
}
