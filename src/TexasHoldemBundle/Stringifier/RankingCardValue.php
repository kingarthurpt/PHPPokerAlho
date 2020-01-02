<?php

namespace TexasHoldemBundle\Stringifier;

use TexasHoldemBundle\DesignPatterns\Singleton;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;

class RankingCardValue extends Singleton
{
    /**
     * Based on the HandStrength ranking gets the name
     * of the HandStrength rankingCardValues.
     *
     * Gets the name(s) of the HandStrength ranking Card(s).
     *
     * @return string the ranking Crads names
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function stringify(array $rankCardValues)
    {
        $str = '';
        $standardCardValue = StandardCardValue::getInstance();
        foreach ($rankCardValues as $cardValue) {
            $str = sprintf('%s%s, ', $str, $standardCardValue->stringify($cardValue));
        }
        $str = rtrim($str, ', ');
        $pos = strrpos($str, ', ');
        if (false !== $pos) {
            $str = substr_replace($str, ' and ', $pos, strlen(', '));
        }

        return $str;
    }
}
