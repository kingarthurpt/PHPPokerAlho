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
        $ranking = HandRanking::ROYAL_FLUSH;
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
        $kickers = [];
        $possibleKickers = $this->getPossibleKickers($cards, $rankCards);
        switch ($ranking) {
            case HandRanking::ROYAL_FLUSH:
                $kickers = $this->getStraightKickers($rankCards);
                break;
            case HandRanking::STRAIGHT_FLUSH:
                $kickers = $this->getStraightKickers($rankCards);
                break;
            case HandRanking::FOUR_OF_A_KIND:
                $kickers = $this->getFourOfAKindKickers($possibleKickers);
                break;
            case HandRanking::FULL_HOUSE:
                $kickers = $rankCards;
                break;
            case HandRanking::FLUSH:
                $kickers = $rankCards;
                break;
            case HandRanking::STRAIGHT:
                $kickers = $this->getStraightKickers($rankCards);
                break;
            case HandRanking::THREE_OF_A_KIND:
                $kickers = $this->getThreeOfAKindKickers($possibleKickers);
                break;
            case HandRanking::TWO_PAIR:
                $kickers = $this->getTwoPairKickers($possibleKickers);
                break;
            case HandRanking::ONE_PAIR:
                $kickers = $this->getOnePairKickers($possibleKickers);
                break;
            case HandRanking::HIGH_CARD:
                $kickers = $this->getHighCardKickers($possibleKickers);
                break;
        }

        return $kickers;
    }
}
