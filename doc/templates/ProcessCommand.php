<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessCommand extends Command
{
    const COMMAND = ['echo', 'hi'];
    const ERROR = 'Error when greeting d(O_o)p';

    protected function configure()
    {
        $this->setName('say:hi')
            ->setDescription('Say hi')
            ->setHelp('Amazing!!! Say hi!!!')
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
