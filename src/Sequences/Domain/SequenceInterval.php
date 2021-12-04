<?php

declare(strict_types=1);

namespace App\Sequences\Domain;

use App\Shared\Domain\ValueObject\DateIntervalValueObject;

final class SequenceInterval extends DateIntervalValueObject
{
    public function __construct(protected \DateInterval $value)
    {
        parent::__construct($value);
    }

    public static function create(\DateInterval $value): SequenceInterval
    {
        return new SequenceInterval($value);
    }
}
