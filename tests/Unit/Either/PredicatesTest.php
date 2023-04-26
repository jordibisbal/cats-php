<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Either\Because;
use function j45l\Cats\Either\Failure;
use function j45l\Cats\Either\isEither;
use function j45l\Cats\Either\isFailure;
use function j45l\Cats\Either\isSuccess;
use function j45l\Cats\Either\Success;
use function j45l\Cats\Maybe\None;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

#[CoversFunction('\j45l\Cats\Either\isSuccess')]
#[CoversFunction('\j45l\Cats\Either\isEither')]
#[CoversFunction('\j45l\Cats\Either\isFailure')]
final class PredicatesTest extends TestCase
{
    public function testIsSuccess(): void
    {
        assertTrue(isSuccess(Success(42)));
        /** @phpstan-ignore-next-line */
        assertFalse(isSuccess(Failure(Because('Yes'))));
    }

    public function testIsFailure(): void
    {
        assertFalse(isFailure(Success(42)));
        assertTrue(isFailure(Failure(Because('Yes'))));
    }

    public function testIsEither(): void
    {
        assertTrue(isEither(Success(42)));
        assertTrue(isEither(Failure(Because('Yes'))));
        /** @phpstan-ignore-next-line */
        assertFalse(isSuccess(None()));
    }
}
