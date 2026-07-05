<?php

declare(strict_types=1);

namespace Core\Shared\Domain\ValueObject;

abstract readonly class Uuid implements \Stringable
{
    public function __construct(public string $value)
    {
        if (!preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value)) {
            throw new InvalidUuidError($value);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function random(): static
    {
        $bytes = random_bytes(16);
        $bytes[6] = chr(ord($bytes[6]) & 0x0F | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3F | 0x80);

        // @phpstan-ignore new.static (intentional: returns the concrete subclass, e.g. UserId::random())
        return new static(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4)));
    }
}
