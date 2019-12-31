<?php

namespace TexasHoldemBundle\Gameplay\Rules;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Game\HandStrength;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\RankingMediator;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\RoyalFlush;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\StraightFlush;

/**
 * @todo: refactor this class by implementing the mediator design pattern to evaluate a hand
 * https://refactoring.guru/design-patterns/mediator/php/example
 */
class HandEvaluator
{
    /**
     * Compare an array of HandStrengths and return the same array sorted by
     * the best HandStrengths.
     *
     * @param array $hands
     *
     * @return array The sorted array of HandStrengths
     */
    public function compareHands(array $hands)
    {
        usort($hands, [$this, 'compareTwoHands']);

        return $hands;
    }

    /**
     * Gets the strength.
     *
     * @param CardCollection $cards
     *
     * @return HandStrength|null
     */
    public function getStrength(CardCollection $cards)
    {
        if ($cards->getSize() < 5 || $cards->getSize() > 7) {
            return null;
        }

        $rankingMediator = new RankingMediator();
        $ranking = $rankingMediator->getRanking($cards);
        $rankCardValues = $rankingMediator->getRankCardsValues($cards, $ranking);
        // $kickers = $rankingMediator->getKickers($cards, $ranking, $rankCardValues);
        $kickers = $this->getKickers($cards, $ranking, $rankCardValues);

        return new HandStrength($ranking, $rankCardValues, $kickers);
    }

