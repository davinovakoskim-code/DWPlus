<?php

namespace Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Kascat\EasyModule\Core\Service;
use Auth\Enums\UserRoleEnum;
use Auth\Enums\UserStatusEnum;
use Throwable;

class AuthService extends Service
{
    public function register(array $data): array
    {
        DB::beginTransaction();

        try {
            $payload = [
                User::NAME     => $data[User::NAME],
                User::USERNAME => $data[User::USERNAME],
                User::EMAIL    => $data[User::EMAIL],
                User::PASSWORD => Hash::make($data[User::PASSWORD]),
                User::ROLE     => UserRoleEnum::DEFAULT,
                User::STATUS   => UserStatusEnum::ACTIVE,
            ];

            /** @var User $user */
            $user  = User::create($payload);
            $token = $user->createToken('api')->plainTextToken;

            DB::commit();
            return self::buildReturn(compact('user', 'token'), 201);

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('AuthService: error on register', [
                'message' => $e->getMessage(), 'namespace' => __CLASS__,
            ]);
            report($e);

            return self::buildReturn(['message' => 'Falha ao registrar usuário'], 500);
        }
    }

    public function login(array $data): array
    {
        $user = User::where(User::EMAIL, $data[User::EMAIL])->first();

        if (!$user || !Hash::check($data[User::PASSWORD], $user->password)) {
            throw new AuthenticationException('Credenciais inválidas');
        }

        if ($user->status !== UserStatusEnum::ACTIVE) {
            throw new AuthenticationException('Usuário bloqueado');
        }

        $token = $user->createToken('api')->plainTextToken;

        return self::buildReturn(compact('user', 'token'));
    }

    public function me(): array
    {
        /** @var \Auth\User|null $user */
        $user = auth('sanctum')->user();
        if (!$user) {
            return self::buildReturn(['message' => 'Unauthenticated'], 401);
        }

        return self::buildReturn($user->toArray());
    }

    public function logout(): array
    {
        $user = auth()->user();
        if ($user) {
            $token = request()->bearerToken();
            if ($token && $access = \Laravel\Sanctum\PersonalAccessToken::findToken($token)) {
                $access->delete();
            } else {
                $user->tokens()->delete();
            }
        }

        return self::buildReturn();
    }
}
