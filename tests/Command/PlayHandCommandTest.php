<?php

namespace Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use TexasHoldemBundle\Command\PlayHandCommand;

class PlayHandCommandTest extends KernelTestCase
{
    private $commandTester;

    protected function setUp(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->add(new PlayHandCommand());

        $command = $application->find(PlayHandCommand::NAME);
        $this->commandTester = new CommandTester($command);
    }

    public function testFold()
    {
        $this->commandTester->setInputs(['f']);
        $this->commandTester->execute([]);
        $output = $this->commandTester->getDisplay();
        $this->assertStringContainsString('[info] Player1 has joined the table', $output);
        $this->assertStringContainsString('[info] Player2 has joined the table', $output);
        $this->assertStringContainsString('[info] Player1 folded', $output);
    }

    // public function testCall()
    // {
    //     $this->commandTester->setInputs(['c']);
    //     $this->commandTester->execute([]);
    //     $output = $this->commandTester->getDisplay();
    //     $this->assertStringContainsString('[info] Player1 has joined the table', $output);
    //     $this->assertStringContainsString('[info] Player2 has joined the table', $output);
    //     $this->assertStringContainsString('[info] Player1 calls', $output);
    // }

    // public function testRaise()
    // {
    //     $this->commandTester->setInputs(['r']);
    //     $this->commandTester->execute([]);
    //     $output = $this->commandTester->getDisplay();
    //     $this->assertStringContainsString('[info] Player1 has joined the table', $output);
    //     $this->assertStringContainsString('[info] Player2 has joined the table', $output);
    //     $this->assertStringContainsString('[info] Player1 raises to 20', $output);
    // }

    // public function testAllin()
    // {
    //     $this->commandTester->setInputs(['a']);
    //     $this->commandTester->execute([]);
    //     $output = $this->commandTester->getDisplay();
    //     $this->assertStringContainsString('[info] Player1 has joined the table', $output);
    //     $this->assertStringContainsString('[info] Player2 has joined the table', $output);
    //     $this->assertStringContainsString('[info] Player1 goes all-in (1000)', $output);
    // }
}
