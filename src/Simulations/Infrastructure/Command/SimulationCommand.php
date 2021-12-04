<?php

declare(strict_types=1);

namespace App\Simulations\Infrastructure\Command;

use App\Logs\Domain\Log;
use App\Simulations\Application\DoSimulation\SimulationDoSimulation;
use App\Simulations\Infrastructure\Persistence\SimulationRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SimulationCommand extends Command
{
    private SimulationDoSimulation $simulation;

    protected function configure()
    {
        $this
            ->setName('app:test')
            ->setDescription('Test command');
    }

    public function __construct(SimulationRepository $simulationRepository)
    {
        $this->simulation = new SimulationDoSimulation($simulationRepository);

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyStyle = new SymfonyStyle($input, $output);

        try {
            $symfonyStyle->info('START SIMULATION COMMAND');

            $simulation = $this->simulation->__invoke();

            /** @var Log $log */
            foreach ($simulation->logs() as $log) {
                $symfonyStyle->info(
                    sprintf(
                        'Hour: %s - %s',
                        $log->hour()->value()->format('H:i'),
                        $log->message()->value()
                    )
                );
            }
        } catch (\Throwable $exception) {
            $symfonyStyle->error(sprintf('ERROR SIMULATION COMMAND: %s', $exception->getMessage()));

            return Command::FAILURE;
        }

        $symfonyStyle->success('SUCCESS SIMULATION COMMAND');

        return Command::SUCCESS;
    }
}
