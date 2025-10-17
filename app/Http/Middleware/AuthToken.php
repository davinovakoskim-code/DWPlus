<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AuthToken
{
public function handle(Request $request, Closure $next): Response
{
    $token = $request->bearerToken();
    if (!$token) {
        return response(['message' => 'Unauthenticated'], 401);
    }

    $accessToken = PersonalAccessToken::findToken($token);
    if (!$accessToken) {
        return response(['message' => 'Invalid token'], 401);
    }

    $user = $accessToken->tokenable;

    $user->withAccessToken($accessToken);

    auth()->setUser($user);

    return $next($request);
}
}
