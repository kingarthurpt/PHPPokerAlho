<?php

namespace PHPPokerAlho\Cards;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardDeck extends Deck
{
    /**
     * Constructor
     *
     * @since  {nextRelease}
     */
    public function __construct()
    {
        parent::__construct();

        $suits = array("Clubs", "Diamons", "Hearts", "Spades");
        foreach ($suits as $suitName) {
            $suit = new Suit($suitName);

            for ($i = 1; $i <= 13; $i++) {
                $this->addCard(new Card($i, $suit));
            }
        }
    }
}
