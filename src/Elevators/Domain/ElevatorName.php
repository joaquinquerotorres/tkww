<?php

declare(strict_types=1);

namespace App\Elevators\Domain;

use App\Shared\Domain\ValueObject\StringValueObject;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

final class ElevatorName extends StringValueObject
{
    private const ELEVATOR_1_NAME = 'Elevator*1*';
    private const ELEVATOR_2_NAME = 'Elevator*2*';
    private const ELEVATOR_3_NAME = 'Elevator*3*';
    private const ELEVATOR_VALID_NAMES = [
        self::ELEVATOR_1_NAME,
        self::ELEVATOR_2_NAME,
        self::ELEVATOR_3_NAME,
    ];

    public function __construct(protected string $value)
    {
        $this->validateName($value);

        parent::__construct($value);
    }

    public static function create(string $value): ElevatorName
    {
        return new ElevatorName($value);
    }

    private function validateName(string $value): void
    {
        if (!in_array($value, self::ELEVATOR_VALID_NAMES, )) {
            throw new InvalidArgumentException('The name of the elevator is incorrect');
        }
    }
}
