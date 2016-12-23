<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Cards\CardCollection;
use PHPPokerAlho\Gameplay\Game\PlayerHand;

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
     * Muck the Player's cards.
     *
     * @since  {nextRelease}
     */
    protected function muck()
    {
        if (empty($this->table)) {
            return null;
        }

        $this->table->getMuck()->merge($this->returnHand());
    }
}
