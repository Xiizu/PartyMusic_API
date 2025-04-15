<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiToken = env('API_TOKEN');

        // Vérifie si le token est correct
        if ($request->bearerToken() !== $apiToken) {
            return response()->json(['message' => 'Unauthorized'], 401);  // Retourne une erreur si le token est invalide
        }

        return $next($request);
    }
}
