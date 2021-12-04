<?php

declare(strict_types=1);

namespace App\Shared\Domain\Floors;

use App\Shared\Domain\Collection;

final class Floors extends Collection
{
    protected function type(): string
    {
        return Floor::class;
    }

    public static function create(array $items): Floors
    {
        return new Floors($items);
    }
}
