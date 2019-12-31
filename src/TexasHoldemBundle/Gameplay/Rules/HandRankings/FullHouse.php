<?php

namespace TexasHoldemBundle\Gameplay\Rules\HandRankings;


use TexasHoldemBundle\Gameplay\Rules\HandRankings\AbstractRanking;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\DesignPatterns\MediatorInterface;
use TexasHoldemBundle\Rules\HandRanking;

class FullHouse extends AbstractRanking
{
    /**
     * Check if there is a Full House in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function hasRanking(CardCollection $cards): bool
    {
        $values = $this->countCardOccurrences($cards);

        return 3 == $values[0] && $values[1] >= 2;
    }

    /**
     * Gets this ranking's card values
     *
     * @param CardCollection $cards
     *
     * @return array Card values
     */
    public function getValue(CardCollection $cards): array
    {
        $occurrences = $this->getCardOccurrences($cards);
        $fullHouse = array_slice($occurrences, 0, 2, true);
        $rankCards = array_keys($fullHouse);
        arsort($rankCards);

        return $rankCards;
    }
}
