<?php

declare(strict_types=1);

namespace Core\Users\Domain;

use Core\Users\Domain\Error\InvalidEmailError;

final readonly class Email
{
    public function __construct(public string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailError::fromValue($value);
        }
    }
}
