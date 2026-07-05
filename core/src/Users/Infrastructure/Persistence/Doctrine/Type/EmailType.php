<?php

declare(strict_types=1);

namespace Core\Users\Infrastructure\Persistence\Doctrine\Type;

use Core\Users\Domain\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class EmailType extends StringType
{
    public const string NAME = 'user_email';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Email
    {
        if (null === $value) {
            return null;
        }

        return new Email((string) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof Email ? $value->value : (string) $value;
    }
}
