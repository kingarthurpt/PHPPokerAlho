<?php

namespace PHPPokerAlho\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use PHPPokerAlho\Gameplay\Game\Table;
use PHPPokerAlho\Gameplay\Game\Dealer;
use PHPPokerAlho\Gameplay\Game\Player;
use PHPPokerAlho\Gameplay\Cards\StandardDeck;
use PHPPokerAlho\Gameplay\Cards\CardCollection;
use PHPPokerAlho\Gameplay\Rules\HandEvaluator;

class HandStrengthCommand extends Command
{
    /**
     * Configure the command
     *
     * @since  {nextRelease}
     */
    protected function configure()
    {
        $this
            ->setName('evaluate:hand-strength')
            ->setDescription('Deals a hand to the Player and calculates his hand strength')
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
        $table = new Table("Table1", 1);
        $dealer = new Dealer(new StandardDeck());
        $dealer->setTable($table);

        $player = new Player("Player1");
        $table->addPlayer($player);

        $dealer->deal();
        $hand = $player->getHand();
        $output->writeln(
            "Player's hand: "
            . $hand->toCliOutput()
        );

        $dealer->dealFlop();
        $dealer->dealTurn();
        $dealer->dealRiver();

        $output->writeln(
            "Community cards: "
            . $table->getCommunityCards()->toCliOutput()
        );


        $calculator = new HandEvaluator();
        $cards = new CardCollection();
        $cards->mergeCards($player->getHand());
        $cards->mergeCards($table->getCommunityCards());

        $handStrength = $calculator->getStrength($cards);
        $output->writeln("Hand Strength: " . $handStrength->__toString());

    }
}
