<?php

declare(strict_types=1);

namespace App\Tests\Simulations\Infrastructure;

use App\Elevators\Domain\Elevator;
use App\Sequences\Domain\Sequence;
use App\Shared\Domain\Floors\Floor;
use App\Simulations\Domain\Simulation;
use App\Simulations\Infrastructure\Command\SimulationCommand;
use App\Simulations\Infrastructure\Persistence\SimulationRepository;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class SimulationDoSimulationTest extends WebTestCase
{
    /**
     * @test
     */
    public function executeCommandSuccess(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('app:test');
        $commandTester = new CommandTester($command);

        $commandTester->execute(['command' => $command->getName()]);
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    /**
     * @test
     */
    public function executeCommandError(): void
    {
        $this->expectException(\Throwable::class);
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

        $simulationRepository = $this->createMock(SimulationRepository::class);
        $simulationRepository
            ->method('get')
            ->willReturn($simulation);

        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->add(new SimulationCommand($simulationRepository));
        $command = $application->find('app:test');
        $commandTester = new CommandTester($command);

        $commandTester->execute(['command' => $command->getName()]);
    }
}
