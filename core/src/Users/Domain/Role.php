<?php

declare(strict_types=1);

namespace Core\Users\Domain;

enum Role: string
{
    case User = 'ROLE_USER';
    case Admin = 'ROLE_ADMIN';
}
