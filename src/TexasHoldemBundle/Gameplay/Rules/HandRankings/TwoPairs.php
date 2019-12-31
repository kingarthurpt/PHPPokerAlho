<?php

namespace TexasHoldemBundle\Gameplay\Rules\HandRankings;


use TexasHoldemBundle\Gameplay\Rules\HandRankings\AbstractRanking;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\DesignPatterns\MediatorInterface;
use TexasHoldemBundle\Rules\HandRanking;

class TwoPairs extends AbstractRanking
{
    /**
     * Check if there is a Two pair in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function hasRanking(CardCollection $cards): bool
    {
        $values = $this->countCardOccurrences($cards);

        return 2 == $values[0] && 2 == $values[1];
    }
}
