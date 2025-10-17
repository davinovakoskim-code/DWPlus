<?php

namespace Auth\Enums;

enum UserStatusEnum: string
{
    case ACTIVE  = 'ACTIVE';
    case BLOCKED = 'BLOCKED';
}
