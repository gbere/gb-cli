<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class NetworkInformationCommand extends Command
{
    protected function configure()
    {
        $this->setName('network:information')
            ->setDescription('Displays network information')
            ->setHelp('Displays network network information. Host, local and public IP')
            ->addOption('host', 'H', InputOption::VALUE_NONE, 'Prints local host name')
            ->addOption('ip', 'i', InputOption::VALUE_NONE, 'Prints local IP')
            ->addOption('public-ip', 'p', InputOption::VALUE_NONE, 'Prints public IP')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('host')) {
            $output->writeln($output->writeln($this->getHostName()));
        }
        if ($input->getOption('ip')) {
            $output->writeln($output->writeln($this->getLocalIp()));
        }
        if ($input->getOption('public-ip')) {
            $output->writeln($output->writeln($this->getPublicIp()));
        }
        if (
            false === $input->getOption('host') &&
            false === $input->getOption('ip') &&
            false === $input->getOption('public-ip')
        ) {
            $output->writeln($this->getInfo());
        }
    }

    private function getInfo(): array
    {
        return [
            'Host name: '.$this->getHostName(),
            'Local IP : '.$this->getLocalIp(),
            'Public IP: '.$this->getPublicIp(),
            'Ping Goog: '.$this->getPingTime(),
        ];
    }

    private function getPingTime(): string
    {
        $process = new Process([
            'ping', '-c', '1', 'google.com',
        ]);
        $process->run();
        if (false === $process->isSuccessful()) {
            return '<comment>'.trim($process->getErrorOutput()).'</comment>>';
        }

        $return = $process->getOutput();
        $needle = 'time=';
        $posNeedle = mb_strpos($return, $needle);
        if ($posNeedle) {
            $return = mb_substr($return, $posNeedle + mb_strlen($needle));
            $posEol = mb_strpos($return, PHP_EOL);
            $return = mb_substr($return, 0, $posEol);
        }

        return '<info>'.$return.'</info>';
    }

    private function getLocalIp(): string
    {
        // TODO: refactor
        $process = new Process(
            'echo $(ifconfig $(echo $(route -n get 0.0.0.0 | awk \'/interface: / {print $2}\')) | awk \'/inet / {print $2}\')'
        );
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return '<info>'.trim($process->getOutput()).'</info>';
    }

    private function getPublicIp(): string
    {
        $process = new Process([
            'dig', '+short', 'myip.opendns.com', '@resolver1.opendns.com',
        ]);
        $process->run();
        if (false === $process->isSuccessful()) {
            return '<comment>'.trim($process->getErrorOutput()).'</comment>';
        }

        return '<info>'.trim($process->getOutput()).'</info>';
    }

    private function getHostName(): string
    {
        $process = new Process('hostname');
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return '<info>'.trim($process->getOutput()).'</info>';
    }
}