    /**
     * Gets the ranking of a CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return int The value the ranking
     */
    private function getRanking(CardCollection $cards)
    {
        $ranking = HandRanking::HIGH_CARD;

        if ($this->hasRoyalFlush($cards)) {
            $ranking = HandRanking::ROYAL_FLUSH;
        } elseif ($this->hasStraightFlush($cards)) {
            $ranking = HandRanking::STRAIGHT_FLUSH;
        } elseif ($this->hasFourOfAKind($cards)) {
            $ranking = HandRanking::FOUR_OF_A_KIND;
        } elseif ($this->hasFullHouse($cards)) {
            $ranking = HandRanking::FULL_HOUSE;
        } elseif ($this->hasFlush($cards)) {
            $ranking = HandRanking::FLUSH;
        } elseif ($this->hasStraight($cards)) {
            $ranking = HandRanking::STRAIGHT;
        } elseif ($this->hasThreeOfAKind($cards)) {
            $ranking = HandRanking::THREE_OF_A_KIND;
        } elseif ($this->hasTwoPair($cards)) {
            $ranking = HandRanking::TWO_PAIR;
        } elseif ($this->hasOnePair($cards)) {
            $ranking = HandRanking::ONE_PAIR;
        }

        return $ranking;
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
    private function getKickers(CardCollection $cards, int $ranking, array $rankCards)
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

    /**
     * Check if there is a Royal Flush in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasRoyalFlush(CardCollection $cards)
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

    /**
     * Check if there is a Straight Flush in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasStraightFlush(CardCollection $cards)
    {
        return $this->hasStraight($cards) && $this->hasFlush($cards);
    }

    /**
     * Check if there is a Four of a kind in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasFourOfAKind(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return 4 == $values[0];
    }

    /**
     * Check if there is a Full House in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasFullHouse(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return 3 == $values[0] && $values[1] >= 2;
    }

    // /**
    //  * Check if there is a Flush in the CardCollection.
    //  *
    //  * @param CardCollection $cards
    //  *
    //  * @return bool TRUE on success, FALSE on failure
    //  */
    private function hasFlush(CardCollection $cards)
    {
        // Array of occurrences of each card's value
        $suits = [];
        foreach ($cards->getCards() as $card) {
            $suits[] = $card->getSuit()->getName();
        }

        // Count each suit occurrence
        $suits = array_count_values($suits);

        // The occurrence array gets sorted in reverse order
        rsort($suits, SORT_NUMERIC);

        return $suits[0] >= 5;
    }

    /**
     * Check if there is a Straight in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasStraight(CardCollection $cards)
    {
        // Array of occurrences of each card's value
        $values = array_fill(2, 13, 0);
        foreach ($cards->getCards() as $card) {
            ++$values[$card->getValue()];
        }

        // Duplicates the Ace to the end of the array
        $values[1] = $values[14];

        $hasStraight = false;
        for ($i = 1; $i <= count($values) - 4; ++$i) {
            if (0 == $values[$i]) {
                continue;
            }

            if ($values[$i] && $values[$i + 1] && $values[$i + 2]
                && $values[$i + 3] && $values[$i + 4]
            ) {
                $hasStraight = true;
                break;
            }
        }

        return $hasStraight;
    }

    /**
     * Check if there is a Three of a kind in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasThreeOfAKind(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return 3 == $values[0];
    }

    /**
     * Check if there is a Two pair in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasTwoPair(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return 2 == $values[0] && 2 == $values[1];
    }

    /**
     * Check if there is a One pair in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasOnePair(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return 2 == $values[0] && 1 == $values[1];
    }

    /**
     * Count the occurrences of each Card's value.
     *
     * @param CardCollection $cards
     *
     * @return array A sorted array in reverse order
     */
    private function countCardOccurrences(CardCollection $cards)
    {
        // Array of occurrences of each card's value
        $values = array_fill(2, 13, 0);
        foreach ($cards->getCards() as $card) {
            ++$values[$card->getValue()];
        }
        // The occurrence array gets sorted in reverse order
        rsort($values);

        return $values;
    }

    private function getPossibleKickers(CardCollection $cards, array $rankCards)
    {
        $kickers = [];
        foreach ($cards->getCards() as $card) {
            $kickers[$card->getValue()] = $card->getValue();
        }

        foreach ($rankCards as $card) {
            unset($kickers[$card]);
        }
        krsort($kickers);

        return $kickers;
    }

    private function getFourOfAKindKickers(array $possibleKickers)
    {
        return array_slice($possibleKickers, 0, 1);
    }

    private function getStraightKickers(array $possibleKickers)
    {
        return array_slice($possibleKickers, 0, 1);
    }

    private function getThreeOfAKindKickers(array $possibleKickers)
    {
        return array_slice($possibleKickers, 0, 2);
    }

    private function getTwoPairKickers(array $possibleKickers)
    {
        return array_slice($possibleKickers, 0, 1);
    }

    private function getOnePairKickers(array $possibleKickers)
    {
        return array_slice($possibleKickers, 0, 3);
    }

    private function getHighCardKickers(array $possibleKickers)
    {
        return array_slice($possibleKickers, 0, 4);
    }

    /**
     * Compare two HandStrengths.
     *
     * @param HandStrength $first  The first HandStrength
     * @param HandStrength $second The second HandStrength
     *
     * @return int 1 if the second hand is stronger than the first,
     *             -1 if the first hand is stronger than the second,
     *             0 if both hands have the same strength
     */
    private function compareTwoHands(HandStrength $first, HandStrength $second)
    {
        // Compare HandRankings
        if ($first->getRanking() > $second->getRanking()) {
            return -1;
        } elseif ($first->getRanking() < $second->getRanking()) {
            return 1;
        }

        // Both HandStrength's have the same HandRanking.
        // Compare their ranking Card values
        $result = $this->compareCardValues(
            $first->getRankingCardValues(),
            $second->getRankingCardValues()
        );
        if (0 != $result) {
            return $result;
        }

        // Both ranking Card values are the same.
        // Compare their kicker Card values
        return $this->compareCardValues($first->getKickers(), $second->getKickers());
    }

    /**
     * Compare two arrays of Card values.
     * Each array is sorted with a reverse order and contain the
     * values of each Card.
     *
     * @param array $firstKickers
     * @param array $secondKickers
     *
     * @return int
     */
    private function compareCardValues(array $firstKickers, array $secondKickers)
    {
        for ($i = 0; $i < count($firstKickers) || $i < count($secondKickers); ++$i) {
            if ($firstKickers[$i] > $secondKickers[$i]) {
                return -1;
            } elseif ($firstKickers[$i] < $secondKickers[$i]) {
                return 1;
            }
        }

        return 0;
    }
}
