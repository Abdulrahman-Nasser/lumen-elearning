<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\User;

class Authenticate
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $key = explode(' ', $token)[1];
        $user = User::where('api_token', $key)->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }



        return $next($request);
    }
}
