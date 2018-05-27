<?php

namespace App\Tests\Command;

use App\Command\PsTreeCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class PsTreeCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $application->add(new PsTreeCommand());

        $command = $application->find('ps:tree');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertNotEmpty($output);
    }
}
