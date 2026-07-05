<?php

declare(strict_types=1);

namespace Core\Users\Infrastructure\Persistence\Doctrine\Type;

use Core\Users\Domain\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

final class UserIdType extends GuidType
{
    public const string NAME = 'user_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?UserId
    {
        if (null === $value) {
            return null;
        }

        return new UserId((string) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        return $value instanceof UserId ? $value->value : (string) $value;
    }
}
