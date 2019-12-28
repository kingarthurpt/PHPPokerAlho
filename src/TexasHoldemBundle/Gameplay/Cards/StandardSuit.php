<?php

namespace TexasHoldemBundle\Gameplay\Cards;

/**
 * A Suit with a name and a symbol.
 */
class StandardSuit extends Suit
{
    /**
     * Standard Suit Clubs ♣.
     *
     * @var string
     */
    const CLUBS = ['Clubs', '♣', 'c'];

    /**
     * Standard Suit Diamonds ♦.
     *
     * @var string
     */
    const DIAMONDS = ['Diamonds', '♦', 'd'];

    /**
     * Standard Suit Hearts ♥.
     *
     * @var string
     */
    const HEARTS = ['Hearts', '♥', 'h'];

    /**
     * Standard Suit Spades ♠.
     *
     * @var string
     */
    const SPADES = ['Spades', '♠', 's'];
}
