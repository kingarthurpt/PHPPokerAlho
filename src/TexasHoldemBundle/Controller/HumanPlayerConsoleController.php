<?php

namespace TexasHoldemBundle\Controller;

use Symfony\Component\Console\Command\Command;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\TableEvent;

class HumanPlayerConsoleController implements PlayerControllerInterface
{
    /**
     * @var Command
     */
    protected $command;

    /**
     * @var string
     */
    protected $function;

    /**
     * @var Player
     */
    protected $player;

    /**
     * Constructor
     *
     * @param  Command $command
     * @param  string $function
     * @param  Player $player
     */
    public function __construct(
        Command $command,
        string $function,
        Player $player
    ) {
        $this->command = $command;
        $this->function = $function;
        $this->player = $player;
    }

    /**
     * Handles the Player's behavior when receives a new TableEvent
     *
     * @param  TableEvent $event The event
     */
    public function handleEvent(TableEvent $event)
    {
        if ($event->getType() == TableEvent::PLAYER_RECEIVED_CARDS) {
            $this->print($this->player->getHand()->toCliOutput());
        }
        if ($event->getType() == TableEvent::PLAYER_ACTION_NEEDED) {
            $this->promptForAction();
        }
    }

    public function promptForAction()
    {
        $functionName = $this->function;
        $this->command->$functionName($this->player);
    }

    /**
     * Prints text to the console
     *
     * @param  string $text The message to be printed
     */
    public function print(string $text)
    {
        $this->command->print($text);
    }
}
