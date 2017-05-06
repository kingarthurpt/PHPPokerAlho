<?php

namespace TexasHoldemBundle\Gameplay\Rules;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class HandRanking
{
    /**
     * @var integer
     */
    const ROYAL_FLUSH = 10;

    /**
     * @var integer
     */
    const STRAIGHT_FLUSH = 9;

    /**
     * @var integer
     */
    const FOUR_OF_A_KIND = 8;

    /**
     * @var integer
     */
    const FULL_HOUSE = 7;

    /**
     * @var integer
     */
    const FLUSH = 6;

    /**
     * @var integer
     */
    const STRAIGHT = 5;

    /**
     * @var integer
     */
    const THREE_OF_A_KIND = 4;

    /**
     * @var integer
     */
    const TWO_PAIR = 3;

    /**
     * @var integer
     */
    const ONE_PAIR = 2;

    /**
     * @var integer
     */
    const HIGH_CARD = 1;

    /**
     * Get the name of a given HandRanking
     *
     * @since  {nextRelease}
     *
     * @param  int $ranking The HandRanking
     *
     * @return string The HandRanking's name
     */
    public static function getName(int $ranking)
    {
        switch ($ranking) {
            case HandRanking::ROYAL_FLUSH:
                $rank = "Royal Flush";
                break;
            case HandRanking::STRAIGHT_FLUSH:
                $rank = "Straight Flush";
                break;
            case HandRanking::FOUR_OF_A_KIND:
                $rank = "Four of a Kind";
                break;
            case HandRanking::FULL_HOUSE:
                $rank = "Full House";
                break;
            case HandRanking::FLUSH:
                $rank = "Flush";
                break;
            case HandRanking::STRAIGHT:
                $rank = "Straight";
                break;
            case HandRanking::THREE_OF_A_KIND:
                $rank = "Three of a Kind";
                break;
            case HandRanking::TWO_PAIR:
                $rank = "Two Pair";
                break;
            case HandRanking::ONE_PAIR:
                $rank = "One Pair";
                break;
            case HandRanking::HIGH_CARD:
                $rank = "High Card";
                break;
            default:
                $rank = "Unknown";
        }
        return $rank;
    }
}
