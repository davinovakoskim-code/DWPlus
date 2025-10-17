<?php

namespace Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    public function register(AuthRequest $request): mixed
    {
        $result = $this->authService->register($request->validated());
        return response($result['response'], $result['status']);
    }

    public function login(AuthRequest $request): mixed
    {
        $result = $this->authService->login($request->validated());
        return response($result['response'], $result['status']);
    }

    public function me(): mixed
    {
        $result = $this->authService->me();
        return response($result['response'], $result['status']);
    }

    public function logout(): mixed
    {
        $result = $this->authService->logout();
        return response($result['response'], $result['status']);
    }
}
