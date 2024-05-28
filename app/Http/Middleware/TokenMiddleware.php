<?php

namespace App\Http\Middleware;

use Closure;

class TokenMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $user_token = auth()->user()->api_token;
            $token = str_replace('Bearer ', '', $request->header('Authorization'));
            if ($token !== $user_token) {
                return response()->json(['error' => 'Unauthorized'  , 'header' => $token], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return $next($request);
    }
}


