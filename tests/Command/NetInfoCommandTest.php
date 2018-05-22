<?php

namespace App\Tests\Command;

use App\Command\NetInfoCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class NetInfoCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $application->add(new NetInfoCommand());

        $command = $application->find('net:info');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Host name:', $output);
        $this->assertContains('Local IP :', $output);
        $this->assertContains('Public IP:', $output);
    }
}
