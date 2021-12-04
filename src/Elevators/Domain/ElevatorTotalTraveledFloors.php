<?php

declare(strict_types=1);

namespace App\Elevators\Domain;

use App\Shared\Domain\ValueObject\IntValueObject;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

final class ElevatorTotalTraveledFloors extends IntValueObject
{
    public function __construct(protected int $value)
    {
        $this->validateTotalTraveledFloors($value);

        parent::__construct($value);
    }

    public static function create(int $value): ElevatorTotalTraveledFloors
    {
        return new ElevatorTotalTraveledFloors($value);
    }

    private function validateTotalTraveledFloors(int $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException('The total number of floors traveled by the elevator is incorrect');
        }
    }
}
