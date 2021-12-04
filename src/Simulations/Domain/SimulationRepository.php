<?php

declare(strict_types=1);

namespace App\Simulations\Domain;

interface SimulationRepository
{
    public function get(): Simulation;
}
