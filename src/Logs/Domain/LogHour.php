<?php

declare(strict_types=1);

namespace App\Logs\Domain;

use App\Shared\Domain\ValueObject\DateTimeValueObject;

final class LogHour extends DateTimeValueObject
{
    public function __construct(protected \DateTime $value)
    {
        parent::__construct($value);
    }

    public static function create(\DateTime $value): LogHour
    {
        return new LogHour($value);
    }
}
