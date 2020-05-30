<?php

namespace TexasHoldemBundle\Command;

use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use TexasHoldemBundle\Controller\HumanPlayerConsoleController;
use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Stack;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Game\TableEventLogger;

class PlayHandCommand extends Command
{
    const NAME = 'pokeralho:play-hand';

    private $input;
    private $output;
    private $table;

    public function print(string $message)
    {
        $this->output->writeln("Hand: $message");
    }

    public function promptForBlind(Player $player)
    {
        $question = new ChoiceQuestion(
            "$player it's your turn:",
            ['f' => 'fold', 'c' => 'call', 'r' => 'raise', 'a' => 'all-in'],
            1
        );
        $question->setErrorMessage('Your action %s is invalid.');

        $helper = $this->getHelper('question');
        $action = $helper->ask($this->input, $this->output, $question);

        switch ($action) {
            case 'f':
                $player->getPlayerActions()->fold();
                break;
            case 'c':
                // $hand = $this->table->getActiveHand();
                $player->getPlayerActions()->call(10);
                break;
            case 'r':
                $player->getPlayerActions()->raise(20);
                break;
            case 'a':
                $player->getPlayerActions()->allin();
        }
    }

    public function promptForAction(Player $player)
    {
        $question = new ChoiceQuestion(
            "$player it's your turn:",
            ['f' => 'fold', 'c' => 'call', 'r' => 'raise', 'a' => 'all-in'],
            1
        );
        $question->setErrorMessage('Your action %s is invalid.');

        $helper = $this->getHelper('question');
        $action = $helper->ask($this->input, $this->output, $question);

        switch ($action) {
            case 'f':
                $player->getPlayerActions()->fold();
                break;
            case 'c':
                // $hand = $this->table->getActiveHand();
                $player->getPlayerActions()->call(10);
                break;
            case 'r':
                $player->getPlayerActions()->raise(20);
                break;
            case 'a':
                $player->getPlayerActions()->allin();
        }
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Plays a hand')
            ->addArgument(
                'opponents',
                InputArgument::OPTIONAL,
                'The number of player opponents.',
                1
            )
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
        $this->input = $input;
        $this->output = $output;

        $this->dealNewHand();

        return 0;
    }

    /**
     * Creates all needed objects and deals a hand.
     */
    private function dealNewHand()
    {
        $logger = new TableEventLogger(new ConsoleLogger(
            $this->output,
            [
                LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
                LogLevel::INFO => OutputInterface::VERBOSITY_NORMAL,
            ]
        ));

        $this->table = new Table('Test Table', 10);
        $this->table->setLogger($logger);

        $dealer = new Dealer(new StandardDeck(new StandardSuitFactory()), $this->table);
        $dealer->setTable($this->table);

        $player1 = new Player('Player1');
        $player1->getPlayerActions()->setController(new HumanPlayerConsoleController(
            $this,
            'promptForAction',
            $player1
        ));

        $player2 = new Player('Player2');
        $this->table
            ->addPlayer($player1)
            ->addPlayer($player2);

        $player1->setStack(new Stack(1000));
        $player2->setStack(new Stack(1000));

        $dealer->startNewHand();
    }
}
