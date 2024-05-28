<?php
namespace App\Http\Middleware;

use Closure;

class IpWhitelistMiddleware
{
    public $whitelistedIps = [
        '127.0.0.1',
        '::1' // Add allowed IP addresses here
    ];

    public function handle($request, Closure $next)
    {
        $clientIp = $request->ip();

        // Debugging log to check the IP being retrieved

        if (!in_array($clientIp, $this->whitelistedIps)) {
            return response()->json(['error' => 'not allowed ip'], 401);
        }

        return $next($request);
    }
}
