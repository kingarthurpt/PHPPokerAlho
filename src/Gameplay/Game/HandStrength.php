<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Rules\HandRanking;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
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
     * the value of those two cards that form the pair
     *
     * @var array
     */
    protected $rankCardValues = array();

    /**
     * A reverse sorted array containing the values of each kicker card
     *
     * @var array
     */
    protected $kickers = array();

    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param  int $rank The HandRanking
     * @param  array $rankCardValues The Ranking Card's value
     * @param  array $kickers Array of kickers
     */
    public function __construct(int $rank, array $rankCardValues, array $kickers)
    {
        $this->ranking = $rank;
        $this->rankCardValues = $rankCardValues;
        $this->kickers = $kickers;
    }

    public function __toString()
    {
        return HandRanking::getName($this->ranking);
    }

    /**
     * Get the hand's ranking
     *
     * @since  {nextRelease}
     *
     * @return int The hand's ranking
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Get the hand's ranking card value
     *
     * @since  {nextRelease}
     *
     * @return int The hand's ranking card value
     */
    public function getRankingCardValues()
    {
        return $this->rankCardValues;
    }

    /**
     * Get the array of kickers
     *
     * @since  {nextRelease}
     *
     * @return array The array of kickers
     */
    public function getKickers()
    {
        return $this->kickers;
    }
}
