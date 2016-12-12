<?php

namespace PHPPokerAlho\Game;

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
     * @var array
     */
    // private $hand;

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
}
