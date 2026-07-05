<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Http\ExceptionMappable;
use Core\Shared\Domain\Error\DomainError;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::EXCEPTION)]
final class DomainExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $controllerClass = $this->resolveControllerClass($event->getRequest()->attributes->get('_controller'));

        if (null === $controllerClass || !is_a($controllerClass, ExceptionMappable::class, true)) {
            return;
        }

        $exception = $event->getThrowable();
        $map = $controllerClass::exceptionsMap();

        foreach ($map as $exceptionClass => $statusCode) {
            if ($exception instanceof $exceptionClass) {
                $event->setResponse($this->domainErrorResponse($exception, $statusCode));

                return;
            }
        }

        $event->setResponse(new JsonResponse(
            ['error' => 'INTERNAL_ERROR', 'message' => 'An unexpected error occurred'],
            Response::HTTP_INTERNAL_SERVER_ERROR,
        ));
    }

    private function domainErrorResponse(\Throwable $exception, int $statusCode): JsonResponse
    {
        if ($exception instanceof DomainError) {
            return new JsonResponse(
                ['error' => $exception->errorCode, 'message' => $exception->description],
                $statusCode,
            );
        }

        return new JsonResponse(['error' => 'ERROR', 'message' => $exception->getMessage()], $statusCode);
    }

    private function resolveControllerClass(mixed $controller): ?string
    {
        if (is_string($controller)) {
            return explode('::', $controller)[0];
        }

        if (is_array($controller) && isset($controller[0])) {
            return is_object($controller[0]) ? $controller[0]::class : (string) $controller[0];
        }

        return null;
    }
}
