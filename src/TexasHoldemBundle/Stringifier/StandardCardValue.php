<?php

namespace TexasHoldemBundle\Stringifier;

use TexasHoldemBundle\DesignPatterns\Singleton;
use TexasHoldemBundle\Gameplay\Cards\StandardCard;

class StandardCardValue extends Singleton
{
    /**
     * Gets the Card name given its value.<br/>
     * If invalid value of Card is given returns "Unknown".
     *
     * @param int $value card value
     *
     * @return string card name | "Unknown"
     */
    public function stringify(int $value)
    {
        if ($value > 1 && $value < 11) {
            return $this->stringifyNumber($value);
        }

        return $this->stringifyFace($value);
    }

    /**
     * Stringifies a numbered card
     *
     * @param int $value
     *
     * @return string
     */
    private function stringifyNumber($value)
    {
        $locale = "en";
        $formatter = new \NumberFormatter($locale, \NumberFormatter::SPELLOUT);
        return ucfirst($formatter->format($value));
    }

    /**
     * Stringifies a faced card
     *
     * @param int $value
     *
     * @return string
     */
    private function stringifyFace($value)
    {
        switch ($value) {
            case StandardCard::JACK:
                $name = 'Jack';
                break;
            case StandardCard::QUEEN:
                $name = 'Queen';
                break;
            case StandardCard::KING:
                $name = 'King';
                break;
            case StandardCard::ACE:
                $name = 'Ace';
                break;
            default:
                $name = 'Unknown';
        }

        return $name;
    }
}
