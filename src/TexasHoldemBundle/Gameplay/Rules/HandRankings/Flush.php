<?php

namespace TexasHoldemBundle\Gameplay\Rules\HandRankings;


use TexasHoldemBundle\Gameplay\Rules\HandRankings\AbstractRanking;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\DesignPatterns\MediatorInterface;
use TexasHoldemBundle\Rules\HandRanking;

class Flush extends AbstractRanking
{
    /**
     * Check if there is a Flush in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function hasRanking(CardCollection $cards): bool
    {
        return $this->hasFlush($cards);
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
        $collection = [];
        $values = [];
        foreach ($cards->getCards() as $card) {
            $collection[] = $card->getSuit()->getName();
            $values[] = $card->getValue();
        }
        $suits = array_count_values($collection);
        arsort($suits);
        $keys = array_keys($collection, key($suits));
        $rankCards = [];
        foreach ($keys as $key) {
            $rankCards[] = $values[$key];
        }
        rsort($rankCards);

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
        return $rankCards;
    }
}
