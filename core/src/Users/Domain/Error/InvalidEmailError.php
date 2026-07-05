<?php

declare(strict_types=1);

namespace Core\Users\Domain\Error;

use Core\Shared\Domain\Error\DomainError;

final class InvalidEmailError extends DomainError
{
    public static function fromValue(string $value): self
    {
        return new self(
            errorCode: 'USER_EMAIL_INVALID',
            description: sprintf('"%s" is not a valid email address', $value),
        );
    }
}
