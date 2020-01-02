<?php

namespace TexasHoldemBundle\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;

abstract class AbstractRanking
{
    abstract public function hasRanking(CardCollection $cards): bool;

    /**
     * Check if there is a Flush in the CardCollection.
     *
     * @param CardCollection $cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    protected function hasFlush(CardCollection $cards)
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
    protected function hasStraight(CardCollection $cards)
    {
        // Array of occurrences of each card's value
        $values = array_fill(2, 13, 0);
        foreach ($cards->getCards() as $card) {
            ++$values[$card->getValue()];
        }

        // Sums all card's values which have at least one occurrence
        $values = array_filter($values, function($element) {
            return $element != 0;
        });
        $sum = array_sum(array_keys($values));

        $sumsOfCardsWithStraight = [20, 25, 28, 30, 35, 40, 45, 50, 55, 60];

        return in_array($sum, $sumsOfCardsWithStraight);
    }

    /**
     * Count the occurrences of each Card's value.
     *
     * @param CardCollection $cards
     *
     * @return array A sorted array in reverse order
     */
    protected function countCardOccurrences(CardCollection $cards)
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

    protected function getStraightValue(CardCollection $cards)
    {
        $straightSumCombinations = [
            28 => [5, 4, 3, 2, 14],
            20 => [6, 5, 4, 3, 2],
            25 => [7, 6, 5, 4, 3],
            30 => [8, 7, 6, 5, 4],
            35 => [9, 8, 7, 6, 5],
            40 => [10, 9, 8, 7, 6],
            45 => [11, 10, 9, 8, 7],
            50 => [12, 11, 10, 9, 8],
            55 => [13, 12, 11, 10, 9],
            60 => [14, 13, 12, 11, 10]
        ];
        $occurrences = $this->getOccurrences($cards);

        // Sums all card's values which have at least one occurrence
        $occurrences = array_filter($occurrences, function($element) {
            return $element != 0;
        });
        $sum = array_sum(array_keys($occurrences));

        return $straightSumCombinations[$sum];
    }

    protected function getCardOccurrencesAddWheel(CardCollection $cards)
    {
        $occurrences = $this->getOccurrences($cards);
        $occurrences[1] = $occurrences[14];

        return $occurrences;
    }

    protected function getCardOccurrences(CardCollection $cards)
    {
        $occurrences = $this->getOccurrences($cards);

        // Sort occurrences by value
        arsort($occurrences);
        // Sort keys in reverse to get highest value first
        krsort($occurrences);
        // Remove keys with empty occurrences
        $occurrences = array_filter($occurrences, function ($element) {
            return $element !== 0;
        });
        // Re sort occurrences by value
        arsort($occurrences);

        return $occurrences;
    }

    protected function getOccurrences(CardCollection $cards)
    {
        $occurrences = array_fill_keys(range(14, 2), 0);
        foreach ($cards->getCards() as $card) {
            ++$occurrences[$card->getValue()];
        }

        return $occurrences;
    }

    protected function getPossibleKickers(CardCollection $cards, array $rankCards)
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
}
