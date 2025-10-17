<?php

namespace Auth;

use Illuminate\Validation\Rule;
use Kascat\EasyModule\Core\Request;
use Auth\User;

class AuthRequest extends Request
{
    public function validateToRegister(): array
    {
        return [
            User::NAME     => ['required', 'string', 'max:100'],
            User::USERNAME => ['required', 'alpha_dash', Rule::unique(User::TABLE, User::USERNAME)],
            User::EMAIL    => ['required', 'email', Rule::unique(User::TABLE, User::EMAIL)],
            User::PASSWORD => ['required', 'string', 'min:6'],
        ];
    }

    public function validateToLogin(): array
    {
        return [
            User::EMAIL    => ['required', 'email'],
            User::PASSWORD => ['required', 'string'],
        ];
    }

    public function validateToUpdateProfile(): array
    {
        /** @var \Auth\User $user */
        $user = $this->user();

        return [
            User::NAME     => ['sometimes','string','max:100'],
            User::USERNAME => ['sometimes','alpha_dash', Rule::unique(User::TABLE, User::USERNAME)->ignore($user?->id)],
            User::EMAIL    => ['sometimes','email', Rule::unique(User::TABLE, User::EMAIL)->ignore($user?->id)],
            User::AVATAR   => ['nullable','image','max:4096'],
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        if (!empty($data[User::EMAIL])) {
            $data[User::EMAIL] = strtolower(trim($data[User::EMAIL]));
        }

        $this->merge($data);
    }
}
