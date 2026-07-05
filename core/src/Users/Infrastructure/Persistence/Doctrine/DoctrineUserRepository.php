<?php

declare(strict_types=1);

namespace Core\Users\Infrastructure\Persistence\Doctrine;

use Core\Users\Domain\User;
use Core\Users\Domain\UserRepository;
use Core\Users\Domain\Username;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineUserRepository implements UserRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findByUsername(Username $username): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username->value]);
    }
}
