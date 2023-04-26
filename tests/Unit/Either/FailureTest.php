<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either;

use j45l\Cats\Either\Failure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\Cats\Either\Because;
use function j45l\Cats\Either\Failure;
use function j45l\Cats\Either\Success;
use function j45l\Cats\Maybe\None;
use function PHPUnit\Framework\assertEquals;

#[CoversClass(Failure::class)]
#[CoversFunction(Failure::class)]
final class FailureTest extends TestCase
{
    public function testFailureGetOrFailFails(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('getOrFail() called upon a Left object.');

        Failure(Because('yes'))->getOrFail();
    }

    public function testFailureGetOrFailWithMessageFails(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Message.');

        None()->getOrFail('Message.');
    }

    public function testOrElseSuccessFromFailure(): void
    {
        assertEquals(Success(42), Failure(Because('whatever'))->orElse(fn () => Success(42)));
    }

    public function testOrElseWrapsInSuccessFromFailure(): void
    {
        assertEquals(
            Success(Failure(Because('whatever'))),
            Failure(Because('whatever'))->orElse(fn ($x) => Success($x))
        );
    }

    public function testCanBindHappyPath(): void
    {
        assertEquals(
            Success(42),
            Success(1)->andThen(fn () => Success(42))
        );
    }

    public function testCanGetOr(): void
    {
        assertEquals(42, Failure(Because('Yes'))->getOrElse(42));
    }

    public function testReasonCanBeRetrieved(): void
    {
        assertEquals('Yes', Failure(Because('Yes'))->reason);
    }

    public function testCanBeBindWhenHappyPath(): void
    {
        assertEquals(Failure(Because('Yes')), Failure(Because('Yes'))->andThen(fn () => 42));
    }

    public function testCanBeCastedToMaybe(): void
    {
        assertEquals(None(), Failure(Because('Yes'))->toMaybe());
    }
}
