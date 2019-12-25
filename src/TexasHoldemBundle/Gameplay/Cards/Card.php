<?php

namespace TexasHoldemBundle\Gameplay\Cards;

/**
 * A Card with a face value and a Suit.
 */
class Card
{
    /**
     * The card's value.
     *
     * @var int
     */
    protected $value;

    /**
     * The card's Suit.
     *
     * @var Suit
     */
    protected $suit;

    /**
     * Constructor.
     *
     * @param int  $value The Card's value
     * @param Suit $suit  The Card's Suit
     */
    public function __construct($value = null, Suit $suit = null)
    {
        $this->setValue($value);
        if (!is_null($suit)) {
            $this->setSuit($suit);
        }
    }

    /**
     * Return a string representation of the Card.
     *
     * @return string The Card represented as a string
     */
    public function __toString()
    {
        return '['.$this->value.$this->suit->__toString().']';
    }

    /**
     * Get the Card's value.
     *
     * @return string The Card's value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the Card's value.
     *
     * @param int $value The card's value
     *
     * @return Card
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the Card's Suit.
     *
     * @return string The Card's Suit
     */
    public function getSuit()
    {
        return $this->suit;
    }

    /**
     * Set the Card's Suit.
     *
     * @param Suit $suit The Card's Suit
     *
     * @return Card
     */
    public function setSuit(Suit $suit)
    {
        $this->suit = $suit;

        return $this;
    }
}
