<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class NetStatCommand extends Command
{
    protected function configure()
    {
        $this->setName('net:stat')
            ->setDescription('List all network connections')
            ->setHelp('You can list all the network connections opened')
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getConnections());
    }

    private function getConnections(): string
    {
        $process = new Process([
            'lsof', '-i',
        ]);
        $process->run();
        if (false === $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return trim($process->getOutput());
    }
}