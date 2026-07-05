<?php

declare(strict_types=1);

namespace Core\Users\Domain;

final class User
{
    private function __construct(
        private(set) readonly UserId $id,
        private(set) readonly Email $email,
        private(set) FirstName $firstName,
        private(set) LastName $lastName,
        private(set) string $hashedPassword,
    ) {
    }

    public static function create(
        UserId $id,
        Email $email,
        FirstName $firstName,
        LastName $lastName,
        PlainPassword $password,
        PasswordHasher $hasher,
    ): self {
        return new self($id, $email, $firstName, $lastName, $hasher->hash($password));
    }

    public function changePassword(PlainPassword $password, PasswordHasher $hasher): void
    {
        $this->hashedPassword = $hasher->hash($password);
    }
}
