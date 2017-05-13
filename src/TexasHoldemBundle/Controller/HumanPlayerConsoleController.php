<?php

namespace TexasHoldemBundle\Controller;

use Symfony\Component\Console\Command\Command;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\TableEvent;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
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
     * @since  {nextRelease}
     *
     * @param  Command $command [description]
     * @param  string $function [description]
     * @param  Player $player [description]
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
     * @since  {nextRelease}
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

    /**
     * [promptForAction description]
     *
     * @since  {nextRelease}
     */
    public function promptForAction()
    {
        $functionName = $this->function;
        $this->command->$functionName($this->player);
    }

    /**
     * Prints text to the console
     *
     * @since  {nextRelease}
     *
     * @param  string $text The message to be printed
     */
    public function print(string $text)
    {
        $this->command->print($text);
    }
}
