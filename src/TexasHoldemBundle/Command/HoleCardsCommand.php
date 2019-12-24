<?php

namespace TexasHoldemBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;

class HoleCardsCommand extends Command
{
    /**
     * Configure the command
     *
     * @since  {nextRelease}
     */
    protected function configure()
    {
        $this
            ->setName('pokeralho:hole-cards')
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
        $factory = new StandardSuitFactory();
        $dealer = new Dealer(new StandardDeck($factory), $table);
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

        return 0;
    }
}
