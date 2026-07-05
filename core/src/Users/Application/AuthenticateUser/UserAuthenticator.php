<?php

declare(strict_types=1);

namespace Core\Users\Application\AuthenticateUser;

use Core\Users\Domain\Error\InvalidCredentialsError;
use Core\Users\Domain\Error\InvalidUsernameError;
use Core\Users\Domain\Error\WeakPasswordError;
use Core\Users\Domain\PasswordHasher;
use Core\Users\Domain\PlainPassword;
use Core\Users\Domain\UserRepository;
use Core\Users\Domain\Username;

final readonly class UserAuthenticator
{
    public function __construct(
        private UserRepository $repository,
        private PasswordHasher $hasher,
    ) {
    }

    public function __invoke(string $username, string $plainPassword): AuthenticatedUser
    {
        try {
            $username = new Username($username);
            $plainPassword = new PlainPassword($plainPassword);
        } catch (InvalidUsernameError | WeakPasswordError) {
            throw new InvalidCredentialsError();
        }

        $user = $this->repository->findByUsername($username);

        if (null === $user || !$this->hasher->verify($user->hashedPassword, $plainPassword)) {
            throw new InvalidCredentialsError();
        }

        return new AuthenticatedUser(
            $user->id->value,
            $user->username->value,
            $user->firstName->value,
            $user->lastName->value,
        );
    }
}
