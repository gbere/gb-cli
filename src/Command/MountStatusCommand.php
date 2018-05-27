<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MountStatusCommand extends Command
{
    protected function configure()
    {
        $this->setName('mount:status')
            ->setDescription('List all mount points')
            ->setHelp('List all the mount points')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getMountPoints());
    }

    private function getMountPoints(): string
    {
        $process = new Process([
            'df', '-a',
        ]);
        $process->run();
        if (false === $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
