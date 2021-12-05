<?php

declare(strict_types=1);

namespace App\Tests\Sequences\Domain;

use App\Sequences\Domain\Sequence;
use App\Shared\Domain\Floors\Floor;
use PHPUnit\Framework\TestCase;

final class SequenceTest extends TestCase
{
    /**
     * @test
     */
    public function adNew(): void
    {
        $sequence =
            Sequence::create(
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

        $this->assertInstanceOf(Sequence::class, $sequence);
    }

    /**
     * @test
     */
    public function adNewInvalidFloor(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value of the floor is incorrect');

        $sequence =
            Sequence::create(
                \DateTime::createFromFormat('H:i', '14:00'),
                \DateTime::createFromFormat('H:i', '15:00'),
                new \DateInterval('PT4M'),
                [Floor::create(10)],
                [Floor::create(0)]
            );
    }
}
