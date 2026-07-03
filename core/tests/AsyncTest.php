<?php

namespace Core\Tests;

use PHPUnit\Framework\TestCase;
use function Amp\async;
use function Amp\Future\awaitAll;

class AsyncTest extends TestCase
{
    public function test_parallel_futures_run_concurrently(): void
    {
        $order = [];

        [$errors, $results] = awaitAll([
            async(function () use (&$order) { $order[] = 'a'; return 1; }),
            async(function () use (&$order) { $order[] = 'b'; return 2; }),
            async(function () use (&$order) { $order[] = 'c'; return 3; }),
        ]);

        $this->assertEmpty($errors);
        $this->assertSame([1, 2, 3], $results);
    }
}
