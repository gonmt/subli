<?php

declare(strict_types=1);

namespace Core\Users\Domain\Error;

use Core\Shared\Domain\Error\DomainError;

final class InvalidNameError extends DomainError
{
    public static function empty(string $field): self
    {
        return new self(
            errorCode: 'USER_NAME_EMPTY',
            description: sprintf('%s cannot be empty', $field),
        );
    }

    public static function tooShort(string $field, int $min): self
    {
        return new self(
            errorCode: 'USER_NAME_TOO_SHORT',
            description: sprintf('%s must be at least %d characters long', $field, $min),
        );
    }

    public static function tooLong(string $field, int $max): self
    {
        return new self(
            errorCode: 'USER_NAME_TOO_LONG',
            description: sprintf('%s must not exceed %d characters', $field, $max),
        );
    }

    public static function invalidCharacters(string $field): self
    {
        return new self(
            errorCode: 'USER_NAME_INVALID_CHARACTERS',
            description: sprintf('%s contains invalid characters', $field),
        );
    }
}
