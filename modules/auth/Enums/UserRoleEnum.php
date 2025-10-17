<?php

namespace Auth\Enums;

enum UserRoleEnum: string
{
    case DEFAULT = 'DEFAULT';
    case MOD     = 'MOD';
    case ADMIN   = 'ADMIN';
}
