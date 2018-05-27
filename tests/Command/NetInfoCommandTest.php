<?php

namespace App\Tests\Command;

use App\Command\NetworkInformationCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class NetInfoCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $application->add(new NetworkInformationCommand());

        $command = $application->find('network:information');
        $commandTester = new CommandTester($command);

        //TODO: test all options (host, ip, public-ip, ping)
        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $output = $commandTester->getDisplay();
        $this->assertContains('Host name:', $output);
        $this->assertContains('Local IP :', $output);
        $this->assertContains('Public IP:', $output);
    }
}
