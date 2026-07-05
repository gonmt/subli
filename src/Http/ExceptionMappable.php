<?php

declare(strict_types=1);

namespace App\Http;

interface ExceptionMappable
{
    /** @return array<class-string<\Throwable>, int> */
    public static function exceptionsMap(): array;
}
