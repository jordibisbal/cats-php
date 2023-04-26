<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either;

use j45l\Cats\Either\Success;
use j45l\Cats\Maybe\None;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Either\Because;
use function j45l\Cats\Either\Failure;
use function j45l\Cats\Either\Success;
use function j45l\Cats\Maybe\None;
use function j45l\Cats\Maybe\Some;
use function PHPUnit\Framework\assertEquals;

#[CoversClass(Success::class)]
#[CoversClass(None::class)]
final class EitherMaybeTest extends TestCase
{
    public function testAndThenFromSuccess(): void
    {
        assertEquals(Some(42), Success(42)->toMaybe());
    }

    public function testAndThenFromFailure(): void
    {
        assertEquals(None(), Failure(Because('Yes'))->toMaybe());
    }
}
