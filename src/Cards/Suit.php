<?php

namespace PHPPokerAlho\Cards;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Suit
{
    /**
     * The Suit's name
     *
     * @var string
     */
    private $name;

    /**
     * The Suit's symbol
     *
     * @var string
     */
    private $symbol;

    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param  string $name The Suit's name
     */
    public function __construct($name = null, $symbol = null)
    {
        $this->setName($name);
        $this->setSymbol($symbol);
    }

    /**
     * Return a string representation of the Suit
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.ze.alves@gmail.com>
     *
     * @return string The Card represented as a string
     */
    public function __toString()
    {
        return $this->symbol;
    }

    /**
     * Get the Suit's name
     *
     * @since  {nextRelease}
     *
     * @return string The Suit's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the Suit's name
     *
     * @since  {nextRelease}
     *
     * @param  string $name The Suit's name
     *
     * @return Suit
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the Suit's symbol
     *
     * @since  {nextRelease}
     *
     * @return string The Suit's symbol
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set the Suit's symbol
     *
     * @since  {nextRelease}
     *
     * @param  string $symbol The Suit's symbol
     *
     * @return Suit
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
        return $this;
    }
}
