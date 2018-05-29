<?php

namespace App\Command;

use App\Util\OsInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GoodGameCommand extends Command
{
    protected function configure()
    {
        $this->setName('good:game')
            ->setDescription('Test your under construction command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $os = new OsInfo();
        $output->writeln([
            'OS: '.$os->getOs(),
            'Name: '.$os->getName(),
            'Release: '.$os->getRelease(),
            'Mayor: '.$os->getRelMayor(),
            'Min: '.$os->getRelMinor(),
            'Path: '.$os->getRelPatch(),
            ($os::OSX === $os->getOs() ? 'osx' : 'else'),
        ]);
    }
}
