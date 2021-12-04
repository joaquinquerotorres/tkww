<?php

declare(strict_types=1);

namespace App\Simulations\Application\DoSimulation;

use App\Elevators\Domain\Elevator;
use App\Logs\Domain\Log;
use App\Sequences\Domain\Sequence;
use App\Shared\Domain\Elevators\Elevators;
use App\Shared\Domain\Floors\Floor;
use App\Shared\Domain\Floors\Floors;
use App\Shared\Domain\Logs\Logs;
use App\Shared\Domain\Sequences\Sequences;
use App\Simulations\Domain\Simulation;
use App\Simulations\Domain\SimulationRepository;

final class SimulationDoSimulation
{
    public function __construct(private SimulationRepository $repository)
    {
    }

    public function __invoke(): Simulation
    {
        $simulation = $this->repository->get();
        $sequences = $simulation->sequences();
        $elevators = $simulation->elevators();
        $startHour = $simulation->startHour();
        $endHour = $simulation->endHour();
        $interval = $simulation->interval();
        $logs = [];

        $period = new \DatePeriod($startHour->value(), $interval->value(), $endHour->value());

        /** @var \DateTime $timeSlot */
        foreach ($period as $timeSlot) {
            $sequencesToExecute = $this->getSequencesToExecute($sequences, $timeSlot);
            if (!empty($sequencesToExecute)) {
                /** @var Sequence $sequence */
                foreach ($sequencesToExecute as $sequence) {
                    /** @var Floor $fromFloor */
                    foreach ($sequence->fromFloors() as $fromFloor) {
                        $elevator = $this->searchAvalibleElevator($fromFloor, $elevators);

                        $elevatorSelected = Elevator::create(
                            $elevator->name()->value(),
                            $this->getLastFloor($sequence->toFloors()),
                            $this->countTravels($sequence->toFloors(), $elevator->currentFloor()) + $elevator->totalTraveledFloors()->value()
                        );

                        $elevators = $this->getListElevatorsUpdated($elevators, $elevatorSelected);
                    }
                }
            }

            $logs = $this->getLogsEverySlot($timeSlot, $elevators, $logs);
        }

        return new Simulation(
            $simulation->startHour(),
            $simulation->endHour(),
            $simulation->interval(),
            $simulation->elevators(),
            $simulation->sequences(),
            Logs::create($logs)
        );
    }

    private function getLogsEverySlot(\DateTime $timeSlot, Elevators $elevators, array $logs): array
    {
        foreach ($elevators as $elevator) {
            $logs[] =
            Log::create(
                $timeSlot,
                \sprintf(
                    'Elevator %s:, Floor: %d, TotalFloorsTraveled: %d',
                    $elevator->name()->value(),
                    $elevator->currentFloor()->value(),
                    $elevator->totalTraveledFloors()->value()
                )
            );
        }

        return $logs;
    }

    private function getLastFloor(Floors $floors): int
    {
        $array = $floors->getIterator()->getArrayCopy();

        return end($array)->value();
    }

    private function countTravels(Floors $floors, Floor $currentFloor): int
    {
        $totalTraveledFloors = 0;
        /** @var Floor $floor */
        foreach ($floors as $floor) {
            $totalTraveledFloors += abs($floor->value() - $currentFloor->value());
            $currentFloor = Floor::create(
                $floor->value()
            );
        }

        return $totalTraveledFloors;
    }

    private function getListElevatorsUpdated(Elevators $elevators, Elevator $elevatorUpdated): Elevators
    {
        $newElevatorsList = [];
        /** @var Elevator $elevator */
        foreach ($elevators as $elevator) {
            if ($elevator->name()->value() === $elevatorUpdated->name()->value()) {
                $newElevatorsList[] = $elevatorUpdated;
            } else {
                $newElevatorsList[] = $elevator;
            }
        }

        return Elevators::create($newElevatorsList);
    }

    private function searchAvalibleElevator(Floor $fromFloor, Elevators $elevators): Elevator
    {
        /** @var Elevator $elevator */
        foreach ($elevators as $elevator) {
            if ($elevator->currentFloor()->value() === $fromFloor->value()) {
                return $elevator;
            }
        }

        // NO ELEVATOR, TAKE THE FIRST ONE ELEVATOR
        $items = $elevators->getIterator()->getArrayCopy();
        $random = array_rand($items, 1);

        return $items[$random];
    }

    private function getSequencesToExecute(Sequences $sequences, $timeSlot): array
    {
        $sequencesToExecute = [];
        foreach ($sequences as $sequence) {
            if ($this->checkSequence($sequence, $timeSlot)) {
                $sequencesToExecute[] = $sequence;
            }
        }

        return $sequencesToExecute;
    }

    private function checkSequence(Sequence $sequence, \DateTime $timeSlot): bool
    {
        if (
            strtotime($sequence->startHour()->value()->format('H:i')) <= strtotime($timeSlot->format('H:i')) &&
            strtotime($sequence->endHour()->value()->format('H:i')) >= strtotime($timeSlot->format('H:i')) &&
            $timeSlot->format('i') % $sequence->interval()->value()->i === 0
        ) {
            return true;
        }

        return false;
    }
}
