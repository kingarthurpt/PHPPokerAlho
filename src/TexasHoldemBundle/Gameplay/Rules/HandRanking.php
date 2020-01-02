<?php

namespace TexasHoldemBundle\Gameplay\Rules;

use TexasHoldemBundle\DesignPatterns\Singleton;

class HandRanking extends Singleton
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

    protected $rankingNames = [
        self::ROYAL_FLUSH => 'Royal Flush',
        self::STRAIGHT_FLUSH => 'Straight Flush',
        self::FOUR_OF_A_KIND => 'Four of a kind',
        self::FULL_HOUSE => 'Full House',
        self::FLUSH => 'Flush',
        self::STRAIGHT => 'Straight',
        self::THREE_OF_A_KIND => 'Three of a kind',
        self::TWO_PAIR => 'Two Pair',
        self::ONE_PAIR => 'One Pair',
        self::HIGH_CARD => 'High Card',
    ];

    /**
     * Get the name of a given ranking
     *
     * @param int $ranking
     *
     * @return string
     */
    public function getName(int $ranking): string
    {
        return isset($this->rankingNames[$ranking])
            ? $this->rankingNames[$ranking]
            : 'Invalid';
    }
}
