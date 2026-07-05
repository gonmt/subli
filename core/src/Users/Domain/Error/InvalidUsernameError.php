<?php

declare(strict_types=1);

namespace Core\Users\Domain\Error;

use Core\Shared\Domain\Error\DomainError;

final class InvalidUsernameError extends DomainError
{
    public static function empty(): self
    {
        return new self(
            errorCode: 'USER_USERNAME_EMPTY',
            description: 'Username cannot be empty',
        );
    }

    public static function tooShort(int $min): self
    {
        return new self(
            errorCode: 'USER_USERNAME_TOO_SHORT',
            description: sprintf('Username must be at least %d characters long', $min),
        );
    }

    public static function tooLong(int $max): self
    {
        return new self(
            errorCode: 'USER_USERNAME_TOO_LONG',
            description: sprintf('Username must not exceed %d characters', $max),
        );
    }

    public static function invalidCharacters(): self
    {
        return new self(
            errorCode: 'USER_USERNAME_INVALID_CHARACTERS',
            description: 'Username contains invalid characters',
        );
    }
}
