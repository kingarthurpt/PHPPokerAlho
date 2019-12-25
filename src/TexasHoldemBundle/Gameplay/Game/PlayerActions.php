<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;

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
     * The Player's controller
     *
     * @var [type]
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
            return null;
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
     * @return PlayerHand The Player's hand
     */
    public function returnHand()
    {
        if (empty($this->table)) {
            return null;
        }

        $hand = $this->player->getHand();
        $this->player->setHand(new CardCollection());

        return $hand;
    }

    /**
     * Places the small blind.
     *
     * @param float $amount The small blind amount
     */
    public function paySmallBlind(float $amount)
    {
        if (empty($this->table)) {
            return null;
        }

        return $this->placeBet($amount, new TableEvent(
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
        if (empty($this->table)) {
            return null;
        }

        return $this->placeBet($amount, new TableEvent(
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
        if (empty($this->table)) {
            return null;
        }

        $handCards = $this->returnHand();
        if (empty($handCards)) {
            return null;
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
        if (empty($this->table)) {
            return null;
        }

        if (empty($this->player->getHand())) {
            return false;
        }

        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_CHECK,
            $this->player->getName().' checks'
        ));

        return true;
    }

    /**
     * Executes the action Call.
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function call(float $amount)
    {
        if (empty($this->table)) {
            return null;
        }

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
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function raise(float $amount)
    {
        if (empty($this->table)) {
            return null;
        }

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
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function allIn()
    {
        if (empty($this->table)) {
            return null;
        }

        $amount = $this->player->getStack()->getSize();
        $event = new TableEvent(
            TableEvent::PLAYER_ACTION_ALLIN,
            $this->player->getName()." goes all-in ($amount)"
        );

        return $this->placeBet($amount, $event);
    }

    /**
     * Shows the Player's Hand at showdown.
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function showHand()
    {
        if (empty($this->table)) {
            return null;
        }

        $hand = $this->getHand();
        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_SHOW_HAND,
            $this->player->getName()." shows his hand $hand"
        ));
    }

    /**
     * Mucks the Player's Hand at showdown.
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function muckHand()
    {
        if (empty($this->table)) {
            return null;
        }

        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_SHOW_HAND,
            $this->player->getName().' mucks his hand'
        ));
    }

    /**
     * Sets the Player's controller
     *
     * @since  {nextRelease}
     *
     * @param  object $controller The controller
     *
     * @return Player
     */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * Places a given amount of chips on the Table and notifies the Table.
     *
     * @since  {nextRelease}
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

        $bettigZone = $this->table->getPlayerBets($this);
        if (is_null($bettigZone)) {
            return false;
        }

        $bettigZone->add($amount);
        $this->table->notify($event);

        return true;
    }
}
