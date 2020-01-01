<?php

namespace TexasHoldemBundle\Gameplay\Rules\HandRankings;


use TexasHoldemBundle\Gameplay\Rules\HandRankings\AbstractRanking;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\DesignPatterns\MediatorInterface;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;

class OnePair extends AbstractRanking
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
        $values = $this->countCardOccurrences($cards);

        return 2 == $values[0] && 1 == $values[1];
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
        $rankCards = key($occurrences);

        return [$rankCards];
    }

    /**
     * Gets the kickers
     *
     * @param CardCollection $cards
     * @param array          $rankCards
     *
     * @return array The kickers
     */
    public function getKickers(CardCollection $cards, array $rankCards)
    {
        return array_slice(
            $this->getPossibleKickers($cards, $rankCards),
            0,
            3
        );
    }
}
