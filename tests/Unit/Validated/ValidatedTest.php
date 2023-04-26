<?php

/** @noinspection ClassConstantCanBeUsedInspection */

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Validated;

use j45l\Cats\Either\Failure;
use j45l\Cats\Either\Reason\BecauseError;
use j45l\Cats\Test\Unit\Validated\Stubs\ValueObject;
use j45l\Cats\Validated\Validated;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\Cats\Either\Success;
use function j45l\Cats\Validated\Validated;
use function j45l\functional\first;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Validated::class)]
#[CoversFunction('\j45l\Cats\Validated\Validated')]
final class ValidatedTest extends TestCase
{
    public function testValidatesWhenAllValid(): void
    {
        assertTrue(
            Validated([fn () => 1, fn () => 2])
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
            (string) first($validated->failed())?->reason
        );
    }

    public function testCanGetValidatesOnes(): void
    {
        $validated = Validated::create([fn () => 42, fn () => throw new RuntimeException('Failed')]);
        self::assertCount(1, $validated->succeed());
        self::assertEquals(
            42,
            (string) first($validated->succeed())?->get()
        );
    }

    public function testGettingValues(): void
    {
        assertEquals(
            ['foo' => 1, 0 => 2],
            Validated(['foo' => fn () => 1, fn () => 2])
                ->get()
        );
    }

    public function testCastingToEither(): void
    {
        assertEquals(
            Success(ValueObject::create(1, 2)),
            Validated(['a' => fn () => 1, 'b' => fn () => 2])
                ->toEither(ValueObject::class)
        );
    }

    public function testCastingToEitherNoClass(): void
    {
        assertEquals(
            Success((object) ['a' => 1, 'b' => 2]),
            Validated(['a' => fn () => 1, 'b' => fn () => 2])
                ->toEither()
        );
    }

    public function testCastingFailedToEither(): void
    {
        $validated = Validated(['a' => fn () => 1, 'b' => fn () => 2])
            ->toEither('invalid class name');

        assertInstanceOf(Failure::class, $validated);
        assertInstanceOf(BecauseError::class, $validated->reason);
        assertEquals('Class "invalid class name" not found', $validated->reason);
    }

    public function testCastingFailedToEitherBecauseParameters(): void
    {
        $validated = Validated(['a' => fn () => 1, 'c' => fn () => 2])
            ->toEither(ValueObject::class);

        assertInstanceOf(Failure::class, $validated);
        assertInstanceOf(BecauseError::class, $validated->reason);
        assertEquals('Unknown named parameter $c', $validated->reason);
    }
}
