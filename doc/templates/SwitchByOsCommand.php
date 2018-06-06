<?php

namespace App\Command;

use App\Util\OsInfo;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SwitchByOsCommand extends ContainerAwareCommand
{
    const COMMAND = [
        OsInfo::OSX => 'osx.sh',
        OsInfo::LINUX => 'linux.sh',
    ];
    const ERROR = 'Error when greeting d(O_o)p';
    const PATH = '/../ash/SwitchByOs/';

    protected function configure()
    {
        $this->setName('say:os')
            ->setDescription('Say hi OS user')
            ->setHelp('Amazing!!! Say hi OS user!!!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = (new Process($this->getContainer()->get('kernel')->getRootDir().self::PATH.
            self::COMMAND[(new OsInfo())->getOs()]))->setTty(Process::isTtySupported());
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
