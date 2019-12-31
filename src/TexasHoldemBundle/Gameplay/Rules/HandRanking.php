<?php

namespace TexasHoldemBundle\Gameplay\Rules;

class HandRanking
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

    public static function getName(int $ranking)
    {
        switch($ranking) {
            case self::HIGH_CARD:
                $name = 'High Card';
                break;
            case self::ONE_PAIR:
                $name = 'One Pair';
                break;
            case self::TWO_PAIR:
                $name = 'Two Pair';
                break;
            case self::THREE_OF_A_KIND:
                $name = 'Three of a kind';
                break;
            case self::STRAIGHT:
                $name = 'Straight';
                break;
            case self::FLUSH:
                $name = 'Flush';
                break;
            case self::FULL_HOUSE:
                $name = 'Full House';
                break;
            case self::FOUR_OF_A_KIND:
                $name = 'Four of a kind';
                break;
            case self::STRAIGHT_FLUSH:
                $name = 'Straight Flush';
                break;
            case self::ROYAL_FLUSH:
                $name = 'Royal Flush';
                break;
            default:
                $name = 'Invalid';
        }

        return $name;
    }
}
