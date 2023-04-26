<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either;

use j45l\Cats\Either\Either;
use j45l\Cats\Either\Failure;
use j45l\Cats\Either\Success;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\Cats\Either\BecauseException;
use function j45l\Cats\Either\doTry;
use function j45l\Cats\Either\isFailure;
use function j45l\Cats\Either\isSuccess;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Either::class)]
#[CoversFunction('\j45l\Cats\Either\doTry')]
final class EitherTest extends TestCase
{
    public function testCreatingFromNonExceptioningCallable(): void
    {
        $success = doTry(static fn () => 42);

        assertTrue(isSuccess($success));
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        assertEquals(42, $success->get());
    }

    public function testMappingValue(): void
    {
        $success = doTry(static fn () => 41)->map(fn ($x) => $x + 1);

        assertTrue(isSuccess($success));
        self::assertInstanceOf(Success::class, $success);
        assertEquals(42, $success->get());
    }

    public function testMappingFailure(): void
    {
        $success = doTry(static fn () => throw new RuntimeException())->map(fn ($x) => $x + 1);

        assertTrue(isFailure($success));
        self::assertInstanceOf(Failure::class, $success);
    }

    public function testCreatingFromExceptioningCallable(): void
    {
        /** @var Failure<mixed> $try */
        $try = doTry(static fn () => throw new RuntimeException('Exception'));

        self::assertTrue(isFailure($try));
        assertEquals(BecauseException(new RuntimeException('Exception')), $try->reason);
    }
}
