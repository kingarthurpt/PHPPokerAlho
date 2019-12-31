<?php

namespace TexasHoldemBundle\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Rules\HandRankings\AbstractRanking;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\DesignPatterns\MediatorInterface;
use TexasHoldemBundle\Rules\HandRanking;

class RoyalFlush extends AbstractRanking
{
    /**
     * Check if there is a Royal Flush in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function hasRanking(CardCollection $cards): bool
    {
        $royalCards = [
            'A' => null,
            'K' => null,
            'Q' => null,
            'J' => null,
            'T' => null,
        ];

        foreach ($cards->getCards() as $card) {
            if (array_key_exists($card->getFaceValue(), $royalCards)) {
                $royalCards[$card->getFaceValue()] = $card->getSuit();
            }
        }

        // TRUE if all $royalCards elements are not null
        $hasAllRoyalCards = 5 == count(array_filter($royalCards));

        return $hasAllRoyalCards && $this->hasFlush($cards) ? true : false;
    }
}
