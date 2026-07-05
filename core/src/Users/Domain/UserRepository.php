<?php

declare(strict_types=1);

namespace Core\Users\Domain;

interface UserRepository
{
    public function findByEmail(Email $email): ?User;
}
