<?php

namespace TexasHoldemBundle\Controller;

use Symfony\Component\Console\Command\Command;
use TexasHoldemBundle\Gameplay\Game\Event\TableEvent;
use TexasHoldemBundle\Gameplay\Game\Player;

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
     * Constructor.
     *
     * @param Command $command
     * @param string  $function
     * @param Player  $player
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
     * Handles the Player's behavior when receives a new TableEvent.
     *
     * @param TableEvent $event The event
     */
    public function handleEvent(TableEvent $event)
    {
        switch ($event->getType()) {
            case TableEvent::PLAYER_RECEIVED_CARDS:
                $this->print($this->player->getHand()->toCliOutput());
                break;
            case TableEvent::PLAYER_ACTION_NEEDED:
                $this->promptForAction();
                break;
            case TableEvent::ACTION_PLAYER_PAY_SMALL_BLIND:
                $this->promptForAction();
                break;
            // default:

                // $this->print($event->getMessage());
        }
    }

    public function promptForAction()
    {
        $functionName = $this->function;
        $this->command->$functionName($this->player);
    }

    /**
     * Prints text to the console.
     *
     * @param string $text The message to be printed
     */
    public function print(string $text)
    {
        $this->command->print($text);
    }
}
