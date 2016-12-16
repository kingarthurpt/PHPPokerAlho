<?php

namespace PHPPokerAlho\Gameplay\Cards;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardCard extends Card
{
    /**
     * Return a string representation of the Card
     *
     * @since  {nextRelease}
     *
     * @return string The Card represented as a string
     */
    public function __toString()
    {
        return '[' . $this->getFaceValue() . $this->suit->__toString() . ']';
    }

    /**
     * Return a string representation of the Card, formated with CLI colors
     *
     * @since  {nextRelease}
     *
     * @return string The Card represented as a string
     */
    public function toCliOutput()
    {
        $symbol = $this->suit->getSymbol();
        if ($symbol == StandardSuitFactory::STD_CLUBS[1]
            || $symbol == StandardSuitFactory::STD_SPADES[1]
        ) {
            $suit = '<bg=white;fg=black>' . $this->suit . "</>";
        } elseif ($symbol == StandardSuitFactory::STD_HEARTS[1]
            || $symbol == StandardSuitFactory::STD_DIAMONDS[1]
        ) {
            $suit = '<bg=white;fg=red>' . $this->suit . "</>";
        }
        return '<bg=white;fg=black>[' . $this->getFaceValue() . $suit . ']</>';
    }

    /**
     * Set the Card's value.
     * The value must be between 1 and 13
     *
     * @since  {nextRelease}
     *
     * @param  int $value The card's value
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
     * Converts the Card's value to their corresponding face value
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return string The Card's face value
     */
    public function getFaceValue()
    {
        switch ($this->value) {
            case 1:
                $value = "A";
                break;
            case 10:
                $value = "T";
                break;
            case 11:
                $value = "J";
                break;
            case 12:
                $value = "Q";
                break;
            case 13:
                $value = "K";
                break;
            default:
                $value = $this->value;
        }
        return $value;
    }
}
