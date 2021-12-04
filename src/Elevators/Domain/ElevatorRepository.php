<?php

declare(strict_types=1);

namespace App\Elevators\Domain;

use App\Shared\Domain\Elevators\Elevators;

interface ElevatorRepository
{
    public function all(): Elevators;
}
