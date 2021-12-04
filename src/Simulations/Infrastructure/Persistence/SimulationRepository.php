<?php

declare(strict_types=1);

namespace App\Simulations\Infrastructure\Persistence;

use App\Elevators\Domain\Elevator;
use App\Sequences\Domain\Sequence;
use App\Shared\Domain\Floors\Floor;
use App\Simulations\Domain\Simulation;
use App\Simulations\Domain\SimulationRepository as Repository;

final class SimulationRepository implements Repository
{
    private \DateTime $startHour;
    private \DateTime $endHour;
    private \DateInterval $interval;
    private array $sequences;
    private array $elevators;

    public function __construct()
    {
        $this->startHour = \DateTime::createFromFormat('H:i', '09:00');
        $this->endHour = \DateTime::createFromFormat('H:i', '20:00');
        $this->interval = new \DateInterval('P0YT1M');

        $this->elevators[] = Elevator::create('Elevator*1*');
        $this->elevators[] = Elevator::create('Elevator*2*');
        $this->elevators[] = Elevator::create('Elevator*3*');

        $this->sequences[] = Sequence::create(
            \DateTime::createFromFormat('H:i', '09:00'),
            \DateTime::createFromFormat('H:i', '11:00'),
            new \DateInterval('PT5M'),
            [Floor::create(0)],
            [Floor::create(2)]
        );
        $this->sequences[] = Sequence::create(
            \DateTime::createFromFormat('H:i', '09:00'),
            \DateTime::createFromFormat('H:i', '10:00'),
            new \DateInterval('PT10M'),
            [Floor::create(0)],
            [Floor::create(1)]
        );
        $this->sequences[] = Sequence::create(
            \DateTime::createFromFormat('H:i', '11:00'),
            \DateTime::createFromFormat('H:i', '18:20'),
            new \DateInterval('PT20M'),
            [Floor::create(0)],
            [
                Floor::create(1),
                Floor::create(2),
                Floor::create(3),
            ]
        );
        $this->sequences[] = Sequence::create(
            \DateTime::createFromFormat('H:i', '14:00'),
            \DateTime::createFromFormat('H:i', '15:00'),
            new \DateInterval('PT4M'),
            [
                Floor::create(1),
                Floor::create(2),
                Floor::create(3),
            ],
            [Floor::create(0)]
        );
    }

    public function get(): Simulation
    {
        return Simulation::create(
            $this->startHour,
            $this->endHour,
            $this->interval,
            $this->elevators,
            $this->sequences
        );
    }
}
