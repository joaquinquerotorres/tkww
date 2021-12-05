<?php

declare(strict_types=1);

namespace App\Tests\Simulations\Domain;

use App\Elevators\Domain\Elevator;
use App\Sequences\Domain\Sequence;
use App\Shared\Domain\Floors\Floor;
use App\Simulations\Domain\Simulation;
use PHPUnit\Framework\TestCase;

final class SimulationTest extends TestCase
{
    /**
     * @test
     */
    public function adNew(): void
    {
        $simulation =
            Simulation::create(
                \DateTime::createFromFormat('H:i', '09:00'),
                \DateTime::createFromFormat('H:i', '20:00'),
                new \DateInterval('PT40M'),
                [Elevator::create('Elevator*1*')],
                [Sequence::create(
                    \DateTime::createFromFormat('H:i', '09:00'),
                    \DateTime::createFromFormat('H:i', '11:00'),
                    new \DateInterval('PT5M'),
                    [Floor::create(0)],
                    [Floor::create(2)]
                )]
        );

        $this->assertInstanceOf(Simulation::class, $simulation);
    }

    /**
     * @test
     */
    public function adNewErrorElevator(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The name of the elevator is incorrect');

        $simulation =
            Simulation::create(
                \DateTime::createFromFormat('H:i', '09:00'),
                \DateTime::createFromFormat('H:i', '20:00'),
                new \DateInterval('PT40M'),
                [Elevator::create('Elevator*10*')],
                [Sequence::create(
                    \DateTime::createFromFormat('H:i', '09:00'),
                    \DateTime::createFromFormat('H:i', '11:00'),
                    new \DateInterval('PT5M'),
                    [Floor::create(0)],
                    [Floor::create(2)]
                )]
            );

        $this->assertInstanceOf(Simulation::class, $simulation);
    }

    /**
     * @test
     */
    public function adNewErrorFloor(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value of the floor is incorrect');

        $simulation =
            Simulation::create(
                \DateTime::createFromFormat('H:i', '09:00'),
                \DateTime::createFromFormat('H:i', '20:00'),
                new \DateInterval('PT40M'),
                [Elevator::create('Elevator*1*')],
                [Sequence::create(
                    \DateTime::createFromFormat('H:i', '09:00'),
                    \DateTime::createFromFormat('H:i', '11:00'),
                    new \DateInterval('PT5M'),
                    [Floor::create(10)],
                    [Floor::create(2)]
                )]
            );

        $this->assertInstanceOf(Simulation::class, $simulation);
    }
}
