<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class DateTimeValueObject
{
    public function __construct(protected \DateTime $value)
    {
    }

    public function value(): \DateTime
    {
        return $this->value;
    }
}
