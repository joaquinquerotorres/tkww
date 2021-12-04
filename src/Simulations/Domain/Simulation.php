<?php

declare(strict_types=1);

namespace App\Simulations\Domain;

use App\Shared\Domain\Elevators\Elevators;
use App\Shared\Domain\Logs\Logs;
use App\Shared\Domain\Sequences\Sequences;

final class Simulation
{
    public function __construct(
        private SimulationStartHour $startHour,
        private SimulationEndHour $endHour,
        private SimulationInterval $interval,
        private Elevators $elevators,
        private Sequences $sequences,
        private ?Logs $logs = null,
    ) {
    }

    public static function create(
        \DateTime $starHour,
        \DateTime $endHour,
        \DateInterval $interval,
        array $elevators,
        array $sequences,
        ?array $logs = null,
    ) {
        return new Simulation(
            SimulationStartHour::create($starHour),
            SimulationEndHour::create($endHour),
            SimulationInterval::create($interval),
            Elevators::create($elevators),
            Sequences::create($sequences),
            Logs::create($logs)
        );
    }

    public function startHour(): SimulationStartHour
    {
        return $this->startHour;
    }

    public function endHour(): SimulationEndHour
    {
        return $this->endHour;
    }

    public function interval(): SimulationInterval
    {
        return $this->interval;
    }

    public function elevators(): Elevators
    {
        return $this->elevators;
    }

    public function sequences(): Sequences
    {
        return $this->sequences;
    }

    public function logs(): Logs
    {
        return $this->logs;
    }
}
