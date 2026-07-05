<?php

declare(strict_types=1);

namespace Core\Users\Infrastructure\Security;

use Core\Users\Application\AuthenticateUser\AuthenticatedUser;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class SecurityUser implements UserInterface
{
    public function __construct(private AuthenticatedUser $user)
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->user->username;
    }

    public function getRoles(): array
    {
        return [$this->user->role];
    }

    public function eraseCredentials(): void
    {
    }
}
