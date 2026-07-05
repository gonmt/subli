<?php

declare(strict_types=1);

namespace Core\Shared\Domain\ValueObject;

use Core\Shared\Domain\Error\DomainError;

final class InvalidUuidError extends DomainError
{
    public function __construct(string $value)
    {
        parent::__construct(
            errorCode: 'INVALID_UUID',
            description: sprintf('"%s" is not a valid UUID v4', $value),
        );
    }
}
