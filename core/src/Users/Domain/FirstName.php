<?php

declare(strict_types=1);

namespace Core\Users\Domain;

use Core\Users\Domain\Error\InvalidNameError;

final readonly class FirstName
{
    private const int MIN_LENGTH = 2;
    private const int MAX_LENGTH = 100;

    public function __construct(public string $value)
    {
        if ('' === trim($value)) {
            throw InvalidNameError::empty('First name');
        }

        if (strlen($value) < self::MIN_LENGTH) {
            throw InvalidNameError::tooShort('First name', self::MIN_LENGTH);
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw InvalidNameError::tooLong('First name', self::MAX_LENGTH);
        }

        if (!preg_match('/^[\p{L}\s\'\-]+$/u', $value)) {
            throw InvalidNameError::invalidCharacters('First name');
        }
    }
}
