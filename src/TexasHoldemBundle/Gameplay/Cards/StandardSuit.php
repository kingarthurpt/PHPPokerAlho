<?php

namespace TexasHoldemBundle\Gameplay\Cards;

/**
 * A Suit with a name and a symbol
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardSuit extends Suit
{
    /**
     * Standard Suit Clubs ♣
     *
     * @var string
     */
    const CLUBS = array("Clubs", '♣', 'c');

    /**
     * Standard Suit Diamonds ♦
     *
     * @var string
     */
    const DIAMONDS = array("Diamonds", '♦', 'd');

    /**
     * Standard Suit Hearts ♥
     *
     * @var string
     */
    const HEARTS = array("Hearts", '♥', 'h');

    /**
     * Standard Suit Spades ♠
     *
     * @var string
     */
    const SPADES = array("Spades", '♠', 's');

    /**
     * Make a StandardSuit from their name abbreviation
     *
     * @since  {nextRelease}
     *
     * @param  string $abbr The Suit's name abbreviation
     *
     * @return StandardSuit
     */
    public static function fromAbbr(string $abbr)
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

        $instance = new self();
        $instance->setName($suit[0]);
        $instance->setSymbol($suit[1]);
        $instance->setAbbreviation($suit[2]);
        return $instance;
    }
}
