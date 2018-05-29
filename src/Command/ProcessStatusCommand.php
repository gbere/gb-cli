<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessStatusCommand extends Command
{
    protected function configure()
    {
        $this->setName('process:status')
            ->setDescription('List all process (sudo required)')
            ->setHelp('List all the process')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getProcessStat());
    }

    private function getProcessStat(): string
    {
        $process = (new Process([
            'sudo', 'ps', 'axu',
        ]))->setTty(true);
        $process->run();
        if (false === $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
