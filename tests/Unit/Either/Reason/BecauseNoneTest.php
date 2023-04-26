<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either\Reason;

use j45l\Cats\Either\Reason\BecauseNone;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use RuntimeException;
use j45l\Cats\Either\Reason\BecauseException;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Either\BecauseNone;
use function PHPUnit\Framework\assertEquals;

#[CoversClass(BecauseNone::class)]
#[CoversFunction('\j45l\Cats\Either\BecauseNone')]
final class BecauseNoneTest extends TestCase
{
    public function testExceptionCanBeCastedToString(): void
    {
        assertEquals('Because None', BecauseNone());
        assertEquals('Because None', BecauseNone::create()->toString());
    }

    public function testCanBeCastedToString(): void
    {
        assertEquals('Exception', BecauseException::of(new RuntimeException('Exception')));
        assertEquals('Exception', BecauseException::of(new RuntimeException('Exception'))
            ->toString());
    }
}
