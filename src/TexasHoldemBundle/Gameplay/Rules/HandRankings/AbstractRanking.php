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
        $occurrences = $this->getCardOccurrencesAddWheel($cards);
        for ($i = count($occurrences); $i >= 5; --$i) {
            if (0 == $occurrences[$i]) {
                continue;
            }

            if ($occurrences[$i] && $occurrences[$i - 1] && $occurrences[$i - 2]
                && $occurrences[$i - 3] && $occurrences[$i - 4]
            ) {
                $rankCards = [$i--, $i--, $i--, $i--, $i--];
                break;
            }
        }
        $rankCards[4] = (1 === $rankCards[4]) ? 14 : $rankCards[4];

        return $rankCards;
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
