<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either\Reason;

use j45l\Cats\Either\Reason\Because;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\Cats\Either\Because;
use function PHPUnit\Framework\assertEquals;

#[CoversClass(Because::class)]
#[CoversFunction('\j45l\Cats\Either\Because')]
final class BecauseTest extends TestCase
{
    public function testReasonCanBeRetrievedByCastingToString(): void
    {
        assertEquals('Reason', Because('Reason'));
        assertEquals('Reason', Because::of('Reason')->toString());
        assertEquals('Reason', Because::of('Reason')->reason);
    }

    public function testASubjectCanBeAttachedToAReason(): void
    {
        $target = (object)['who' => 'target'];

        $reason = Because::of('Reason')->on($target);
        assertEquals($target, $reason->subject());
    }
}
