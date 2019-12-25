<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Game\PlayerActions;
use TexasHoldemBundle\Gameplay\Game\PlayerHand;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Player
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
     * The Player's chip stack
     *
     * @var Stack
     */
    private $stack = null;

    /**
     * The Player's seat number at a Table
     *
     * @var integer
     */
    private $seat = 0;

    /**
     * The Player's available actions
     *
     * @var PlayerActions
     */
    private $actions;

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
        $this->actions = new PlayerActions($this);
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
     * @param  Stack $stack The Players's Stack
     *
     * @return Player
     */
    public function setStack(Stack $stack)
    {
        $this->stack = $stack;
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
     * Perform a PlayerAction
     *
     * @param string $actionName
     *
     * @return mixed|null
     */
    public function doAction($actionName)
    {
        if (\method_exists(!$this->actions, $actionName)) {
            return;
        }

        return $this->actions($actionName);
    }

    /**
     * Return the PlayerActions
     *
     * @return PlayerActions
     */
    public function getPlayerActions()
    {
        return $this->actions;
    }
}
