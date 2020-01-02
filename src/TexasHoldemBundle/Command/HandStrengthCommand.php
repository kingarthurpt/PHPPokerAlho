<?php

namespace TexasHoldemBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Rules\HandEvaluator;

class HandStrengthCommand extends Command
{
    const NAME = 'pokeralho:hand-strength';

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Deals a hand to the Player and calculates his hand strength')
        ;
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        unset($input);

        $cards = $this->prepare($output);

        $calculator = new HandEvaluator();
        $handStrength = $calculator->getStrength($cards);
        $output->writeln('Hand Strength: '.$handStrength->__toString());

        return 0;
    }

    private function prepare(OutputInterface $output): CardCollection
    {
        $table = new Table('Table1', 1);
        $dealer = new Dealer(new StandardDeck(new StandardSuitFactory()), $table);
        $dealer->setTable($table);

        $player = new Player('Player1');
        $table->addPlayer($player);

        $dealer->deal();
        $hand = $player->getHand();

        $output->writeln(
            "Player's hand: "
            .$hand->toCliOutput()
        );

        $dealer->dealFlop();
        $dealer->dealTurn();
        $dealer->dealRiver();

        $output->writeln(
            'Community cards: '
            .$table->getCommunityCards()->toCliOutput()
        );

        $cards = new CardCollection();
        $cards->mergeCards($player->getHand());
        $cards->mergeCards($table->getCommunityCards());

        return $cards;
    }
}
