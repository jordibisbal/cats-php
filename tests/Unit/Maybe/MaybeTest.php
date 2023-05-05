<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Maybe;

use j45l\Cats\Maybe\None;
use j45l\Cats\Maybe\Some;
use j45l\Cats\Maybe\Maybe;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Either\Success;
use function j45l\Cats\Maybe\Maybe;
use function j45l\Cats\Maybe\None;
use function j45l\Cats\Maybe\Some;
use function j45l\functional\identity;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

#[CoversClass(Maybe::class)]
#[CoversFunction(Maybe::class)]
final class MaybeTest extends TestCase
{
    public function testCreatingFromNonNullOf(): void
    {
        $some = Maybe::of(42);

        assertInstanceOf(Some::class, $some);
        assertEquals(42, $some->get());
    }

    public function testCreatingFromNonNullOfNullable(): void
    {
        $some = Maybe(42);

        assertInstanceOf(Some::class, $some);
        assertEquals(42, $some->get());
    }

    public function testCreatingFromNullOfNullable(): void
    {
        assertInstanceOf(None::class, Maybe(null));
    }

    public function testCanChainWithEitherForSuccess(): void
    {
        assertEquals(
            Success(42),
            Some(41)->try(fn ($x) => $x + 1)
        );
    }

    public function testCanChainWithEitherForNone(): void
    {
        assertEquals(
            Success(null),
            None()->try(identity(...))
        );
    }

    public function testMapsForNone(): void
    {
        assertEquals(
            None(),
            None()->map(identity(...))
        );
    }

    public function testMapsForSome(): void
    {
        assertEquals(
            Some(42),
            Some(41)->map(fn ($x) => $x + 1)
        );
    }
}
