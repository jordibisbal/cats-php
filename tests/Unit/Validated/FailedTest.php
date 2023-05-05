<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Validated;

use j45l\Cats\Validated\Failed;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Either\Because;
use function j45l\Cats\Either\Failure;
use function PHPUnit\Framework\assertEquals;

final class FailedTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $failure = Failure(Because('Failure'));
        $failures = Failed::create([$failure]);

        assertEquals([$failure], $failures->failures);
    }

    public function testCanBeCastToString(): void
    {
        assertEquals(
            'Failed: none',
            (string) Failed::create([])
        );
        assertEquals(
            'Failed: Failure',
            (string) Failed::create([
                Failure(Because('Failure')),
            ])
        );
        assertEquals(
            'Failed: Failure and Another Failure',
            (string) Failed::create([
                Failure(Because('Failure')),
                Failure(Because('Another Failure')),
            ])
        );
    }
}
