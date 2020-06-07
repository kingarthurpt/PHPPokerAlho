<?php

namespace TexasHoldemBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\TableFactory;
use TexasHoldemBundle\Gameplay\Rules\HandEvaluator;

class HandWinnerCommand extends Command
{
    const NAME = 'pokeralho:hand-winner';
    const PLAYERS_COUNT = 'players';

    private $output;

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Deals a hand to Players and calculates the winner')
            ->addOption(self::PLAYERS_COUNT, 'p', InputOption::VALUE_OPTIONAL, 'The number of players', 2);
    }

    /**
     * Execute the command.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $playerCount = $input->getOption(self::PLAYERS_COUNT);
        $tableFactory = new TableFactory();
        $table = $tableFactory->makeTableWithDealer('Table1', $playerCount);
        $dealer = $table->getDealer();

        $players = [];
        for ($i = 1; $i <= $playerCount; ++$i) {
            $players[$i - 1] = new Player('Player'.$i);
            $table->addPlayer($players[$i - 1]);
        }

        $dealer->startNewHand();
        $dealer->dealRemaining();

        $this->showPlayersHands($players, $table);

        $handValues = $this->showPlayersHandStrength($players, $table);
        arsort($handValues);

        $this->showWinner($handValues);

        return 0;
    }

    private function showPlayersHands($players, $table)
    {
        foreach ($players as $key => $player) {
            $hand = $player->getHand();

            $this->output->writeln(
                sprintf('Player %s: %s', $key + 1, $hand->toCliOutput())
            );
        }

        $this->output->writeln(
            'Community cards: '
            .$table->getCommunityCards()->toCliOutput()
        );
    }

    private function showPlayersHandStrength($players, $table): array
    {
        $handValues = [];
        $calculator = new HandEvaluator();

        foreach ($players as $key => $player) {
            $handStrength = $calculator->getPlayerStrength($player, $table);

            $this->output->writeln(
                sprintf(
                    'Player %s Hand Strength: %s %s %s, %s',
                    $key + 1,
                    $handStrength->__toString(),
                    $handStrength->getRanking(),
                    array_sum($handStrength->getRankingCardValues()),
                    $handStrength->getValue()
                )
            );

            $handValues[$player->getName()] = $handStrength->getValue();
        }

        return $handValues;
    }

    private function showWinner($handValues)
    {
        $i = 1;
        foreach ($handValues as $playerName => $handStrengthValue) {
            $this->output->writeln(
                sprintf('%s place %s: %s', $i, $playerName, $handStrengthValue)
            );
            ++$i;
        }
    }
}
