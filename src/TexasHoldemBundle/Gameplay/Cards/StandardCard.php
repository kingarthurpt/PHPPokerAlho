<?php

namespace TexasHoldemBundle\Gameplay\Cards;

/**
 * A standard Poker Card.
 */
class StandardCard extends Card
{
    /**
     * @var int
     */
    const TWO = 2;

    /**
     * @var int
     */
    const THREE = 2;

    /**
     * @var int
     */
    const FOUR = 4;

    /**
     * @var int
     */
    const FIVE = 5;

    /**
     * @var int
     */
    const SIX = 6;

    /**
     * @var int
     */
    const SEVEN = 7;

    /**
     * @var int
     */
    const EIGHT = 8;

    /**
     * @var int
     */
    const NINE = 9;

    /**
     * @var int
     */
    const TEN = 10;

    /**
     * @var int
     */
    const JACK = 11;

    /**
     * @var int
     */
    const QUEEN = 12;

    /**
     * @var int
     */
    const KING = 13;

    /**
     * @var int
     */
    const ACE = 14;

    /**
     * @var array
     */
    private $faceValues = [
        1 => 'A',
        10 => 'T',
        11 => 'J',
        12 => 'Q',
        13 => 'K',
    ];

    /**
     * Return a string representation of the Card.
     *
     * @return string The Card represented as a string
     */
    public function __toString()
    {
        return '['.$this->getFaceValue().$this->suit->__toString().']';
    }

    /**
     * Return a string representation of the Card, formated with CLI colors.
     *
     * @return string The Card represented as a string
     */
    public function toCliOutput()
    {
        $symbol = $this->suit->getSymbol();
        if ($symbol == StandardSuit::CLUBS[1]
            || $symbol == StandardSuit::SPADES[1]
        ) {
            $suit = '<bg=white;fg=black>'.$this->suit.'</>';
        } elseif ($symbol == StandardSuit::HEARTS[1]
            || $symbol == StandardSuit::DIAMONDS[1]
        ) {
            $suit = '<bg=white;fg=red>'.$this->suit.'</>';
        }

        return '<bg=white;fg=black>['.$this->getFaceValue().$suit.']</>';
    }

    /**
     * Set the Card's value.
     * The value must be between 1 and 13.
     *
     * @param int $value The card's value
     *
     * @return Card|null Card on success, null on failure
     */
    public function setValue($value)
    {
        if ($value < 1 || $value > 13) {
            return null;
        }

        return parent::setValue($value);
    }

    /**
     * Convert the Card's value to their corresponding face value.
     *
     * @return string The Card's face value
     */
    public function getFaceValue()
    {
        return isset($this->faceValues[$this->value])
            ? $this->faceValues[$this->value]
            : $this->value;
    }

    /**
     * Set the Card value by their corresponding face value.
     *
     * @param string $value
     */
    public function setFaceValue(string $value)
    {
        $this->setValue($value);

        foreach ($this->faceValues as $key => $faceValue) {
            if ($value === $faceValue) {
                $this->setValue($key);
            }
        }
    }
}
