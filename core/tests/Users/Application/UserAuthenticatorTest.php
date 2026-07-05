<?php

declare(strict_types=1);

namespace Core\Tests\Users\Application;

use Core\Users\Application\AuthenticateUser\AuthenticatedUser;
use Core\Users\Application\AuthenticateUser\UserAuthenticator;
use Core\Users\Domain\Error\InvalidCredentialsError;
use Core\Users\Domain\FirstName;
use Core\Users\Domain\LastName;
use Core\Users\Domain\PasswordHasher;
use Core\Users\Domain\PlainPassword;
use Core\Users\Domain\Role;
use Core\Users\Domain\User;
use Core\Users\Domain\UserId;
use Core\Users\Domain\UserRepository;
use Core\Users\Domain\Username;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class UserAuthenticatorTest extends TestCase
{
    private MockObject&UserRepository $repository;
    private MockObject&PasswordHasher $hasher;
    private UserAuthenticator $authenticator;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(UserRepository::class);
        $this->hasher = $this->createMock(PasswordHasher::class);
        $this->authenticator = new UserAuthenticator($this->repository, $this->hasher);
    }

    public function testReturnsAuthenticatedUserOnValidCredentials(): void
    {
        $user = User::create(
            UserId::random(),
            new Username('johndoe'),
            new FirstName('John'),
            new LastName('Doe'),
            new PlainPassword('Secret1234'),
            $this->hasher,
            Role::User,
        );

        $this->hasher->method('hash')->willReturn('hashed');
        $this->repository->method('findByUsername')->willReturn($user);
        $this->hasher->method('verify')->willReturn(true);

        $result = ($this->authenticator)('johndoe', 'Secret1234');

        self::assertInstanceOf(AuthenticatedUser::class, $result);
        self::assertSame('johndoe', $result->username);
        self::assertSame('ROLE_USER', $result->role);
    }

    public function testThrowsOnUserNotFound(): void
    {
        $this->repository->method('findByUsername')->willReturn(null);

        $this->expectException(InvalidCredentialsError::class);

        ($this->authenticator)('nobody', 'Secret1234');
    }

    public function testThrowsInvalidCredentialsOnMalformedUsername(): void
    {
        $this->expectException(InvalidCredentialsError::class);

        ($this->authenticator)('invalid username!', 'Secret1234');
    }

    public function testThrowsInvalidCredentialsOnWeakPassword(): void
    {
        $this->expectException(InvalidCredentialsError::class);

        ($this->authenticator)('johndoe', 'weak');
    }

    public function testThrowsOnWrongPassword(): void
    {
        $user = User::create(
            UserId::random(),
            new Username('johndoe'),
            new FirstName('John'),
            new LastName('Doe'),
            new PlainPassword('Secret1234'),
            $this->hasher,
            Role::User,
        );

        $this->hasher->method('hash')->willReturn('hashed');
        $this->repository->method('findByUsername')->willReturn($user);
        $this->hasher->method('verify')->willReturn(false);

        $this->expectException(InvalidCredentialsError::class);

        ($this->authenticator)('johndoe', 'WrongPass1');
    }
}
