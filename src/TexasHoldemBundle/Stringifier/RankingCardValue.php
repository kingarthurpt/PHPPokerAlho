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
     * @return string the ranking Crads names
     */
    public function stringify(int $ranking, array $rankCardValues)
    {
        $rankCardStr = '';
        switch ($ranking) {
            case HandRanking::ONE_PAIR:
            case HandRanking::TWO_PAIR:
            case HandRanking::THREE_OF_A_KIND:
            case HandRanking::FULL_HOUSE:
            case HandRanking::FOUR_OF_A_KIND:
                $rankCardStr = $this->rankingCardValuesToStr($rankCardValues, true);
                break;
            case HandRanking::FLUSH:
                break;
            default:
                $rankCardStr = $this->rankingCardValuesToStr($rankCardValues);
        }

        return $rankCardStr;
    }

    /**
     * Gets the name(s) of the HandStrength ranking Card(s).
     *
     * @todo The method rankingCardValuesToStr has a boolean flag argument $plural,
     * which is a certain sign of a Single Responsibility Principle violation.
     *
     * @param bool $plural [optional] <p>
     *                     If given and is <b>TRUE</b>, gets the Card name in the plural form,
     *                     <b>FALSE</b> otherwise
     *
     * @return string The ranking Cards name
     */
    private function rankingCardValuesToStr(array $rankCardValues, bool $plural = false)
    {
        $str = '';
        $standardCardValue = StandardCardValue::getInstance();
        foreach ($rankCardValues as $cardValue) {
            $str .= $standardCardValue->stringify($cardValue);
            $str .= $plural ? 's, ' : ', ';
        }
        $str = rtrim($str, ', ');
        $pos = strrpos($str, ', ');
        if (false !== $pos) {
            $str = substr_replace($str, ' and ', $pos, strlen(', '));
        }

        return $str;
    }
}
