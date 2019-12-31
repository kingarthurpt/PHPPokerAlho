<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Rules\HandRanking;

class HandRankingTest extends \Tests\BaseTestCase
{
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

        for ($i = 1; $i <= 10; ++$i) {
            $this->assertEquals($expectedNames[$i - 1], HandRanking::getName($i));
        }

        $this->assertEquals('Invalid', HandRanking::getName(0));
        $this->assertEquals('Invalid', HandRanking::getName(12));
    }
}
