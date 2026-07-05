<?php

declare(strict_types=1);

namespace Core\Users\Application\AuthenticateUser;

use Core\Users\Domain\Email;
use Core\Users\Domain\Error\InvalidCredentialsError;
use Core\Users\Domain\PasswordHasher;
use Core\Users\Domain\PlainPassword;
use Core\Users\Domain\UserRepository;

final readonly class UserAuthenticator
{
    public function __construct(
        private UserRepository $repository,
        private PasswordHasher $hasher,
    ) {
    }

    public function __invoke(string $email, string $plainPassword): AuthenticatedUser
    {
        $email = new Email($email);
        $plainPassword = new PlainPassword($plainPassword);

        $user = $this->repository->findByEmail($email);

        if (null === $user || !$this->hasher->verify($user->hashedPassword, $plainPassword)) {
            throw new InvalidCredentialsError();
        }

        return new AuthenticatedUser(
            $user->id->value,
            $user->email->value,
            $user->firstName->value,
            $user->lastName->value,
        );
    }
}
