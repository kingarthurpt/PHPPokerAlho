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
        $pairs = array_slice($occurrences, 0, 2, true);
        $rankCards = array_keys($pairs);
        arsort($rankCards);

        return $rankCards;
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
            1
        );
    }
}
