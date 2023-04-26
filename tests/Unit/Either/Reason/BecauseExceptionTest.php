<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either\Reason;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use RuntimeException;
use j45l\Cats\Either\Reason\BecauseException;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Either\BecauseException;
use function PHPUnit\Framework\assertEquals;

#[CoversClass(BecauseException::class)]
#[CoversFunction('j45l\Cats\Either\BecauseException')]
final class BecauseExceptionTest extends TestCase
{
    public function testExceptionCanBeRetrieved(): void
    {
        assertEquals(
            new RuntimeException('Exception'),
            BecauseException(new RuntimeException('Exception'))->exception
        );
    }

    public function testCanBeCastedToString(): void
    {
        assertEquals('Exception', BecauseException::of(new RuntimeException('Exception')));
        assertEquals('Exception', BecauseException::of(new RuntimeException('Exception'))
            ->toString());
    }
}
