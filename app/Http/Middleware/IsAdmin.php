<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Authentifie l'utilisateur via le token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Vérifie si le rôle est bien "admin"
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'Accès refusé. Admin uniquement.'], 403);
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Non autorisé ou token invalide.'], 401);
        }
    }
}
