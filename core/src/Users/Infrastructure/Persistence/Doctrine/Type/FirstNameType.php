<?php

declare(strict_types=1);

namespace Core\Users\Infrastructure\Persistence\Doctrine\Type;

use Core\Users\Domain\FirstName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class FirstNameType extends StringType
{
    public const string NAME = 'user_first_name';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?FirstName
    {
        if (null === $value) {
            return null;
        }

        return new FirstName((string) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof FirstName ? $value->value : (string) $value;
    }
}
