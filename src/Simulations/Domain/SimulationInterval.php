<?php

declare(strict_types=1);

namespace App\Simulations\Domain;

use App\Shared\Domain\ValueObject\DateIntervalValueObject;

final class SimulationInterval extends DateIntervalValueObject
{
    public function __construct(protected \DateInterval $value)
    {
        parent::__construct($value);
    }

    public static function create(\DateInterval $value): SimulationInterval
    {
        return new SimulationInterval($value);
    }
}
