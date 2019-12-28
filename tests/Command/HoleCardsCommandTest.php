<?php

namespace Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use TexasHoldemBundle\Command\HoleCardsCommand;

class HoleCardsCommandTest extends KernelTestCase
{
    public function testRun()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->add(new HoleCardsCommand());

        $handCount = 3;
        $command = $application->find(HoleCardsCommand::NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            // pass arguments to the helper
            'hands' => $handCount,

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        for ($i = 1; $i <= $handCount; ++$i) {
            $this->assertStringContainsString('Hand #'.$i, $output);
        }
        $this->assertStringNotContainsString(sprintf('Hand #%d', $handCount + 1), $output);
    }
}
