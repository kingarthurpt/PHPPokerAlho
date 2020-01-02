<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Rules\HandRanking;

class HandRankingTest extends \Tests\BaseTestCase
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testGetName()
    {
        $expectedNames = [
            'High Card',
            'One Pair',
            'Two Pair',
            'Three of a kind',
            'Straight',
            'Flush',
            'Full House',
            'Four of a kind',
            'Straight Flush',
            'Royal Flush',
        ];

        $handRanking = HandRanking::getInstance();

        for ($i = 1; $i <= 10; ++$i) {
            $this->assertEquals($expectedNames[$i - 1], $handRanking->getName($i));
        }

        $this->assertEquals('Invalid', $handRanking->getName(0));
        $this->assertEquals('Invalid', $handRanking->getName(12));
    }
}
