<?php

// app/Http/Middleware/EnsureEmailIsVerified.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerifiedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Verificar si el usuario ha verificado su correo
        if (!$user || !$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => "Your email haven't been verified look your mail to verify it.",
                'error' => 'Email not verified'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}

