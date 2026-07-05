<?php

declare(strict_types=1);

namespace App\Command;

use Core\Users\Domain\FirstName;
use Core\Users\Domain\LastName;
use Core\Users\Domain\PasswordHasher;
use Core\Users\Domain\PlainPassword;
use Core\Users\Domain\Role;
use Core\Users\Domain\User;
use Core\Users\Domain\UserId;
use Core\Users\Domain\UserRepository;
use Core\Users\Domain\Username;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:users:seed', description: 'Create the initial admin user')]
final class SeedAdminUserCommand extends Command
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly PasswordHasher $hasher,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = new Username('admin');

        if (null !== $this->repository->findByUsername($username)) {
            $output->writeln('Admin user already exists.');

            return Command::SUCCESS;
        }

        $user = User::create(
            UserId::random(),
            $username,
            new FirstName('Admin'),
            new LastName('User'),
            new PlainPassword('Admin1234'),
            $this->hasher,
            Role::Admin,
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('Admin user created: admin / Admin1234');

        return Command::SUCCESS;
    }
}
