<?php

declare(strict_types=1);

namespace App\Tests\Elevators\Domain;

use App\Elevators\Domain\Elevator;
use PHPUnit\Framework\TestCase;

final class ElevatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider getElevators
     */
    public function adNew(string $name, ?int $currentFloor = 0, ?int $totalTraveledFloors = 0): void
    {
        $elevator = Elevator::create(
            $name,
            $currentFloor,
            $totalTraveledFloors
        );

        $this->assertInstanceOf(Elevator::class, $elevator);
    }

    public function getElevators(): \Generator
    {
        yield 'only name' => ['Elevator*1*'];

        yield 'name + current floor' => ['Elevator*1*', 1];

        yield 'full' => ['Elevator*1*', 1, 1, 1];
    }

    /**
     * @test
     */
    public function adNewWithIncorrectName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The name of the elevator is incorrect');

        $elevator = Elevator::create(
            'Test',
            1,
            2
        );
    }
}
