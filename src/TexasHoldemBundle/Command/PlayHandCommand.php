<?php

namespace TexasHoldemBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Question\ChoiceQuestion;

use TexasHoldemBundle\Gameplay\Game\TableEventLogger;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Game\Stack;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;

use TexasHoldemBundle\Controller\HumanPlayerConsoleController;

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
            ->setName('pokeralho:play-hand')
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

        $this->dealNewHand();

        return 0;
    }

    /**
     * Creates all needed objects and deals a hand
     */
    private function dealNewHand()
    {
        $logger = new TableEventLogger(new ConsoleLogger(
            $this->output,
            array(
                LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
                LogLevel::INFO   => OutputInterface::VERBOSITY_NORMAL,
            )
        ));

        $table = new Table("Test Table", 10);
        $table->setLogger($logger);

        $dealer = new Dealer(new StandardDeck(new StandardSuitFactory()), $table);
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
