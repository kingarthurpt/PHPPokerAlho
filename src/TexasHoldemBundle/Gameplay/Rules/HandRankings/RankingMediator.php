<?php

namespace TexasHoldemBundle\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;

class RankingMediator
{
    private $combinations;

    public function __construct()
    {
        $this->combinations = [
            HandRanking::ROYAL_FLUSH => new RoyalFlush(),
            HandRanking::STRAIGHT_FLUSH => new StraightFlush(),
            HandRanking::FOUR_OF_A_KIND => new FourOfAKind(),
            HandRanking::FULL_HOUSE => new FullHouse(),
            HandRanking::FLUSH => new Flush(),
            HandRanking::STRAIGHT => new Straight(),
            HandRanking::THREE_OF_A_KIND => new ThreeOfAKind(),
            HandRanking::TWO_PAIR => new TwoPairs(),
            HandRanking::ONE_PAIR => new OnePair(),
            HandRanking::HIGH_CARD => new HighCard(),
        ];
    }

    public function getRanking(CardCollection $cards): int
    {
        $ranking = 2 == $cards->getSize()
            ? HandRanking::ONE_PAIR
            : HandRanking::ROYAL_FLUSH;

        while (!$this->combinations[$ranking]->hasRanking($cards)) {
            --$ranking;
        }

        return $ranking;
    }

    public function getRankCardsValues(CardCollection $cards, int $ranking): array
    {
        return isset($this->combinations[$ranking])
            ? $this->combinations[$ranking]->getValue($cards)
            : [];
    }

    /**
     * Gets the kickers for a given ranking and card values.
     *
     * @param CardCollection $cards
     * @param int            $ranking
     * @param array          $rankCards
     *
     * @return array The kickers
     */
    public function getKickers(CardCollection $cards, int $ranking, array $rankCards)
    {
        return isset($this->combinations[$ranking])
            ? $this->combinations[$ranking]->getKickers($cards, $rankCards)
            : [];
    }
}
