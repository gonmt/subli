<?php

declare(strict_types=1);

namespace Core\Users\Domain;

use Core\Users\Domain\Error\WeakPasswordError;

final readonly class PlainPassword
{
    private const int MIN_LENGTH = 8;

    public function __construct(public string $value)
    {
        if (strlen($value) < self::MIN_LENGTH) {
            throw WeakPasswordError::tooShort(self::MIN_LENGTH);
        }

        if (!preg_match('/[A-Z]/', $value)) {
            throw WeakPasswordError::missingUppercase();
        }

        if (!preg_match('/[0-9]/', $value)) {
            throw WeakPasswordError::missingNumber();
        }
    }
}
