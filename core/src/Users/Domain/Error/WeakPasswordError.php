<?php

declare(strict_types=1);

namespace Core\Users\Domain\Error;

use Core\Shared\Domain\Error\DomainError;

final class WeakPasswordError extends DomainError
{
    public static function tooShort(int $minLength): self
    {
        return new self(
            errorCode: 'USER_PASSWORD_TOO_SHORT',
            description: sprintf('Password must be at least %d characters long', $minLength),
        );
    }

    public static function missingUppercase(): self
    {
        return new self(
            errorCode: 'USER_PASSWORD_MISSING_UPPERCASE',
            description: 'Password must contain at least one uppercase letter',
        );
    }

    public static function missingNumber(): self
    {
        return new self(
            errorCode: 'USER_PASSWORD_MISSING_NUMBER',
            description: 'Password must contain at least one number',
        );
    }
}
