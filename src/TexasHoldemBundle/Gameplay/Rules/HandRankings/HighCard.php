<?php

namespace TexasHoldemBundle\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;

class HighCard extends AbstractRanking
{
    /**
     * Check if there is one pair in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function hasRanking(CardCollection $cards): bool
    {
        return true;
    }
}
