<?php

declare(strict_types=1);

namespace Core\Users\Domain;

final class User
{
    private function __construct(
        private(set) readonly UserId $id,
        private(set) readonly Username $username,
        private(set) FirstName $firstName,
        private(set) LastName $lastName,
        private(set) string $hashedPassword,
    ) {
    }

    public static function create(
        UserId $id,
        Username $username,
        FirstName $firstName,
        LastName $lastName,
        PlainPassword $password,
        PasswordHasher $hasher,
    ): self {
        return new self($id, $username, $firstName, $lastName, $hasher->hash($password));
    }

    public function changePassword(PlainPassword $password, PasswordHasher $hasher): void
    {
        $this->hashedPassword = $hasher->hash($password);
    }
}
