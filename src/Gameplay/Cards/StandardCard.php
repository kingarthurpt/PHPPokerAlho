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
        switch ($this->value) {
            case 1:
                $this->value = "A";
                break;
            case 11:
                $this->value = "J";
                break;
            case 12:
                $this->value = "Q";
                break;
            case 13:
                $this->value = "K";
                break;
        }
        return parent::__toString();
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
}
