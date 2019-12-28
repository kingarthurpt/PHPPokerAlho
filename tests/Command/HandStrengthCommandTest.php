<?php

namespace Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TexasHoldemBundle\Command\HandStrengthCommand;

class HandStrengthCommandTest extends KernelTestCase
{
    public function testRun()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->add(new HandStrengthCommand());

        $command = $application->find(HandStrengthCommand::NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString("Player's hand: ", $output);
        $this->assertStringContainsString("Community cards: ", $output);
    }
}
