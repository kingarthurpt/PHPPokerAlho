<?php

namespace PHPPokerAlho\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Question\ChoiceQuestion;

use PHPPokerAlho\Gameplay\Game\TableEventLogger;
use PHPPokerAlho\Gameplay\Game\Table;
use PHPPokerAlho\Gameplay\Game\Dealer;
use PHPPokerAlho\Gameplay\Game\Player;
use PHPPokerAlho\Gameplay\Cards\StandardDeck;
use PHPPokerAlho\Gameplay\Game\Stack;

use PHPPokerAlho\Controller\HumanPlayerConsoleController;

class PlayHandCommand extends Command
{
    private $input;
    private $output;

    /**
     * Configure the command
     *
     * @since  {nextRelease}
     */
    protected function configure()
    {
        $this
            ->setName('play:hand')
            ->setDescription('Plays a hand')
            ->addArgument(
                'opponents',
                InputArgument::OPTIONAL,
                'The number of player opponents.',
                1
            )
        ;
    }

    public function print(string $message)
    {
        $this->output->writeln("Hand: $message");
    }

    public function promptForAction(Player $player)
    {
        $question = new ChoiceQuestion(
            "$player it's your turn:",
            array('f' => 'fold', 'c' => 'call', 'r' => 'raise', 'a' => 'all-in'),
            1
        );
        $question->setErrorMessage('Your action %s is invalid.');

        $helper = $this->getHelper('question');
        $action = $helper->ask($this->input, $this->output, $question);

        switch ($action) {
            case 'f':
                $player->fold();
                break;
            case 'c':
                break;
            case 'r':
                break;
            case 'a':
        }
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
        $this->input = $input;
        $this->output = $output;

        $logger = new TableEventLogger(new ConsoleLogger(
            $output,
            array(
                LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
                LogLevel::INFO   => OutputInterface::VERBOSITY_NORMAL,
            )
        ));

        $table = new Table("Test Table", 10);
        $table->setLogger($logger);

        $dealer = new Dealer(new StandardDeck());
        $dealer->setTable($table);

        $player1 = new Player("Player1");
        $player1->setController(new HumanPlayerConsoleController(
            $this,
            "promptForAction",
            $player1
        ));

        $player2 = new Player("Player2");
        $table
            ->addPlayer($player1)
            ->addPlayer($player2);

        $player1->setStack(new Stack(1000));
        $player2->setStack(new Stack(1000));

        $dealer->startNewHand();
    }
}
