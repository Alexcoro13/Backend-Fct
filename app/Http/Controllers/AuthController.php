<?php

namespace App\Http\Controllers;

use App\Models\Email_verification_token;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Psy\Util\Json;
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

            $email_verification_token = new Email_verification_token();
            $email_verification_token->email = $usuario->email;
            $email_verification_token->token = Str::random(64);

            $this->sendVerificationEmail($email_verification_token, $usuario);

            $usuario->saveOrFail();
            $email_verification_token->user_id = $usuario->id;
            $email_verification_token->saveOrFail();


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
        $token = explode("|", $token)[1];

        $cookie = cookie(
        'laravel_token',        // nombre de la cookie
        $token,                       // valor: el token Bearer
        60 * 24 * 7,          // duración en minutos (ej: 7 días)
        null,                   // path (null para '/')
        null,                 // dominio
        true,                 // secure (solo HTTPS)
        true,                // httpOnly (no accesible por JS)
        false,                  // raw
        'None'            // SameSite ('Strict' o 'Lax' para proteger CSRF)
    );

        return response()->json(
            [
                'user' => $usuario
            ]
        )->cookie($cookie);
    }

    public function logOut(): JsonResponse
    {
        try {
            if (auth()->check()) {
                auth()->user()->tokens()->delete(); // Revoca todos los tokens activos

                return response()->json([
                    'message' => "Successfully logged out"
                ])->cookie('laravel_token', '', -1);
            }

            return response()->json([
                'error' => "Usuario no autenticado"
            ], 401);
        }
        catch (Throwable $error){
            return response()->json([
                'message' => 'Se ha producido un error',
                'error' => $error->getMessage()
            ], 500);
        }
    }

    public function verifyEmail($token): RedirectResponse
    {
        $token_email = Email_verification_token::WHERE('token', $token)->first();

        if (!$token_email) {
            return redirect()->away('http://localhost:3000');
        }

        $user = Usuario::WHERE('id', $token_email->user_id)->first();

        $user->email_verified_at = now();
        $user->save();

        $token_email->delete();

        return redirect()->away(env('FRONTEND_URL'));
    }

    protected function sendVerificationEmail(Email_verification_token $email_verification_token, Usuario $usuario)
    {
        $verificationUrl = url("/api/verify-email/$email_verification_token->token");

        Mail::send('emails.verify', ['user' => $usuario->nombre, 'url' => $verificationUrl],
            function ($message) use($usuario) {
                $message->to($usuario->email);
                $message->subject('Verify your email address');
        });
    }

    public function checkUserIsVerified(): JsonResponse
    {
        $user = Auth::user();

        if(!$user) {
            return response()->json(['authenticated' => false], 401);
        }
        if (!$user->email_verified_at) {
            return response()->json(['verified' => false]);
        }

        return response()->json(['verified' => true]);
    }
}
