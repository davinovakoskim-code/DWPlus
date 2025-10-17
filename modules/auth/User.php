<?php

namespace Auth;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Auth\Enums\UserRoleEnum;
use Auth\Enums\UserStatusEnum;

/**
 * Class User
 * @property int              $id
 * @property string           $name
 * @property string           $username
 * @property string           $email
 * @property string           $password
 * @property string|null      $avatar
 * @property UserRoleEnum     $role
 * @property UserStatusEnum   $status
 * @property Carbon|null      $created_at
 * @property Carbon|null      $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const ID         = 'id';
    const NAME       = 'name';
    const USERNAME   = 'username';
    const EMAIL      = 'email';
    const PASSWORD   = 'password';
    const AVATAR     = 'avatar';
    const ROLE       = 'role';
    const STATUS     = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const TABLE = 'users';
    protected $table = self::TABLE;

    protected $guarded = [
        self::ID, self::CREATED_AT, self::UPDATED_AT,
    ];

    protected $hidden = [
        self::PASSWORD, 'remember_token',
    ];

    protected $casts = [
        self::ROLE   => UserRoleEnum::class,
        self::STATUS => UserStatusEnum::class,
    ];
}
