<?php

declare(strict_types=1);

namespace App\Simulations\Domain;

use App\Shared\Domain\ValueObject\DateTimeValueObject;

final class SimulationEndHour extends DateTimeValueObject
{
    public function __construct(protected \DateTime $value)
    {
        parent::__construct($value);
    }

    public static function create(\DateTime $value): SimulationEndHour
    {
        return new SimulationEndHour($value);
    }
}
