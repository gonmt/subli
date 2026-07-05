<?php

declare(strict_types=1);

namespace Core\Users\Application\AuthenticateUser;

final readonly class AuthenticatedUser
{
    public function __construct(
        public string $id,
        public string $email,
        public string $firstName,
        public string $lastName,
    ) {
    }
}
