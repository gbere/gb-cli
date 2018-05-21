<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class NetInfoCommand extends Command
{
    protected function configure()
    {
        $this->setName('net:info')
            ->setDescription('Network information')
            ->setHelp('Network information (Tested on OSX)')
            ->addOption('host', 'H', InputOption::VALUE_NONE, 'Shows local host name')
            ->addOption('ip', 'i', InputOption::VALUE_NONE, 'Shows local IP')
            ->addOption('ip-public', 'I', InputOption::VALUE_NONE, 'Shows public IP')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('host')) {
            $output->writeln($output->writeln($this->getOsxHostName()));
        }
        if ($input->getOption('ip')) {
            $output->writeln($output->writeln($this->getOsxLocalIp()));
        }
        if ($input->getOption('ip-public')) {
            $output->writeln($output->writeln($this->getOsxPublicIp()));
        }
        if (
            false === $input->getOption('host') &&
            false === $input->getOption('ip') &&
            false === $input->getOption('ip-public')
        ) {
            $output->writeln($this->getInfo());
        }
    }

    private function getInfo(): array
    {
        return [
            'Host name: '.$this->getOsxHostName(),
            'Local IP : '.$this->getOsxLocalIp(),
            'Public IP: '.$this->getOsxPublicIp(),
        ];
    }

    private function getOsxLocalIp(): string
    {
        $process = new Process(
            'echo $(ifconfig $(echo $(route -n get 0.0.0.0 | awk \'/interface: / {print $2}\')) | awk \'/inet / {print $2}\')'
        );
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return trim($process->getOutput());
    }

    private function getOsxPublicIp(): string
    {
        $process = new Process(
            'echo $(dig +short myip.opendns.com @resolver1.opendns.com)'
        );
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return trim($process->getOutput());
    }

    private function getOsxHostName(): string
    {
        $process = new Process(
            'echo $(hostname | sed \'s/.local//g\')'
        );
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return trim($process->getOutput());
    }
}
