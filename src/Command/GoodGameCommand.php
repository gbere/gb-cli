<?php

namespace App\Command;

use App\Util\OsInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
        $command = [
            ['echo', 'hola h'],
            ['grep', 'hola'],
        ];
        $out = null;

        for ($i = 0; $i < count($command); ++$i) {
            $process = new Process(
                $command[$i],
            null,
            null,
                $out
            );
            $process->run();
            if (false === $process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            $out = $process->getOutput();
        }
        $output->writeln(trim($out));

        return;

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
