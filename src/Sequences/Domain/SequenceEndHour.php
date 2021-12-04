<?php

declare(strict_types=1);

namespace App\Sequences\Domain;

use App\Shared\Domain\ValueObject\DateTimeValueObject;

final class SequenceEndHour extends DateTimeValueObject
{
    public function __construct(protected \DateTime $value)
    {
        parent::__construct($value);
    }

    public static function create(\DateTime $value): SequenceEndHour
    {
        return new SequenceEndHour($value);
    }
}
