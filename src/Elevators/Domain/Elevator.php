<?php

declare(strict_types=1);

namespace App\Elevators\Domain;

use App\Shared\Domain\Floors\Floor;

final class Elevator
{
    public function __construct(
        private ElevatorName $name,
        private Floor $currentFloor,
        private ElevatorTotalTraveledFloors $totalTraveledFloors,
    ) {
    }

    public static function create(
        string $name,
        ?int $currentFloor = 0,
        ?int $totalTraveledFloors = 0
    ) {
        return new Elevator(
            ElevatorName::create($name),
            Floor::create($currentFloor),
            ElevatorTotalTraveledFloors::create($totalTraveledFloors),
        );
    }

    public function name(): ElevatorName
    {
        return $this->name;
    }

    public function currentFloor(): Floor
    {
        return $this->currentFloor;
    }

    public function totalTraveledFloors(): ElevatorTotalTraveledFloors
    {
        return $this->totalTraveledFloors;
    }
}
