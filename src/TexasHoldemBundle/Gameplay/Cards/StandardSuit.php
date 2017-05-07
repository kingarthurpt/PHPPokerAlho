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
}
