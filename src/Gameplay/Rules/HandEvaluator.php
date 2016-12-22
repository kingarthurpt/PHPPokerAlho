<?php

namespace PHPPokerAlho\Gameplay\Rules;

use PHPPokerAlho\Gameplay\Cards\CardCollection;
use PHPPokerAlho\Gameplay\Game\CommunityCards;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class HandEvaluator
{
    const ROYAL_FLUSH = 10;
    const STRAIGHT_FLUSH = 9;
    const FOUR_OF_A_KIND = 8;
    const FULL_HOUSE = 7;
    const FLUSH = 6;
    const STRAIGHT = 5;
    const THREE_OF_A_KIND = 4;
    const TWO_PAIR = 3;
    const ONE_PAIR = 2;
    const HIGH_CARD = 1;

    public function __construct()
    {
    }

    /**
     * Get the strength
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards
     *
     * @return int
     */
    public function getStrength(CardCollection $cards)
    {
        if ($cards->getSize() != 7) {
            return -1;
        }

        if ($this->hasRoyalFlush($cards)) {
            // echo "Royal Flush\n";
            return self::ROYAL_FLUSH;
        }
        if ($this->hasStraightFlush($cards)) {
            // echo "Straight Flush\n";
            return self::STRAIGHT_FLUSH;
        }
        if ($this->hasFourOfAKind($cards)) {
            // echo "4 of a kind\n";
            return self::FOUR_OF_A_KIND;
        }
        if ($this->hasFullHouse($cards)) {
            // echo "Full house\n";
            return self::FULL_HOUSE;
        }
        if ($this->hasFlush($cards)) {
            // echo "Flush\n";
            return self::FLUSH;
        }
        if ($this->hasStraight($cards)) {
            // echo "Straight\n";
            return self::STRAIGHT;
        }
        if ($this->hasThreeOfAKind($cards)) {
            // echo "3 of a Kind\n";
            return self::THREE_OF_A_KIND;
        }
        if ($this->hasTwoPair($cards)) {
            // echo "2 pairs\n";
            return self::TWO_PAIR;
        }
        if ($this->hasOnePair($cards)) {
            // echo "1 pair\n";
            return self::ONE_PAIR;
        }
        return self::HIGH_CARD;
    }

    /**
     * Check if there is a Royal Flush in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasRoyalFlush(CardCollection $cards)
    {
        $royalCards = array(
            'A' => null,
            'K' => null,
            'Q' => null,
            'J' => null,
            'T' => null,
        );

        foreach ($cards->getCards() as $key => $card) {
            if (array_key_exists($card->getFaceValue(), $royalCards)) {
                $royalCards[$card->getFaceValue()] = $card->getSuit();
            }
        }

        // TRUE if all $royalCards elements are not null
        $hasAllRoyalCards = count(array_filter($royalCards)) == 5;

        return $hasAllRoyalCards && $this->hasFlush($cards) ? true : false;
    }

    /**
     * Check if there is a Straight Flush in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasStraightFlush(CardCollection $cards)
    {
        return $this->hasStraight($cards) && $this->hasFlush($cards);
    }

    /**
     * Check if there is a Four of a kind in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasFourOfAKind(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return $values[0] == 4;
    }

    /**
     * Check if there is a Full House in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasFullHouse(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return $values[0] == 3 && $values[1] >= 2;
    }

    /**
     * Check if there is a Flush in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasFlush(CardCollection $cards)
    {
        // Array of occurrences of each card's value
        $suits = array();
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
     * Check if there is a Straight in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasStraight(CardCollection $cards)
    {
        // Array of occurrences of each card's value
        $values = array_fill(1, 13, 0);
        foreach ($cards->getCards() as $card) {
            $values[$card->getValue()]++;
        }

        // Duplicates the Ace to the end of the array
        $values[14] = $values[1];

        $hasStraight = false;
        for ($i = 1; $i <= count($values) - 4; $i++) {
            if ($values[$i] == 0) {
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
     * Check if there is a Three of a kind in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasThreeOfAKind(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return $values[0] == 3;
    }

    /**
     * Check if there is a Two pair in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasTwoPair(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return $values[0] == 2 && $values[1] == 2;
    }

    /**
     * Check if there is a One pair in the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasOnePair(CardCollection $cards)
    {
        $values = $this->countCardOccurrences($cards);

        return $values[0] == 2 && $values[1] == 1;
    }

    /**
     * Count the occurrences of each Card's value
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards [description]
     *
     * @return array A sorted array in reverse order
     */
    private function countCardOccurrences(CardCollection $cards)
    {
        // Array of occurrences of each card's value
        $values = array_fill(1, 13, 0);
        foreach ($cards->getCards() as $card) {
            $values[$card->getValue()]++;
        }
        // The occurrence array gets sorted in reverse order
        rsort($values);

        return $values;
    }
}
