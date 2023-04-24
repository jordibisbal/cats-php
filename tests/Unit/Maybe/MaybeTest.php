<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Maybe;

use j45l\Cats\Maybe\None;
use j45l\Cats\Maybe\Some;
use j45l\Cats\Maybe\Maybe;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Maybe\Maybe;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

/**
 * @covers  \j45l\Cats\Maybe\Maybe
 */
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
}
