<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\ExceptionMappable;
use Core\Users\Application\AuthenticateUser\UserAuthenticator;
use Core\Users\Domain\Error\InvalidCredentialsError;
use Core\Users\Infrastructure\Security\SecurityUser;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class AuthTokenController implements ExceptionMappable
{
    public function __construct(
        private UserAuthenticator $authenticator,
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public static function exceptionsMap(): array
    {
        return [
            InvalidCredentialsError::class => Response::HTTP_UNAUTHORIZED,
        ];
    }

    #[Route('/api/auth/token', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $user = ($this->authenticator)(
            $data['username'] ?? '',
            $data['password'] ?? '',
        );

        return new JsonResponse(['token' => $this->jwtManager->create(new SecurityUser($user))]);
    }
}
