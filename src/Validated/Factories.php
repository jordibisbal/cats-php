<?php

declare(strict_types=1);

namespace j45l\Cats\Validated;

use Closure;

/** @param Closure[] $validations */
function Validated(array $validations): Validated
{
    return Validated::create($validations);
}
