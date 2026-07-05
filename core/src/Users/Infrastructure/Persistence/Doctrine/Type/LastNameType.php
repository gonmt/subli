<?php

declare(strict_types=1);

namespace Core\Users\Infrastructure\Persistence\Doctrine\Type;

use Core\Users\Domain\LastName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class LastNameType extends StringType
{
    public const string NAME = 'user_last_name';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?LastName
    {
        if (null === $value) {
            return null;
        }

        return new LastName((string) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof LastName ? $value->value : (string) $value;
    }
}
