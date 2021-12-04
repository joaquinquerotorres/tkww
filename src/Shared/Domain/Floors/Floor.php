<?php

declare(strict_types=1);

namespace App\Shared\Domain\Floors;

use App\Shared\Domain\ValueObject\IntValueObject;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

final class Floor extends IntValueObject
{
    private const MAX_FLOORS_NUMBER = 3;

    public function __construct(protected int $value)
    {
        $this->validateFloor($value);

        parent::__construct($value);
    }

    public static function create(int $value): Floor
    {
        return new Floor($value);
    }

    private function validateFloor(int $value): void
    {
        if ($value > self::MAX_FLOORS_NUMBER || $value < 0) {
            throw new InvalidArgumentException('The value of the floor is incorrect');
        }
    }
}
