<?php

namespace PHPPokerAlho\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use PHPPokerAlho\Gameplay\Game\Table;
use PHPPokerAlho\Gameplay\Game\Dealer;
use PHPPokerAlho\Gameplay\Game\Player;
use PHPPokerAlho\Gameplay\Cards\StandardDeck;

class GenerateHoleCardsCommand extends Command
{
    /**
     * Configure the command
     *
     * @since  {nextRelease}
     */
    protected function configure()
    {
        $this
            ->setName('generate:hole-cards')
            ->setDescription('Deals cards to a player multiple times')
            ->addArgument(
                'hands',
                InputArgument::OPTIONAL,
                'The amount of hands to be dealt.',
                10
            )

            // the full command description shown when running the command with
            // the "--help" option
            // ->setHelp("This command allows you to create users...")
        ;
    }

    /**
     * Execute the command
     *
     * @since  {nextRelease}
     *
     * @param  InputInterface $input
     * @param  OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table("Table1", 2);
        $dealer = new Dealer(new StandardDeck());
        $dealer->setTable($table);

        $player = new Player("Player1");
        $table->addPlayer($player);

        $hands = $input->getArgument("hands");
        for ($i = 1; $i <= $hands; $i++) {
            $dealer->deal();
            $hand = $player->getHand();

            $output->writeln(
                "Hand #" . $i . ": "
                . $hand->toCliOutput()
            );
        }
    }
}
