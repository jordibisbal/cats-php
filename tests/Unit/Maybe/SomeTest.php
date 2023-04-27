<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Maybe;

use j45l\Cats\Maybe\Some;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Maybe\isNone;
use function j45l\Cats\Maybe\isSome;
use function j45l\Cats\Maybe\Some;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Some::class)]
#[CoversFunction(Some::class)]
#[CoversFunction('j45l\Cats\Maybe\isSome')]
final class SomeTest extends TestCase
{
    public function testOrElseFromSome(): void
    {
        assertEquals(Some(42), Some(42)->orElse(fn () => 1));
    }

    public function testGetOrElseFromSome(): void
    {
        assertEquals(42, Some(42)->getOrElse(1));
    }

    public function testGetOrNullFromSome(): void
    {
        assertEquals(42, Some(42)->getOrNull());
    }

    public function testGetOrFailsReturnsValue(): void
    {
        assertEquals(42, Some(42)->getOrFail());
    }

    public function testAndThenFromSome(): void
    {
        assertEquals(Some(42), Some(1)->andThen(fn () => 42));
    }

    public function testMapFromSome(): void
    {
        assertEquals(Some(42), Some(21)->map(fn ($x) => $x * 2));
    }

    public function testSomeIsSome(): void
    {
        assertTrue(isSome(Some(42)));
        assertFalse(isNone(Some(42)));
    }
}
