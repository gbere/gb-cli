<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessTreeCommand extends Command
{
    const COMMAND = 'pstree';
    const ERROR = 'Oops! something went wrong';

    protected function configure()
    {
        $this->setName('process:tree')
            ->setDescription('Display a tree of processes')
            ->setHelp('Shows running processes as a tree. The tree is rooted at either pid or init if pid is omitted.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = (new Process(self::COMMAND))->setTty(true);
        if (
            OutputInterface::VERBOSITY_VERY_VERBOSE === $output->getVerbosity() ||
            OutputInterface::VERBOSITY_DEBUG === $output->getVerbosity()
        ) {
            $helper = $this->getHelper('process');
            $helper->run($output, $process, self::ERROR);

            return;
        }

        $process->run();
        if (false === $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output->writeln($process->getOutput());
    }
}
