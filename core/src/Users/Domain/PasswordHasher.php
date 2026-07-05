<?php

declare(strict_types=1);

namespace Core\Users\Domain;

interface PasswordHasher
{
    public function hash(PlainPassword $password): string;

    public function verify(string $hashedPassword, PlainPassword $password): bool;
}
