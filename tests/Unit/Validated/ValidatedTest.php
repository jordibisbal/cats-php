<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Validated;

use j45l\Cats\Validated\Validated;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\Cats\Either\Because;
use function j45l\Cats\Either\Failure;
use function j45l\functional\first;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Validated::class)] final class ValidatedTest extends TestCase
{
    public function testValidatesWhenAllValid(): void
    {
        assertTrue(
            Validated::create([fn () => 1, fn () => 2])
                ->allValid()
        );
    }

    public function testNotValidatesWhenSomeFailed(): void
    {
        assertFalse(
            Validated::create([fn () => 1, fn () => throw new RuntimeException('Failed')])
                ->allValid()
        );
    }

    public function testCanGetNotValidatesOnes(): void
    {
        $validated = Validated::create([fn () => 1, fn () => throw new RuntimeException('Failed')]);
        self::assertCount(1, $validated->failed());
        self::assertEquals(
            'Failed',
            (string) first($validated->failed(), default: Failure(Because('testFailed')))?->reason
        );
    }
}
