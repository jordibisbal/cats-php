<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Maybe;

use j45l\Cats\Maybe\None;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\Cats\Either\BecauseNone;
use function j45l\Cats\Either\Failure;
use function j45l\Cats\Either\Success;
use function j45l\Cats\Maybe\isNone;
use function j45l\Cats\Maybe\None;
use function j45l\Cats\Maybe\Some;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(None::class)]
#[CoversFunction(None::class)]
#[CoversFunction('j45l\Cats\Maybe\isNone')]
final class NoneTest extends TestCase
{
    public function testOrElseFromNone(): void
    {
        assertEquals(Some(42), None()->orElse(fn () => 42));
    }

    public function testGetOrElseFromNone(): void
    {
        assertEquals(42, None()->getOrElse(42));
    }

    public function testAndThenFromNone(): void
    {
        assertInstanceOf(None::class, None()->andThen(fn () => 42));
    }

    public function testNoneGetOrFailFails(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('getOrFail() called upon a Left object (j45l\Cats\Maybe\None).');

        None()->getOrFail();
    }

    public function testNoneGetOrFailWithMessageFails(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Message.');

        None()->getOrFail('Message.');
    }

    public function testOrElseTryFromNone(): void
    {
        assertEquals(Success(42), None()->orElseTry(fn () => 42));
    }

    public function testAndThenTryFromNone(): void
    {
        assertEquals(Failure(BecauseNone()), None()->andThenTry(fn () => 42));
    }

    public function testCanBeMapped(): void
    {
        assertEquals(None(), None()->map(fn () => 42));
    }

    public function testSomeIsNone(): void
    {
        assertTrue(isNone(None()));
        assertFalse(isNone(Some(42)));
    }

    public function testCanGetOrNull(): void
    {
        assertEquals(null, None()->getOrNull());
    }
}
