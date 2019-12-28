<?php

namespace TexasHoldemBundle\Gameplay\Cards;

/**
 * A Suit with a name and a symbol
 */
class StandardSuitFactory
{
    /**
     * Make a StandardSuit
     *
     * @param array $suit The Suit's constant value
     *
     * @return StandardSuit
     */
    public function make(array $suit)
    {
        switch ($suit) {
            case StandardSuit::CLUBS:
                $suit = StandardSuit::CLUBS;
                break;
            case StandardSuit::DIAMONDS:
                $suit = StandardSuit::DIAMONDS;
                break;
            case StandardSuit::HEARTS:
                $suit = StandardSuit::HEARTS;
                break;
            case StandardSuit::SPADES:
                $suit = StandardSuit::SPADES;
                break;
            default:
                return null;
        }

        return $this->createInstance($suit);
    }

    /**
     * Make a StandardSuit from their name abbreviation
     *
     * @param  string $abbr The Suit's name abbreviation
     *
     * @return StandardSuit
     */
    public function makeFromAbbr(string $abbr)
    {
        switch ($abbr) {
            case StandardSuit::CLUBS[2]:
                $suit = StandardSuit::CLUBS;
                break;
            case StandardSuit::DIAMONDS[2]:
                $suit = StandardSuit::DIAMONDS;
                break;
            case StandardSuit::HEARTS[2]:
                $suit = StandardSuit::HEARTS;
                break;
            case StandardSuit::SPADES[2]:
                $suit = StandardSuit::SPADES;
                break;
            default:
                return null;
        }

        return $this->createInstance($suit);
    }

    /**
     * Creates an instance of StandardSuit
     *
     * @param array $suit The Suit's constant value
     *
     * @return StandardSuit
     */
    private function createInstance(array $suit)
    {
        $instance = new StandardSuit();
        $instance->setName($suit[0]);
        $instance->setSymbol($suit[1]);
        $instance->setAbbreviation($suit[2]);

        return $instance;
    }
}
