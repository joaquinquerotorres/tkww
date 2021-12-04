<?php

declare(strict_types=1);

namespace App\Sequences\Domain;

use App\Shared\Domain\Floors\Floors;

final class Sequence
{
    public function __construct(
        private SequenceStartHour $startHour,
        private SequenceEndHour $endHour,
        private SequenceInterval $interval,
        private Floors $fromFloors,
        private Floors $toFloors,
    ) {
    }

    public static function create(
        \DateTime $startHour,
        \DateTime $endHour,
        \DateInterval $interval,
        array $fromFloors,
        array $toFloors,
    ) {
        return new Sequence(
            SequenceStartHour::create($startHour),
            SequenceEndHour::create($endHour),
            SequenceInterval::create($interval),
            Floors::create($fromFloors),
            Floors::create($toFloors),
        );
    }

    public function startHour(): SequenceStartHour
    {
        return $this->startHour;
    }

    public function endHour(): SequenceEndHour
    {
        return $this->endHour;
    }

    public function interval(): SequenceInterval
    {
        return $this->interval;
    }

    public function fromFloors(): Floors
    {
        return $this->fromFloors;
    }

    public function toFloors(): Floors
    {
        return $this->toFloors;
    }
}
