<?php

namespace TexasHoldemBundle\Gameplay\Cards;

/**
 * A standard Poker Deck.
 */
class StandardDeck extends Deck
{
    /**
     * Constructor.
     */
    public function __construct(StandardSuitFactory $suitsFactory)
    {
        $suits = [
            StandardSuit::CLUBS,
            StandardSuit::DIAMONDS,
            StandardSuit::HEARTS,
            StandardSuit::SPADES,
        ];

        foreach ($suits as $suitName) {
            $suit = $suitsFactory->makeFromAbbr($suitName[2]);

            for ($i = 2; $i <= 14; ++$i) {
                $this->addCard(new StandardCard($i, $suit));
            }
        }
    }
}
