<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Stringifier\RankingCardValue;
use TexasHoldemBundle\Stringifier\StandardCardValue;

class HandStrength
{
    /**
     * The hand ranking.
     *
     * @see HandRanking::class
     *
     * @var int
     */
    protected $ranking = 0;

    /**
     * If the ranking is HandRanking::ONE_PAIR, then this variable represents
     * the value of those two cards that form the pair.
     *
     * @var array
     */
    protected $rankCardValues = [];

    /**
     * A reverse sorted array containing the values of each kicker card.
     *
     * @var array
     */
    protected $kickers = [];

    /**
     * Constructor.
     *
     * @param int   $rank           The HandRanking
     * @param array $rankCardValues The Ranking Card's value
     * @param array $kickers        Array of kickers
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(int $rank, array $rankCardValues, array $kickers)
    {
        $this->ranking = $rank;
        $this->rankCardValues = $rankCardValues;
        $this->kickers = $kickers;

        $this->handRanking = HandRanking::getInstance();
    }

    /**
     * Returns a string representation of the HandStrength.
     *
     * @return string The HandStrength represented as a string
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __toString()
    {
        $rankingCardValue = RankingCardValue::getInstance();

        return $this->handRanking->getName($this->ranking).': '
            .$rankingCardValue->stringify($this->rankCardValues).'. '
            .'Kickers: '.$this->kickersToStr().'.';
    }

    /**
     * Get the hand's ranking.
     *
     * @return int The hand's ranking
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Get the hand's ranking card value.
     *
     * @return int The hand's ranking card value
     */
    public function getRankingCardValues()
    {
        return $this->rankCardValues;
    }

    /**
     * Get the array of kickers.
     *
     * @return array The array of kickers
     */
    public function getKickers()
    {
        return $this->kickers;
    }

    public function getValue()
    {
        return (float) sprintf(
            '%s%s.%s',
            $this->getRanking(),
            array_sum($this->getRankingCardValues()),
            array_sum($this->getKickers())
        );
    }

    /**
     * Gets the name(s) of the HandStrength kicker(s).
     *
     * @return string the kickers names
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function kickersToStr()
    {
        $str = '';
        $standardCardValue = StandardCardValue::getInstance();
        foreach ($this->kickers as $kicker) {
            $str .= $standardCardValue->stringify($kicker).', ';
        }
        $str = rtrim($str, ', ');

        return $str;
    }
}
