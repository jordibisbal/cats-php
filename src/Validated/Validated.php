<?php

declare(strict_types=1);

namespace j45l\Cats\Validated;

use Closure;
use j45l\Cats\Either\Either;
use j45l\Cats\Either\Failure;
use j45l\Cats\Either\Success;

use function j45l\Cats\Either\Success;
use function j45l\Cats\Either\doTry;
use function j45l\Cats\Either\isFailure;
use function j45l\Cats\Either\isSuccess;
use function j45l\functional\map;
use function j45l\functional\none;
use function j45l\functional\select;
use function j45l\functional\with;

final readonly class Validated
{
    /** @var Either<mixed>[] */
    private array $values;

    /** @param Closure[] $validations */
    private function __construct(array $validations)
    {
        $this->values = $this->evaluate($validations);
    }

    /** @param Closure[] $validations */
    public static function create(array $validations): Validated
    {
        return new self($validations);
    }

    /**
     * @param (Closure():Either<mixed>)[] $validations
     * @return Either<mixed>[]
     */
    private function evaluate(array $validations): array
    {
        return map($validations, fn (Closure $validation) => doTry($validation));
    }

    public function allValid(): bool
    {
        return none($this->failed());
    }

    /** @return Failure<mixed>[] */
    public function failed(): array
    {
        /** @phpstan-ignore-next-line */
        return select($this->values, fn (Either $validation) => isFailure($validation));
    }

    /** @return Success<mixed>[] */
    public function succeed(): array
    {
        /** @phpstan-ignore-next-line */
        return select($this->values, fn (Either $validation) => isSuccess($validation));
    }

    /** @return mixed[] */
    public function get(): array
    {
        return map($this->succeed(), fn (Success $success) => $success->get());
    }

    /**
     * @return Either<mixed>
     * @noinspection PhpUndefinedMethodInspection
     */
    public function toEither(string $valueObjectClassName = null): Either
    {
        return match (true) {
            !$this->allValid() => Failure::because(NotValidated::create($this->failed())),
            $valueObjectClassName === null => Success((object) $this->get()),
            default =>
                /** @phpstan-ignore-next-line */
                doTry(fn () => $valueObjectClassName::create(...$this->get()))
        };
    }
}
