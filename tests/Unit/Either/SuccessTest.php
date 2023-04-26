<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either;

use j45l\Cats\Either\Success;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\Cats\Either\Because;
use function j45l\Cats\Either\BecauseException;
use function j45l\Cats\Either\Failure;
use function j45l\Cats\Either\Success;
use function PHPUnit\Framework\assertEquals;

#[CoversClass(Success::class)]
#[CoversFunction(Success::class)]
final class SuccessTest extends TestCase
{
    public function testOrElseFromSuccess(): void
    {
        assertEquals(Success(42), Success(42)->orElse(fn () => 1));
    }

    public function testSuccessAndThenFailure(): void
    {
        assertEquals(
            Failure(Because('Failed')),
            Success(42)->andThen(fn () => Failure(Because('Failed')))
        );
    }

    public function testSuccessAndThenException(): void
    {
        assertEquals(
            Failure(BecauseException(new RuntimeException('boom'))),
            Success(42)->andThen(fn () => throw new RuntimeException('boom'))
        );
    }

    public function testSuccessAndThenSuccess(): void
    {
        assertEquals(
            Success(42),
            Success(1)->andThen(fn () => Success(42))
        );
    }

    public function testSuccessAndThenNotEither(): void
    {
        assertEquals(
            Success(42),
            Success(1)->andThen(fn () => 42)
        );
    }

    public function testSuccessAndThenIncrementSuccess(): void
    {
        assertEquals(
            Success(42),
            Success(1)->andThen(fn ($x) => Success($x + 41))
        );
    }

    public function testCanBeMapped(): void
    {
        assertEquals(Success(42), Success(41)->map(fn ($x) => $x + 1));
    }

    public function testValueCanBeRetrieved(): void
    {
        assertEquals(42, Success(42)->get());
        assertEquals(42, Success(42)->getOrElse());
        assertEquals(42, Success(42)->getOrFail());
    }
}
