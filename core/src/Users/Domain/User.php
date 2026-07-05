<?php

declare(strict_types=1);

namespace Core\Users\Domain;

final class User
{
    private function __construct(
        private(set) readonly UserId $id,
        private(set) readonly Username $username,
        private(set) readonly FirstName $firstName,
        private(set) readonly LastName $lastName,
        private(set) string $hashedPassword,
        private(set) readonly Role $role,
    ) {
    }

    public static function create(
        UserId $id,
        Username $username,
        FirstName $firstName,
        LastName $lastName,
        PlainPassword $password,
        PasswordHasher $hasher,
        Role $role,
    ): self {
        return new self($id, $username, $firstName, $lastName, $hasher->hash($password), $role);
    }

    public function changePassword(PlainPassword $password, PasswordHasher $hasher): void
    {
        $this->hashedPassword = $hasher->hash($password);
    }
}
