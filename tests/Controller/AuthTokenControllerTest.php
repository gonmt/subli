<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Core\Users\Domain\FirstName;
use Core\Users\Domain\LastName;
use Core\Users\Domain\PasswordHasher;
use Core\Users\Domain\PlainPassword;
use Core\Users\Domain\User;
use Core\Users\Domain\UserId;
use Core\Users\Domain\Username;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuthTokenControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->client = static::createClient();

        $this->em = static::getContainer()->get(EntityManagerInterface::class);
        $this->em->getConnection()->beginTransaction();

        $hasher = static::getContainer()->get(PasswordHasher::class);
        $user = User::create(
            UserId::random(),
            new Username('testuser'),
            new FirstName('Test'),
            new LastName('User'),
            new PlainPassword('Secret1234'),
            $hasher,
        );
        $this->em->persist($user);
        $this->em->flush();
    }

    protected function tearDown(): void
    {
        $this->em->getConnection()->rollBack();
        parent::tearDown();
    }

    public function testReturnsTokenOnValidCredentials(): void
    {
        $this->client->request(
            'POST',
            '/api/auth/token',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => 'testuser', 'password' => 'Secret1234']),
        );

        self::assertResponseIsSuccessful();
        $data = json_decode($this->client->getResponse()->getContent(), true);
        self::assertArrayHasKey('token', $data);
        self::assertNotEmpty($data['token']);
    }

    public function testReturns401OnInvalidCredentials(): void
    {
        $this->client->request(
            'POST',
            '/api/auth/token',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => 'testuser', 'password' => 'WrongPass1']),
        );

        self::assertResponseStatusCodeSame(401);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        self::assertSame('USER_INVALID_CREDENTIALS', $data['error']);
    }
}
