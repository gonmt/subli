<?php

declare(strict_types=1);

namespace Core\Users\Domain;

use Core\Users\Domain\Error\InvalidUsernameError;

final readonly class Username
{
    private const int MIN_LENGTH = 3;
    private const int MAX_LENGTH = 50;

    public function __construct(public string $value)
    {
        if ('' === trim($value)) {
            throw InvalidUsernameError::empty();
        }

        if (strlen($value) < self::MIN_LENGTH) {
            throw InvalidUsernameError::tooShort(self::MIN_LENGTH);
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw InvalidUsernameError::tooLong(self::MAX_LENGTH);
        }

        if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $value)) {
            throw InvalidUsernameError::invalidCharacters();
        }
    }
}
