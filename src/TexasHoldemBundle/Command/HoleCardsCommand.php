<?php

namespace TexasHoldemBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\TableFactory;

class HoleCardsCommand extends Command
{
    const NAME = 'pokeralho:hole-cards';

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
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
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tableFactory = new TableFactory();
        $table = $tableFactory->makeTableWithDealer('Table1', 2);
        $dealer = $table->getDealer();

        $player = new Player('Player1');
        $table->addPlayer($player);

        $hands = $input->getArgument('hands');
        for ($i = 1; $i <= $hands; ++$i) {
            $dealer->deal();
            $hand = $player->getHand();

            $output->writeln(
                'Hand #'.$i.': '
                .$hand->toCliOutput()
            );
        }

        return 0;
    }
}
