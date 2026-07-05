<?php

declare(strict_types=1);

namespace Core\Shared\Domain\Error;

abstract class DomainError extends \RuntimeException
{
    public function __construct(
        public readonly string $errorCode,
        public readonly string $description,
    ) {
        parent::__construct($description);
    }
}
