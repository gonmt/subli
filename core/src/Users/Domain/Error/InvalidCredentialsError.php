<?php

declare(strict_types=1);

namespace Core\Users\Domain\Error;

use Core\Shared\Domain\Error\DomainError;

final class InvalidCredentialsError extends DomainError
{
    public function __construct()
    {
        parent::__construct(
            errorCode: 'USER_INVALID_CREDENTIALS',
            description: 'Invalid email or password',
        );
    }
}
