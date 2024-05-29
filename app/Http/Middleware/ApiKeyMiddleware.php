<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class ApiKeyMiddleware
{
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('x-api-key');

        if (!$this->isValidApiKey($apiKey)) {
            return response()->json(['error' => 'api key not valid'], 401);
        }

        return $next($request);
    }

    protected function isValidApiKey($apiKey)
    {
        return User::where('api_key', $apiKey)->exists();
    }
}
