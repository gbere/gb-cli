<?php

namespace App\Command;

use App\Util\OsInfo;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SystemInformationCommand extends ContainerAwareCommand
{
    const COMMAND = [
        OsInfo::OSX => 'osx.sh',
        OsInfo::LINUX => 'linux.sh',
    ];
    const ERROR = 'Oops! something went wrong';

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('system:information')
            ->setDescription('List all human readable mount points')
            ->setHelp('List all human readable mount points')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $process = (new Process(
            $this->getContainer()->get('kernel')->getRootDir().
            '/../ash/SystemInformation/'.
            self::COMMAND[(new OsInfo())->getOs()]))
            ->setTty(Process::isTtySupported());
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
