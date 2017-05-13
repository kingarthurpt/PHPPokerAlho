<?php

namespace TexasHoldemBundle\Gameplay\Cards;

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
    public function __construct(StandardSuitFactory $suitsFactory)
    {
        $suits = array(
            StandardSuit::CLUBS,
            StandardSuit::DIAMONDS,
            StandardSuit::HEARTS,
            StandardSuit::SPADES
        );

        foreach ($suits as $suitName) {
            $suit = $suitsFactory->makeFromAbbr($suitName[2]);

            for ($i = 1; $i <= 13; $i++) {
                $this->addCard(new StandardCard($i, $suit));
            }
        }
    }
}
