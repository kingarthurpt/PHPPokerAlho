<?php

namespace PHPPokerAlho\Gameplay\Cards;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardSuitFactory extends Suit
{
    /**
     * Standard Suit Clubs ♣
     *
     * @var string
     */
    const STD_CLUBS = array("Clubs", "♣");

    /**
     * Standard Suit Diamons ♦
     *
     * @var string
     */
    const STD_DIAMONS = array("Diamons", "♦");

    /**
     * Standard Suit Hearts ♥
     *
     * @var string
     */
    const STD_HEARTS = array("Hearts", "♥");

    /**
     * Standard Suit Spades ♠
     *
     * @var string
     */
    const STD_SPADES = array("Spades", "♠");
    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param array $cont The Suit's name and symbol
     */
    public function create(array $const)
    {
        $suit = new Suit();
        $suit->setName($const[0]);
        $suit->setSymbol($const[1]);
        return $suit;
    }
}
