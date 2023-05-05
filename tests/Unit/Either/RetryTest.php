<?php

declare(strict_types=1);

namespace j45l\Cats\Test\Unit\Either;

use Closure;
use j45l\Cats\Either\Either;
use j45l\functional\Sequences\FibonacciSequence;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\Cats\Either\BecauseException;
use function j45l\Cats\Either\Failure;
use function j45l\Cats\Either\retry;
use function j45l\Cats\Either\Success;
use function PHPUnit\Framework\assertEquals;

final class RetryTest extends TestCase
{
    /**
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     * @return mixed[]
     */
    public static function successDataProvider(): array
    {
        return [
            'First try' => [1, Success(42), [1], [], [false]],
            'Second try' => [2, Success(42), [1, 2], [2.0], [false, false]],
            'Third try' => [3, Success(42), [1, 2, 3], [2.0, 3.0], [false, false, true]],
            'Failure' => [
                4,
                Failure(BecauseException(new RuntimeException('Failure'))),
                [1, 2, 3],
                [2.0, 3.0],
                [false, false, true]
            ],
        ];
    }

    /**
     * @param Either<int> $expectedResult
     * @param int[] $expectedTries
     * @param float[] $expectedDelays
     * @param bool[] $expectedLastTries
     *
     * @return void
     */
    #[DataProvider('successDataProvider')]
    public function testSuccessOn(
        int $succeedAt,
        Either $expectedResult,
        array $expectedTries,
        array $expectedDelays,
        array $expectedLastTries
    ): void {
        $delays = [];
        $tryCalled = [];
        $lastTryCalled = [];

        $either = retry(
            $this->try($succeedAt, $tryCalled, $lastTryCalled),
            3,
            FibonacciSequence::create(2),
            $this->sleep($delays)
        );

        assertEquals($expectedResult, $either);
        assertEquals($expectedTries, $tryCalled);
        assertEquals($expectedLastTries, $lastTryCalled);
        assertEquals($expectedDelays, $delays);
    }

    /**
     * @param float[] $delayTimes;
     * @return Closure(float):void
     */
    private function sleep(array &$delayTimes): Closure
    {
        return static function (float $time) use (&$delayTimes): void {
            $delayTimes[] = $time;
        };
    }

    /**
     * @param int[] $tryCalled
     * @param bool[] $lastTryCalled
     * @return Closure(int, bool): float
     */
    public function try(int $succeedAt, array &$tryCalled, array &$lastTryCalled): Closure
    {
        return static function (int $try, bool $lastTry) use (&$tryCalled, &$lastTryCalled, $succeedAt): int {
            $tryCalled[] = $try;
            $lastTryCalled[] = $lastTry;

            return match (true) {
                count($tryCalled) === $succeedAt => 42,
                default => throw new RuntimeException('Failure')
            };
        };
    }
}
