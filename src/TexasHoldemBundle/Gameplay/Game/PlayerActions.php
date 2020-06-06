<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Controller\PlayerControllerInterface;
use TexasHoldemBundle\Exception\PlayerHandIsEmptyException;
use TexasHoldemBundle\Exception\PlayerNotSeatedException;
use TexasHoldemBundle\Gameplay\Game\Event\TableEvent;

class PlayerActions extends TableObserver
{
    const ACTION_ADD_TO_STACK = 'addToStack';
    const ACTION_RETURN_HAND = 'returnHand';
    const ACTION_PAY_SMALLBLIND = 'paySmallBlind';
    const ACTION_PAY_BIGBLIND = 'payBigBlind';
    const ACTION_FOLD = 'fold';
    const ACTION_CHECK = 'check';
    const ACTION_CALL = 'call';
    const ACTION_RAISE = 'raise';
    const ACTION_ALLIN = 'allIn';
    const ACTION_SHOW_HAND = 'showHand';
    const ACTION_MUCK_HAND = 'muckHand';

    /**
     * The Player.
     *
     * @var Player
     */
    private $player;

    /**
     * The Player's controller.
     *
     * @var PlayerControllerInterface
     */
    private $controller = null;

    /**
     * The Table where the Player may be seated.
     *
     * @var Table
     */
    private $table = null;

    /**
     * Constructor.
     *
     * @param Player $player The Players
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * Get a notification about changes in the TableSubject.
     *
     * @param TableSubject $subject
     * @param TableEvent   $event   The Event being fired
     */
    public function update(TableSubject $subject, TableEvent $event)
    {
        if (is_null($this->table) && $subject instanceof Table) {
            $this->table = $subject;
        }

        if (!is_null($this->controller)) {
            $this->controller->handleEvent($event);
        }

        return true;
    }

    /**
     * Set the Player's Stack.
     *
     * @param Stack $stack The Players's Stack
     *
     * @return Player
     */
    public function addToStack(Stack $stack)
    {
        if (empty($this->table)) {
            throw new PlayerNotSeatedException($this->player);
        }

        $this->player->getStack()->add($stack->getSize());
        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ADD_CHIPS,
            $this->player->getName().' added '.$stack->getSize().' chips to his stack'
        ));

        return $this;
    }

    /**
     * Obtain the Player's hand.
     *
     * @return PlayerHand|null The Player's hand or null
     */
    public function returnHand(): ?PlayerHand
    {
        $hand = $this->player->getHand();
        $this->player->setHand(null);

        return $hand;
    }

    /**
     * Places the small blind.
     *
     * @param float $amount The small blind amount
     */
    public function paySmallBlind(float $amount)
    {
        $this->throwIfPlayerIsNotSeated();

        return $this->placeBlind($amount, new TableEvent(
            TableEvent::PLAYER_PAID_SMALL_BLIND,
            $this->player->getName()." placed the small blind ($amount)"
        ));
    }

    /**
     * Places the big blind.
     *
     * @param float $amount The big blind amount
     */
    public function payBigBlind(float $amount)
    {
        $this->throwIfPlayerIsNotSeated();

        return $this->placeBlind($amount, new TableEvent(
            TableEvent::PLAYER_PAID_BIG_BLIND,
            $this->player->getName()." placed the big blind ($amount)"
        ));
    }

    /**
     * Fold the Player's cards.
     *
     * @return PlayerHand|null
     */
    public function fold()
    {
        $this->throwIfPlayerIsNotSeated();

        $handCards = $this->returnHand();
        if (empty($handCards)) {
            throw new PlayerHandIsEmptyException($this->player);
        }

        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_FOLD,
            $this->player->getName().' folded'
        ));

        return $handCards;
    }

    /**
     * Executes the action Check.
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function check()
    {
        $this->throwIfPlayerIsNotSeated();

        if (empty($this->player->getHand())) {
            throw new PlayerHandIsEmptyException($this->player);
        }

        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_CHECK,
            $this->player->getName().' checks'
        ));

        return true;
    }

    /**
     * Executes the action Call.
     */
    public function call(float $amount)
    {
        $this->throwIfPlayerIsNotSeated();

        $event = new TableEvent(
            TableEvent::PLAYER_ACTION_CALL,
            $this->player->getName().' calls'
        );

        if (!$this->placeBet($amount, $event)) {
            return $this->allIn();
        }

        return true;
    }

    /**
     * Executes the action Raise.
     */
    public function raise(float $amount)
    {
        $this->throwIfPlayerIsNotSeated();

        $event = new TableEvent(
            TableEvent::PLAYER_ACTION_RAISE,
            $this->player->getName()." raises to $amount"
        );

        if (!$this->placeBet($amount, $event)) {
            return $this->allIn();
        }

        return true;
    }

    /**
     * Executes the action goes all-in.
     */
    public function allIn()
    {
        $this->throwIfPlayerIsNotSeated();

        $amount = $this->player->getStack()->getSize();
        $event = new TableEvent(
            TableEvent::PLAYER_ACTION_ALLIN,
            $this->player->getName()." goes all-in ($amount)"
        );

        return $this->placeBet($amount, $event);
    }

    /**
     * Shows the Player's Hand at showdown.
     */
    public function showHand()
    {
        $this->throwIfPlayerIsNotSeated();

        $hand = $this->player->getHand();
        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_SHOW_HAND,
            $this->player->getName()." shows his hand $hand"
        ));

        return $hand;
    }

    /**
     * Mucks the Player's Hand at showdown.
     */
    public function muckHand()
    {
        $this->throwIfPlayerIsNotSeated();

        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_SHOW_HAND,
            $this->player->getName().' mucks his hand'
        ));
    }

    /**
     * Sets the Player's controller.
     *
     * @param object $controller The controller
     *
     * @return Player
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Throws PlayerNotSeatedException if the player is not seated at the table.
     *
     * @throws PlayerNotSeatedException
     */
    private function throwIfPlayerIsNotSeated()
    {
        if (empty($this->table)) {
            throw new PlayerNotSeatedException($this->player);
        }
    }

    private function placeBlind(float $amount, TableEvent $event)
    {
        if (empty($this->table)
            || !$this->player->getStack()->sub($amount)
        ) {
            return false;
        }

        return $this->doPlaceBet($amount, $event);
    }

    /**
     * Places a given amount of chips on the Table and notifies the Table.
     *
     * @param float      $amount The amount of chips to bet
     * @param TableEvent $event  The TableEvent to be sent as a notification
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function placeBet(float $amount, TableEvent $event)
    {
        if (empty($this->table)
            || empty($this->player->getHand())
            || !$this->player->getStack()->sub($amount)
        ) {
            return false;
        }

        return $this->doPlaceBet($amount, $event);
    }

    private function doPlaceBet(float $amount, TableEvent $event)
    {
        $bettingZone = $this->table->getPlayerBets($this->player);
        if (is_null($bettingZone)) {
            return false;
        }

        $bettingZone->add($amount);
        $this->table->notify($event);

        return true;
    }
}
