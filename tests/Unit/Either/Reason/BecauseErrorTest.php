<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either\Reason;

use Error;
use j45l\Cats\Either\Reason\BecauseError;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Either\BecauseError;
use function PHPUnit\Framework\assertEquals;

#[CoversClass(BecauseError::class)]
#[CoversFunction('j45l\Cats\Either\BecauseError')]
final class BecauseErrorTest extends TestCase
{
    public function testExceptionCanBeRetrieved(): void
    {
        assertEquals(new Error('Error'), BecauseError(new Error('Error'))->error);
    }

    public function testCanBeCastedToString(): void
    {
        assertEquals('Error', BecauseError::of(new Error('Error')));
        assertEquals('Error', BecauseError::of(new Error('Error'))
            ->toString());
    }
}
