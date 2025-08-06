<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;

class EnsureApiKeyMiddleware
{
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey || !($device = Device::where('api_key', $apiKey)->first())) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Store device on request
        $request->merge(['device' => $device]);

        return $next($request);
    }

}
