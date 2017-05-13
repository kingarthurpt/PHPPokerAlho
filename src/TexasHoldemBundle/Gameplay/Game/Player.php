<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Game\PlayerHand;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Player extends TableObserver
{
    /**
     * The Players's name
     *
     * @var string
     */
    private $name;

    /**
     * The Players's cards
     *
     * @var PlayerHand
     */
    private $hand = null;

    /**
     * Whether or not the Player has the button
     *
     * @var bool
     */
    private $button = false;

    /**
     * The Table where the Player may be seated
     *
     * @var Table
     */
    private $table = null;

    /**
     * The Player's chip stack
     *
     * @var Stack
     */
    private $stack = null;

    /**
     * The Player's controller
     *
     * @var [type]
     */
    private $controller = null;

    /**
     * The Player's seat number at a Table
     *
     * @var integer
     */
    private $seat = 0;

    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param  string $name The Players's name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * Return a string representation of the Player
     *
     * @since  {nextRelease}
     *
     * @return string The Card represented as a string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get the Player's name
     *
     * @since  {nextRelease}
     *
     * @return string The Player's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the Player's name
     *
     * @since  {nextRelease}
     *
     * @param  int $name The card's name
     *
     * @return Player
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the Player's hand
     *
     * @since  {nextRelease}
     *
     * @return PlayerHand The Player's hand
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * Set the Player's hand
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $hand The card's hand
     *
     * @return Player
     */
    public function setHand(CardCollection $hand)
    {
        $this->hand = new PlayerHand($hand->getCards());
        return $this;
    }

    /**
     * Get a notification about changes in the TableSubject
     *
     * @since  {nextRelease}
     *
     * @param  TableSubject $subject
     * @param  TableEvent $event The Event being fired
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
     * Check if the Player has the button
     *
     * @since  {nextRelease}
     *
     * @return bool TRUE if the Player has the button, FALSE otherwise
     */
    public function hasButton()
    {
        return $this->button;
    }

    /**
     * Set the Player's button value
     *
     * @since  {nextRelease}
     *
     * @param  bool $value
     */
    public function setButton(bool $value)
    {
        $this->button = $value;
        return $this;
    }

    /**
     * Get the Player's Stack
     *
     * @since  {nextRelease}
     *
     * @return Stack The Player's Stack
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * Set the Player's Stack
     *
     * @since  {nextRelease}
     *
     * @param  Stack $stack The Players's Stack
     *
     * @return Player
     */
    public function setStack(Stack $stack)
    {
        $this->stack = $stack;

        if (empty($this->table)) {
            return null;
        }

        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ADD_CHIPS,
            "$this->name added ".$stack->getSize()." chips to his stack"
        ));

        return $this;
    }

    /**
     * Obtain the Player's hand
     *
     * @since  {nextRelease}
     *
     * @return PlayerHand The Player's hand
     */
    public function returnHand()
    {
        $hand = $this->getHand();
        $this->hand = null;
        return $hand;
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
     * Sets the Player's seat number
     *
     * @since  {nextRelease}
     *
     * @param  int $number The seat number
     *
     * @return Player
     */
    public function setSeat(int $number)
    {
        $this->seat = $number;
        return $this;
    }

    /**
     * Gets the Player's seat number
     *
     * @since  {nextRelease}
     *
     * @return int The seat number
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * Places the small blind
     *
     * @since  {nextRelease}
     *
     * @param  float $amount The small blind amount
     */
    public function paySmallBlind(float $amount)
    {
        return $this->placeBet($amount, new TableEvent(
            TableEvent::PLAYER_PAID_SMALL_BLIND,
            "$this->name placed the small blind ($amount)"
        ));
    }

    /**
     * Places the big blind
     *
     * @since  {nextRelease}
     *
     * @param  float $amount The big blind amount
     */
    public function payBigBlind(float $amount)
    {
        return $this->placeBet($amount, new TableEvent(
            TableEvent::PLAYER_PAID_BIG_BLIND,
            "$this->name placed the big blind ($amount)"
        ));
    }

    /**
     * Fold the Player's cards.
     *
     * @since  {nextRelease}
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function fold()
    {
        if (empty($this->table)) {
            return false;
        }

        $handCards = $this->returnHand();
        if (empty($handCards)) {
            return false;
        }
        $this->table->getMuck()->merge($handCards);

        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_FOLD,
            "$this->name folded"
        ));

        return true;
    }

    /**
     * Executes the action Check
     *
     * @since  {nextRelease}
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function check()
    {
        if (empty($this->table)) {
            return false;
        }

        if (empty($this->getHand())) {
            return false;
        }

        $this->table->notify(new TableEvent(
            TableEvent::PLAYER_ACTION_CHECK,
            "$this->name checks"
        ));

        return true;
    }

    /**
     * Executes the action Call
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function call(float $amount)
    {
        $event = new TableEvent(
            TableEvent::PLAYER_ACTION_CALL,
            "$this->name calls"
        );

        if (!$this->placeBet($amount, $event)) {
            return $this->allIn();
        }
        return true;
    }

    /**
     * Executes the action Raise
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function raise(float $amount)
    {
        $event = new TableEvent(
            TableEvent::PLAYER_ACTION_RAISE,
            "$this->name raises to $amount"
        );

        if (!$this->placeBet($amount, $event)) {
            return $this->allIn();
        }
        return true;
    }

    /**
     * Executes the action goes all-in
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     */
    public function allIn()
    {
        $amount = $this->getStack()->getSize();
        $event = new TableEvent(
            TableEvent::PLAYER_ACTION_ALLIN,
            "$this->name goes all-in ($amount)"
        );

        return $this->placeBet($amount, $event);
    }

    /**
     * Shows the Player's Hand at showdown
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
            "$this->name shows his hand $hand"
        ));
    }

    /**
     * Mucks the Player's Hand at showdown
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
            "$this->name mucks his hand"
        ));
    }

    /**
     * Places a given amount of chips on the Table and notifies the Table
     *
     * @since  {nextRelease}
     *
     * @param  float $amount The amount of chips to bet
     * @param  TableEvent $event The TableEvent to be sent as a notification
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function placeBet(float $amount, TableEvent $event)
    {
        if (empty($this->table)) {
            return false;
        }

        if (empty($this->getHand())) {
            return false;
        }

        if (!$this->stack->sub($amount)) {
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
