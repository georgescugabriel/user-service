<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticateAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle (Request $request, Closure $next)
    {
        $allowedSecrets = explode(',', env('ALLOWED_SECRETS'));
        if (in_array($request->header('Service-Authorization'), $allowedSecrets)) {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized Service Access.'], Response::HTTP_UNAUTHORIZED);
    }
}
