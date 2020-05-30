<?php

namespace TexasHoldemBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\TableFactory;
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

        $tableFactory = new TableFactory();
        $table = $tableFactory->makeTableWithDealer('Table1', 1);
        $dealer = $table->getDealer();

        $player = new Player('Player1');
        $table->addPlayer($player);

        $dealer->startNewHand();
        $dealer->dealRemaining();

        $hand = $player->getHand();
        $output->writeln(
            "Player's hand: "
            .$hand->toCliOutput()
        );

        $output->writeln(
            'Community cards: '
            .$table->getCommunityCards()->toCliOutput()
        );

        $calculator = new HandEvaluator();
        $handStrength = $calculator->getPlayerStrength($player, $table);

        $output->writeln('Hand Strength: '.$handStrength->__toString());

        return 0;
    }
}
