<?php

namespace PHPPokerAlho\Gameplay\Cards;

use PHPPokerAlho\Gameplay\Cards\StandardSuitFactory;

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

            for ($i = 1; $i <= 13; $i++) {
                $this->addCard(new StandardCard($i, $suit));
            }
        }
    }
}
