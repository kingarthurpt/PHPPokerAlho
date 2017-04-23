<?php

namespace PHPPokerAlho\Gameplay\Cards;

/**
 * A standard Poker Deck
 *
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

        $suits = array(
            StandardSuit::CLUBS,
            StandardSuit::DIAMONDS,
            StandardSuit::HEARTS,
            StandardSuit::SPADES
        );

        foreach ($suits as $suitName) {
            $suit = StandardSuit::fromAbbr($suitName[2]);

            for ($i = 2; $i <= 14; $i++) {
                $this->addCard(new StandardCard($i, $suit));
            }
        }
    }
}
