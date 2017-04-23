<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Rules\HandRanking;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class HandRankingTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandRanking::getName
     *
     * @since  nextRelease
     */
    public function testGetName()
    {
        $instance = new HandRanking();
        $this->assertEquals('Royal Flush', $instance->getName(HandRanking::ROYAL_FLUSH));
        $this->assertEquals('Straight Flush', $instance->getName(HandRanking::STRAIGHT_FLUSH));
        $this->assertEquals('Four of a Kind', $instance->getName(HandRanking::FOUR_OF_A_KIND));
        $this->assertEquals('Full House', $instance->getName(HandRanking::FULL_HOUSE));
        $this->assertEquals('Flush', $instance->getName(HandRanking::FLUSH));
        $this->assertEquals('Straight', $instance->getName(HandRanking::STRAIGHT));
        $this->assertEquals('Three of a Kind', $instance->getName(HandRanking::THREE_OF_A_KIND));
        $this->assertEquals('Two Pair', $instance->getName(HandRanking::TWO_PAIR));
        $this->assertEquals('One Pair', $instance->getName(HandRanking::ONE_PAIR));
        $this->assertEquals('High Card', $instance->getName(HandRanking::HIGH_CARD));
        $this->assertEquals('Unknown', $instance->getName(0));
        $this->assertEquals('Unknown', $instance->getName(11));
    }
}
