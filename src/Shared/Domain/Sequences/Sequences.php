<?php

declare(strict_types=1);

namespace App\Shared\Domain\Sequences;

use App\Sequences\Domain\Sequence;
use App\Shared\Domain\Collection;

final class Sequences extends Collection
{
    protected function type(): string
    {
        return Sequence::class;
    }

    public static function create(array $items): Sequences
    {
        return new Sequences($items);
    }
}
