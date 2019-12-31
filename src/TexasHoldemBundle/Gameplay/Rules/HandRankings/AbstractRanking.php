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
}
