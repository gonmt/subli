<?php

declare(strict_types=1);

namespace Core\Users\Infrastructure\Security;

use Core\Users\Domain\PasswordHasher;
use Core\Users\Domain\PlainPassword;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;

final readonly class SymfonyPasswordHasher implements PasswordHasher
{
    private NativePasswordHasher $hasher;

    public function __construct()
    {
        $this->hasher = new NativePasswordHasher();
    }

    public function hash(PlainPassword $password): string
    {
        return $this->hasher->hash($password->value);
    }

    public function verify(string $hashedPassword, PlainPassword $password): bool
    {
        return $this->hasher->verify($hashedPassword, $password->value);
    }
}
