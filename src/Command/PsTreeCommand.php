<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PsTreeCommand extends Command
{
    protected function configure()
    {
        $this->setName('ps:tree')
            ->setDescription('Display a tree of processes')
            ->setHelp('Shows running processes as a tree. The tree is rooted at either pid or init if pid is omitted.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getProcessTree());
    }

    private function getProcessTree(): string
    {
        $process = new Process([
            'pstree', '-g', '2',
        ]);
        $process->run();
        if (false === $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
