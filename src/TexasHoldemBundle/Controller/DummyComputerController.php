<?php

namespace TexasHoldemBundle\Controller;

use TexasHoldemBundle\Gameplay\Game\Event\TableEvent;
use TexasHoldemBundle\Gameplay\Game\Player;

class DummyComputerController implements PlayerControllerInterface
{
    /**
     * @var Player
     */
    protected $player;

    /**
     * @var bool
     */
    protected $keepPlaying = true;

    /**
     * Constructor.
     *
     * @param Player $player
     */
    public function __construct(Player $player)
    {
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
            case TableEvent::ACTION_PLAYER_PAY_SMALL_BLIND:
                $this->player->getPlayerActions()->paySmallBlind($event->getAmount());
                break;
            case TableEvent::ACTION_PLAYER_PAY_BIG_BLIND:
                $this->player->getPlayerActions()->payBigBlind($event->getAmount());
                break;
            case TableEvent::PLAYER_RECEIVED_CARDS:
                var_dump($this->player->getHand()->getHandStrength()->getValue());
                // $this->player->getPlayerActions()->payBigBlind($event->getAmount());
                break;
            default:
                // $this->print($event->getMessage());
                break;
        }
    }
}
