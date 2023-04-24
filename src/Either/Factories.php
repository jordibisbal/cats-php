<?php

declare(strict_types=1);

namespace j45l\Cats\Either;

use Exception;
use j45l\Cats\Either\Reason\Because;
use j45l\Cats\Either\Reason\BecauseException;
use j45l\Cats\Either\Reason\BecauseNull;
use j45l\Cats\Either\Reason\Reason;

/**
 * @template T
 * @param callable():T $fn
 * @return Either<T>
 */
function doTry(callable $fn): Either
{
    return Either::try($fn);
}

/**
 * @return Failure<mixed>
 */
function Failure(Reason $reason): Failure
{
    return Failure::because($reason);
}

/**
 * @template T
 * @param T $value
 * @return Success<T>
 */
function Success(mixed $value = null): Success
{
    return Success::pure($value);
}

function BecauseNull(): BecauseNull
{
    return BecauseNull::create();
}

function BecauseException(Exception $exception): BecauseException
{
    return BecauseException::of($exception);
}

function Because(string $reason): Because
{
    return Because::of($reason);
}
