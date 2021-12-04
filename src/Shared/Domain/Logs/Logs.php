<?php

declare(strict_types=1);

namespace App\Shared\Domain\Logs;

use App\Logs\Domain\Log;
use App\Shared\Domain\Collection;

final class Logs extends Collection
{
    protected function type(): string
    {
        return Log::class;
    }

    public static function create(?array $items): ?Logs
    {
        if (null === $items) {
            return null;
        }

        return new Logs($items);
    }
}
