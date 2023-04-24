<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Maybe;

use j45l\Cats\Maybe\None;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\Cats\Either\BecauseNull;
use function j45l\Cats\Either\Failure;
use function j45l\Cats\Either\Success;
use function j45l\Cats\Maybe\None;
use function j45l\Cats\Maybe\Some;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

/** @covers \j45l\Cats\Maybe\None */
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
        assertEquals(Failure(BecauseNull()), None()->andThenTry(fn () => 42));
    }
}