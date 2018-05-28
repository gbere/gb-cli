<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class NetworkStatusCommand extends Command
{
    protected function configure()
    {
        $this->setName('network:status')
            ->setDescription('List all network connections (sudo required)')
            ->setHelp('List all the network connections opened')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getConnections());
    }

    private function getConnections(): string
    {
        $process = new Process([
            'sudo', 'lsof', '-i',
        ]);
        $process->run();
        if (false === $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return trim($process->getOutput());
    }
}
