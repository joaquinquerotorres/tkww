<?php

declare(strict_types=1);

namespace App\Shared\Domain\Elevators;

use App\Elevators\Domain\Elevator;
use App\Shared\Domain\Collection;

final class Elevators extends Collection
{
    protected function type(): string
    {
        return Elevator::class;
    }

    public static function create(array $items): Elevators
    {
        return new Elevators($items);
    }
}
