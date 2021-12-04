<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class DateIntervalValueObject
{
    public function __construct(protected \DateInterval $value)
    {
    }

    public function value(): \DateInterval
    {
        return $this->value;
    }
}
