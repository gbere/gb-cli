<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class ApplicationProd extends BaseApplication
{
    /**
     * Gets the default input definition.
     *
     * @return InputDefinition An InputDefinition instance
     */
    protected function getDefaultInputDefinition()
    {
        return new InputDefinition([
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),
            new InputOption('--help', '-h', InputOption::VALUE_NONE, 'Display this help message'),
            //new InputOption('--quiet', '-q', InputOption::VALUE_NONE, 'Do not output any message'),
            //new InputOption('--verbose', '-v|vv|vvv', InputOption::VALUE_NONE, 'Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug'),
            //new InputOption('--version', '-V', InputOption::VALUE_NONE, 'Display this application version'),
            //new InputOption('--ansi', '', InputOption::VALUE_NONE, 'Force ANSI output'),
            //new InputOption('--no-ansi', '', InputOption::VALUE_NONE, 'Disable ANSI output'),
            //new InputOption('--no-interaction', '-n', InputOption::VALUE_NONE, 'Do not ask any interactive question'),
        ]);
    }

    public function getLongVersion()
    {
        // remove (kernel: src, env: prod, debug: false)
        return preg_replace('/\(.*\)/', '', parent::getLongVersion());
    }
}